<?php

class AppointmentApiControl
{
    private $appointmentModel;

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
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
        $user = ['id' => $_SESSION['user_id'] ?? 1]; 

        $required = ['counselor_user_id', 'title', 'type', 'date', 'time'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                return $this->json(['error' => "$field is required"], 400);
            }
        }

        try {
            $id = $this->appointmentModel->create(
                (int) $user['id'],
                (int) $data['counselor_user_id'],
                trim($data['title']),
                trim($data['type']),
                $data['date'],
                $data['time']
            );

            if ($id) {
                $this->json(['message' => 'Appointment created', 'id' => $id], 201);
            } else {
                $this->json(['error' => 'Failed to create appointment'], 500);
            }
        } catch (Throwable $e) {
            error_log("AppointmentApiControl create error: " . $e->getMessage());
            $this->json(['error' => 'Failed to create appointment', 'detail' => $e->getMessage()], 500);
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
