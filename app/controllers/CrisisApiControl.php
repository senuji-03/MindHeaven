<?php

class CrisisApiControl {

    /**
     * POST /api/crisis/connect
     * Caller (Student) requests an emergency crisis audio room via Daily.co.
     */
    public function connect() {
        header('Content-Type: application/json');

        $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

        if (!defined('DAILY_API_KEY')) {
            http_response_code(500);
            echo json_encode(['error' => 'API key not configured']);
            return;
        }

        $dailyRoomName = 'mindheaven-crisis-' . time() . '-' . $userId;
        $postData = [
            'name'       => $dailyRoomName,
            'properties' => [
                'exp'             => time() + 7200, // 2 hours max
                'enable_chat'     => false,
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

        $response = curl_exec($ch);
        $curlError = curl_errno($ch);
        curl_close($ch);

        if (!$curlError) {
            $result = json_decode($response, true);
            if (!empty($result['url'])) {
                // Record the crisis call in the DB
                try {
                    $pdo = Database::getConnection();
                    $stmt = $pdo->prepare(
                        "INSERT INTO crisis_calls (caller_user_id, daily_room_url, status) VALUES (?, ?, 'waiting')"
                    );
                    $stmt->execute([$userId ?: 1, $result['url']]);
                    echo json_encode(['url' => $result['url']]);
                    return;
                } catch (Exception $e) {
                    error_log("Crisis DB Error: " . $e->getMessage());
                    // Still return the url even if DB fails
                    echo json_encode(['url' => $result['url']]);
                    return;
                }
            }
            error_log("Daily.co crisis room error: " . $response);
        } else {
            error_log("Daily.co cURL error for crisis connect");
        }

        http_response_code(503);
        echo json_encode(['error' => 'Could not connect to crisis service. Please call 988.']);
    }

    /**
     * GET /api/crisis/waiting
     * Responder polls for waiting calls
     */
    public function getWaitingCalls() {
        header('Content-Type: application/json');

        $role = $_SESSION['role'] ?? '';
        if (!in_array($role, ['call_responder', 'admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        try {
            $pdo = Database::getConnection();
            $sql = "SELECT c.id, c.caller_user_id, c.daily_room_url, c.status, c.created_at,
                           COALESCE(u.full_name, u.username, 'Anonymous Student') AS caller_name 
                    FROM crisis_calls c 
                    LEFT JOIN users u ON c.caller_user_id = u.id 
                    WHERE c.status = 'waiting' 
                    ORDER BY c.created_at ASC";
            $stmt = $pdo->query($sql);
            echo json_encode(['calls' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (Exception $e) {
            echo json_encode(['calls' => []]);
        }
    }

    /**
     * POST /api/crisis/answer
     * Responder answers a waiting call
     */
    public function answerCall() {
        header('Content-Type: application/json');

        $role = $_SESSION['role'] ?? '';
        if (!in_array($role, ['call_responder', 'admin'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data   = json_decode(file_get_contents('php://input'), true);
        $callId = (int)($data['call_id'] ?? 0);

        if (!$callId) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid call ID']);
            return;
        }

        try {
            $pdo  = Database::getConnection();
            $stmt = $pdo->prepare(
                "UPDATE crisis_calls SET status = 'in_progress', responder_user_id = ? WHERE id = ? AND status = 'waiting'"
            );
            $stmt->execute([$_SESSION['user_id'], $callId]);

            $stmt = $pdo->prepare("SELECT daily_room_url FROM crisis_calls WHERE id = ?");
            $stmt->execute([$callId]);
            $row  = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'url' => $row['daily_room_url'] ?? '']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'DB error']);
        }
    }

    /**
     * POST /api/crisis/update
     * Responder saves notes and marks call complete
     */
    public function updateCall() {
        header('Content-Type: application/json');

        $data   = json_decode(file_get_contents('php://input'), true);
        $callId = (int)($data['call_id'] ?? 0);
        $status = $data['status'] ?? 'completed';
        $notes  = trim($data['notes'] ?? '');

        if (!$callId) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            return;
        }

        try {
            $pdo  = Database::getConnection();
            $stmt = $pdo->prepare(
                "UPDATE crisis_calls SET status = ?, notes = ? WHERE id = ?"
            );
            $stmt->execute([$status, $notes, $callId]);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'DB error']);
        }
    }
}
