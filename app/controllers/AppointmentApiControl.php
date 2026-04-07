<?php

class AppointmentApiControl
{
    private $appointmentModel;

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
    }

    /**
     * List appointments for the currently logged-in student
     */
    public function listForStudent()
    {
        if (empty($_SESSION['user_id'])) {
            return $this->json(['error' => 'Not logged in'], 401);
        }

        try {
            $rows = $this->appointmentModel->getByStudentUserId((int)$_SESSION['user_id']);
            $this->json($rows);
        } catch (Throwable $e) {
            error_log("AppointmentApiControl listForStudent error: " . $e->getMessage());
            $this->json(['error' => 'Failed to fetch appointments', 'detail' => $e->getMessage()], 500);
        }
    }

    /**
     * List appointments for the currently logged-in counselor
     */
    public function listForCounselor()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            return $this->json(['error' => 'Not logged in'], 401);
        }

        try {
            $rows = $this->appointmentModel->getByCounselorUserId((int)$_SESSION['user_id']);

            // Map database rows to the structure expected by the counselor UI
            $appointments = array_map(function ($row) {
                return [
                    'id' => isset($row['id']) ? (int)$row['id'] : null,
                    'patientName' => isset($row['student_name']) ? $row['student_name'] : 'Unknown student',
                    'reason' => isset($row['title']) ? $row['title'] : '',
                    'requestedDate' => isset($row['date']) ? $row['date'] : '',
                    'requestedTime' => isset($row['time']) ? $row['time'] : '',
                    'notes' => isset($row['notes']) ? $row['notes'] : '',
                    'email' => '',
                    'phone' => '',
                    'duration' => '60 minutes',
                    'mediaType' => isset($row['type']) ? $row['type'] : 'video',
                    'status' => isset($row['status']) ? $row['status'] : 'pending',
                    'urgency' => 'medium',
                ];
            }, $rows);

            $this->json($appointments);
        } catch (Throwable $e) {
            error_log("AppointmentApiControl listForCounselor error: " . $e->getMessage());
            $this->json(['error' => 'Failed to fetch appointments', 'detail' => $e->getMessage()], 500);
        }
    }

    public function listCounselors()
    {
        try {
            $pdo = Database::getConnection();

            // First try to get counselors from the counselors table
            try {
                $stmt = $pdo->prepare("
                    SELECT u.id, u.username, c.full_name, c.specialization, c.is_available, (u.account_status = 'active') as is_approved
                    FROM users u 
                    INNER JOIN counselors c ON u.id = c.user_id 
                    WHERE u.role = 'counselor'
                    ORDER BY c.full_name
                ");
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($rows) > 0) {
                    $this->json($rows);
                    return;
                }
            } catch (Exception $e) {
                error_log("AppointmentApiControl: Counselors table query failed: " . $e->getMessage());
            }

            // Fallback: Get counselors from users table only
            $stmt = $pdo->prepare("
                SELECT id, username, full_name, '' as specialization, 1 as is_available, 1 as is_approved
                FROM users 
                WHERE role = 'counselor'
                ORDER BY full_name, username
            ");
            $stmt->execute();
            $this->json($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Throwable $e) {
            error_log("AppointmentApiControl listCounselors error: " . $e->getMessage());
            $this->json(['error' => 'Failed to fetch counselors', 'detail' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        $data = $this->getJsonInput();
        $userId = (int)($_SESSION['user_id'] ?? 0);

        if (!$userId) {
            return $this->json(['error' => 'Not logged in'], 401);
        }

        // Validate required fields
        $required = ['counselor_user_id', 'title', 'type', 'date', 'time'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->json(['error' => "'$field' is required"], 400);
            }
        }

        // Normalise time slot to HH:MM and validate
        $allowedSlots = ['09:00', '13:00', '16:00'];
        $timeVal = substr(trim((string)$data['time']), 0, 5);
        if (!in_array($timeVal, $allowedSlots, true)) {
            return $this->json(['error' => 'Invalid time slot. Choose 9:00 AM, 1:00 PM, or 4:00 PM.'], 400);
        }
        $dbTime = $timeVal . ':00'; // MySQL TIME = HH:MM:SS

        // Validate mode
        $allowedModes = ['audio_video', 'chat'];
        $mode = trim((string)($data['mode'] ?? 'audio_video'));
        if (!in_array($mode, $allowedModes, true)) {
            $mode = 'audio_video'; // safe default
        }

        try {
            $pdo = Database::getConnection();

            // ── Auto-migrate: add `mode` column if the table doesn't have it yet ──
            $cols = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'mode'")->fetchAll();
            if (empty($cols)) {
                $pdo->exec("ALTER TABLE appointments ADD COLUMN `mode` VARCHAR(20) NOT NULL DEFAULT 'audio_video' AFTER `type`");
                error_log('AppointmentApiControl: auto-added mode column to appointments table');
            }

            // Check the slot is not already booked for this counselor
            $chk = $pdo->prepare("
                SELECT COUNT(*) FROM appointments
                WHERE counselor_user_id = ? AND date = ? AND time = ?
                  AND status NOT IN ('cancelled', 'rejected')
            ");
            $chk->execute([(int)$data['counselor_user_id'], $data['date'], $dbTime]);
            if ((int)$chk->fetchColumn() > 0) {
                return $this->json(['error' => 'This time slot is already booked. Please choose another.'], 409);
            }

            $id = $this->appointmentModel->create(
                $userId,
                (int)$data['counselor_user_id'],
                trim((string)$data['title']),
                trim((string)$data['type']),
                $mode,
                $data['date'],
                $dbTime,
                trim((string)($data['notes'] ?? ''))
            );

            if ($id) {
                $this->json(['message' => 'Appointment created', 'id' => $id], 201);
            } else {
                $this->json(['error' => 'Database insert returned no ID'], 500);
            }
        } catch (Throwable $e) {
            error_log('AppointmentApiControl create error: ' . $e->getMessage());
            // Return real error so it's visible in browser console
            $this->json([
                'error'  => 'Failed to create appointment',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/appointments/slots?counselor_id=X&date=YYYY-MM-DD
     * Returns which of the 3 fixed time slots are already booked.
     */
    public function getSlots()
    {
        $counselorId = (int)($_GET['counselor_id'] ?? 0);
        $date        = $_GET['date'] ?? '';

        if (!$counselorId || !$date) {
            return $this->json(['error' => 'counselor_id and date are required'], 400);
        }

        // Validate date format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->json(['error' => 'Invalid date format'], 400);
        }

        try {
            $pdo  = Database::getConnection();
            $stmt = $pdo->prepare("
                SELECT TIME_FORMAT(time, '%H:%i') AS slot
                FROM appointments
                WHERE counselor_user_id = ?
                  AND date = ?
                  AND status NOT IN ('cancelled', 'rejected')
            ");
            $stmt->execute([$counselorId, $date]);
            $booked = $stmt->fetchAll(PDO::FETCH_COLUMN);

            $this->json([
                'date'    => $date,
                'booked'  => $booked,
                'all'     => ['09:00', '13:00', '16:00']
            ]);
        } catch (Throwable $e) {
            error_log("AppointmentApiControl getSlots error: " . $e->getMessage());
            $this->json(['booked' => [], 'all' => ['09:00', '13:00', '16:00']]);
        }
    }

    public function delete()
    {
        $data = $this->getJsonInput();
        if (!isset($data['id'])) {
            return $this->json(['error' => 'Appointment ID required'], 400);
        }

        try {
            $result = $this->appointmentModel->delete((int)$data['id']);
            if ($result) {
                $this->json(['message' => 'Appointment deleted']);
            } else {
                $this->json(['error' => 'Appointment not found'], 404);
            }
        } catch (Throwable $e) {
            error_log("AppointmentApiControl delete error: " . $e->getMessage());
            $this->json(['error' => 'Failed to delete appointment'], 500);
        }
    }

    public function updateStatus()
    {
        $data = $this->getJsonInput();

        if (!isset($data['id']) || $data['id'] === '') {
            return $this->json(['error' => 'Appointment ID is required'], 400);
        }
        if (!isset($data['status']) || $data['status'] === '') {
            return $this->json(['error' => 'Status is required'], 400);
        }

        $allowedStatuses = ['pending', 'accept', 'accepted', 'rejected', 'scheduled', 'confirmed'];
        if (!in_array($data['status'], $allowedStatuses, true)) {
            return $this->json(['error' => 'Invalid status value'], 400);
        }

        try {
            $result = $this->appointmentModel->updateStatus((int)$data['id'], $data['status']);

            if ($result) {
                $this->json(['message' => 'Appointment status updated'], 200);
            } else {
                $this->json(['error' => 'Appointment not found or status unchanged'], 404);
            }
        } catch (Throwable $e) {
            error_log("AppointmentApiControl updateStatus error: " . $e->getMessage());
            $this->json(['error' => 'Failed to update appointment status', 'detail' => $e->getMessage()], 500);
        }
    }

    private function json($data, int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function getJsonInput(): array
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
}
