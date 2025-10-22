<?php

class AppointmentApiControl {
    private Appointment $appointmentModel;

    public function __construct() {
        $this->appointmentModel = new Appointment();
    }
    public function listCounselors() {
        try {
            // Temporarily remove auth requirement for testing
            // Auth::requireAuth();
            $pdo = Database::getConnection();
            
            // First try to get counselors from the counselors table
            try {
                $stmt = $pdo->prepare("
                    SELECT u.id, u.username, c.full_name, c.specialization, c.is_available, c.is_approved
                    FROM users u 
                    INNER JOIN counselors c ON u.id = c.user_id 
                    WHERE u.role = 'counselor'
                    ORDER BY c.full_name
                ");
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($rows) > 0) {
                    error_log("AppointmentApiControl: Returning " . count($rows) . " counselors from counselors table");
                    $this->json($rows);
                    return;
                }
            } catch (Exception $e) {
                error_log("AppointmentApiControl: Counselors table query failed: " . $e->getMessage());
            }
            
            // Fallback: Get counselors from users table only
            try {
                $stmt = $pdo->prepare("
                    SELECT id, username, full_name, '' as specialization, 1 as is_available, 1 as is_approved
                    FROM users 
                    WHERE role = 'counselor'
                    ORDER BY full_name, username
                ");
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                error_log("AppointmentApiControl: Returning " . count($rows) . " counselors from users table (fallback)");
                $this->json($rows);
                
            } catch (Exception $e) {
                error_log("AppointmentApiControl: Users table query failed: " . $e->getMessage());
                $this->json(['error' => 'No counselors found in database'], 404);
            }
            
        } catch (Exception $e) {
            error_log("AppointmentApiControl Error: " . $e->getMessage());
            $this->json(['error' => 'Failed to load counselors: ' . $e->getMessage()], 500);
        }
    }

    public function test() {
        $this->json([
            'status' => 'success',
            'message' => 'API is working',
            'timestamp' => date('Y-m-d H:i:s'),
            'base_url' => BASE_URL
        ]);
    }

    public function create() {
        // Temporarily remove auth requirement for testing
        // Auth::requireRole('undergrad');
        // $user = Auth::user();
        $data = $this->getJsonInput();
        
        // For testing, use a default user ID
        $user = ['id' => 1]; // Replace with actual user ID when auth is enabled

        $required = ['counselor_user_id','title','type','date','time'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                return $this->json(['error' => "$field is required"], 400);
            }
        }

        try {
            $id = $this->appointmentModel->create(
                (int)$user['id'],
                (int)$data['counselor_user_id'],
                trim($data['title']),
                trim($data['type']),
                $data['date'],
                $data['time'],
                $data['notes'] ?? null
            );
            $this->json(['id' => $id], 201);
        } catch (Throwable $e) {
            $this->json(['error' => 'Failed to create appointment', 'detail' => $e->getMessage()], 500);
        }
    }

    public function update() {
        // Temporarily remove auth requirement for testing
        // Auth::requireRole('undergrad');
        $data = $this->getJsonInput();
        
        error_log("AppointmentApiControl: Update request received with data: " . json_encode($data));
        
        if (!isset($data['id']) || $data['id'] === '') {
            error_log("AppointmentApiControl: Missing appointment ID for update");
            return $this->json(['error' => 'Appointment ID is required'], 400);
        }

        $required = ['title','type','date','time'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                return $this->json(['error' => "$field is required"], 400);
            }
        }

        try {
            error_log("AppointmentApiControl: Calling model update for ID: " . $data['id']);
            $result = $this->appointmentModel->update(
                (int)$data['id'],
                trim($data['title']),
                trim($data['type']),
                $data['date'],
                $data['time'],
                $data['notes'] ?? null
            );
            error_log("AppointmentApiControl: Model update result: " . ($result ? "SUCCESS" : "FAILED"));
            
            if ($result) {
                $this->json(['message' => 'Appointment updated successfully'], 200);
            } else {
                $this->json(['error' => 'Appointment not found or could not be updated'], 404);
            }
        } catch (Throwable $e) {
            error_log("AppointmentApiControl update error: " . $e->getMessage());
            $this->json(['error' => 'Failed to update appointment', 'detail' => $e->getMessage()], 500);
        }
    }

    public function delete() {
        // Temporarily remove auth requirement for testing
        // Auth::requireRole('undergrad');
        $data = $this->getJsonInput();
        
        error_log("AppointmentApiControl: Delete request received with data: " . json_encode($data));
        
        if (!isset($data['id']) || $data['id'] === '') {
            error_log("AppointmentApiControl: Missing appointment ID");
            return $this->json(['error' => 'Appointment ID is required'], 400);
        }

        try {
            error_log("AppointmentApiControl: Calling model delete for ID: " . $data['id']);
            $result = $this->appointmentModel->delete((int)$data['id']);
            error_log("AppointmentApiControl: Model delete result: " . ($result ? "SUCCESS" : "FAILED"));
            
            if ($result) {
                $this->json(['message' => 'Appointment deleted successfully'], 200);
            } else {
                $this->json(['error' => 'Appointment not found or could not be deleted'], 404);
            }
        } catch (Throwable $e) {
            error_log("AppointmentApiControl delete error: " . $e->getMessage());
            $this->json(['error' => 'Failed to delete appointment', 'detail' => $e->getMessage()], 500);
        }
    }

    private function json($data, int $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function getJsonInput(): array {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
}


