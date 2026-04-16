<?php

class CrisisApiControl
{

    /**
     * POST /api/crisis/connect
     * Caller (Student) requests an emergency crisis audio room via Daily.co.
     */
    public function connect()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }

        $userId = (int) $_SESSION['user_id'];

        if (!defined('DAILY_API_KEY') || empty(DAILY_API_KEY)) {
            // If no Daily API key, return a mock URL for testing
            error_log("DAILY_API_KEY not configured - returning mock response");
            http_response_code(503);
            echo json_encode(['error' => 'Crisis service not configured. Please call 988.']);
            return;
        }

        $dailyRoomName = 'mh-crisis-' . time() . '-' . $userId;
        $postData = [
            'name' => $dailyRoomName,
            'properties' => [
                'exp' => time() + 7200, // 2 hours max
                'enable_chat' => false,
                'start_audio_off' => false,
                'start_video_off' => true  // Audio Only
            ]
        ];

        $ch = curl_init('https://api.daily.co/v1/rooms');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . DAILY_API_KEY,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $curlError = curl_errno($ch);
        curl_close($ch);

        if ($curlError) {
            error_log("Daily.co cURL error for crisis connect: " . $curlError);
            http_response_code(503);
            echo json_encode(['error' => 'Could not reach crisis service. Please call 988.']);
            return;
        }

        $result = json_decode($response, true);
        if (empty($result['url'])) {
            error_log("Daily.co crisis room error: " . $response);
            http_response_code(503);
            echo json_encode(['error' => 'Could not create crisis room. Please call 988.']);
            return;
        }

        // Record the crisis call in DB
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare(
                "INSERT INTO crisis_calls 
                    (caller_user_id, caller_name, caller_phone, crisis_type, severity_level, description, daily_room_url, status) 
                 VALUES (?, ?, ?, 'other', 'high', 'Emergency audio hotline request', ?, 'waiting')"
            );
            $callerName = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Anonymous Student';
            $callerPhone = $_SESSION['phone'] ?? '000-000-0000';
            $stmt->execute([$userId, $callerName, $callerPhone, $result['url']]);
            $callId = $pdo->lastInsertId();
        } catch (Exception $e) {
            error_log("Crisis DB insert error: " . $e->getMessage());
            // Still let the student join if DB fails
            $callId = null;
        }

        echo json_encode([
            'url' => $result['url'],
            'call_id' => $callId
        ]);
    }

    /**
     * GET /api/crisis/waiting
     * Responder polls for waiting calls
     */
    public function getWaitingCalls()
    {
        header('Content-Type: application/json');

        $role = $_SESSION['role'] ?? '';
        if (!in_array($role, ['call_responder', 'admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        try {
            $pdo = Database::getConnection();
            $sql = "SELECT 
                        c.id,
                        c.caller_user_id,
                        c.daily_room_url,
                        c.status,
                        c.created_at,
                        COALESCE(c.caller_name, u.full_name, u.username, 'Anonymous Student') AS caller_name
                    FROM crisis_calls c
                    LEFT JOIN users u ON c.caller_user_id = u.id
                    WHERE c.status = 'waiting'
                    ORDER BY c.created_at ASC";
            $stmt = $pdo->query($sql);
            echo json_encode(['calls' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (Exception $e) {
            error_log("Crisis waiting query error: " . $e->getMessage());
            echo json_encode(['calls' => []]);
        }
    }

    /**
     * POST /api/crisis/answer
     * Responder answers a waiting call — marks it in_progress and returns the room URL
     */
    public function answerCall()
    {
        header('Content-Type: application/json');

        $role = $_SESSION['role'] ?? '';
        if (!in_array($role, ['call_responder', 'admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $callId = (int) ($data['call_id'] ?? 0);

        if (!$callId) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid call ID']);
            return;
        }

        try {
            $pdo = Database::getConnection();

            // Mark as in_progress (only if it's still waiting to prevent double-answer)
            $stmt = $pdo->prepare(
                "UPDATE crisis_calls 
                    SET status = 'in_progress', responder_user_id = ?
                  WHERE id = ? AND status = 'waiting'"
            );
            $stmt->execute([$_SESSION['user_id'], $callId]);
            $rowsUpdated = $stmt->rowCount();

            if ($rowsUpdated === 0) {
                // Call was already taken by another responder
                echo json_encode(['error' => 'This call has already been answered by another responder.']);
                return;
            }

            // Fetch the room URL
            $stmt = $pdo->prepare("SELECT daily_room_url FROM crisis_calls WHERE id = ?");
            $stmt->execute([$callId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($row['daily_room_url'])) {
                echo json_encode(['error' => 'Room URL not found for this call.']);
                return;
            }

            echo json_encode(['success' => true, 'url' => $row['daily_room_url']]);
        } catch (Exception $e) {
            error_log("Crisis answer error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }

    /**
     * POST /api/crisis/update
     * Responder saves notes and marks call complete
     */
    public function updateCall()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $callId = (int) ($data['call_id'] ?? 0);
        $status = in_array($data['status'] ?? '', ['completed', 'escalated']) ? $data['status'] : 'completed';
        $notes = trim($data['notes'] ?? '');

        if (!$callId) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            return;
        }

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare(
                "UPDATE crisis_calls SET status = ?, notes = ?, response_notes = ? WHERE id = ?"
            );
            $stmt->execute([$status, $notes, $notes, $callId]);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("Crisis update error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }

    /**
     * POST /api/crisis/notes
     * Counselor saves intervention notes for an escalated call
     */
    public function saveInterventionNotes()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'counselor') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $callId = (int) ($data['call_id'] ?? 0);
        $notes = trim($data['notes'] ?? '');

        if (!$callId || empty($notes)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing call ID or notes']);
            return;
        }

        try {
            require_once BASE_PATH . '/app/models/CrisisIntervention.php';
            $interventionModel = new CrisisIntervention();
            $success = $interventionModel->save($callId, $_SESSION['user_id'], $notes);

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Failed to save notes']);
            }
        } catch (Exception $e) {
            error_log("Crisis intervention notes error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
    }
}
