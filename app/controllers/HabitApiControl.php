<?php
// Since we are running this directly, we define BASE_PATH if not defined
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/app/models/Habit.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class HabitApiControl {
    private $habitModel;

    public function __construct() {
        $this->habitModel = new Habit();
    }

    public function handleRequest() {
        // Protect API (during dev testing, fallback if session is disjointed)
        // if (!isset($_SESSION['user_id'])) {
        //     $this->json(['error' => 'Authentication required'], 401);
        // }

        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'] ?? '';

        if ($method === 'POST' || $method === 'PUT') {
            if ($action === 'create' || $action === '') {
                $this->create();
            } else if ($action === 'update') {
               // Placeholder for update
                $this->json(['message' => 'Not implemented'], 501);
            }
        } else {
            $this->json(['error' => 'Method not allowed'], 405);
        }
    }

    public function create() {
        try {
            $data = $this->getJsonInput();
            $userId = $_SESSION['user_id'] ?? 1; // Fallback to 1 if session is unlinked
            
            // Validate required fields
            $required = ['name', 'category'];
            foreach ($required as $field) {
                if (!isset($data[$field]) || $data[$field] === '') {
                    return $this->json(['error' => "$field is required"], 400);
                }
            }
            
            $habitId = $this->habitModel->create(
                $userId,
                trim($data['name']),
                $data['description'] ?? null,
                $data['category'] ?? 'other',
                $data['frequency'] ?? 'daily',
                (int)($data['target_days'] ?? 1),
                $data['color'] ?? '#10b981',
                $data['icon'] ?? '🎯'
            );
            
            file_put_contents(BASE_PATH . '/logs/habit_api.log', "Success: Habit ID $habitId created by User ID $userId\n", FILE_APPEND);
            $this->json(['id' => $habitId, 'message' => 'Habit created successfully'], 201);
            
        } catch (Exception $e) {
            file_put_contents(BASE_PATH . '/logs/habit_api.log', "Error creating habit: " . $e->getMessage() . "\n", FILE_APPEND);
            $this->json(['error' => 'Failed to create habit: ' . $e->getMessage()], 500);
        }
    }

    private function getJsonInput() {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }

    private function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

// Execute the handler if called directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    $api = new HabitApiControl();
    $api->handleRequest();
}
