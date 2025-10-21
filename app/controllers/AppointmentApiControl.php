<?php

class AppointmentApiControl {
    private Appointment $appointmentModel;

    public function __construct() {
        $this->appointmentModel = new Appointment();
    }
    public function listCounselors() {
        Auth::requireAuth();
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id, username, full_name FROM users WHERE role = 'counselor' ORDER BY full_name IS NULL, full_name, username");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->json($rows);
    }

    public function create() {
        Auth::requireRole('undergrad');
        $user = Auth::user();
        $data = $this->getJsonInput();

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


