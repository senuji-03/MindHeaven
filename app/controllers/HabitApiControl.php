<?php

require_once BASE_PATH . '/core/Auth.php';
require_once BASE_PATH . '/app/models/Habit.php';

class HabitApiControl {
    private $habitModel;

    public function __construct() {
        // Session is already started in index.php, no need to start again
        // Protect all habit API routes - require authentication
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Authentication required']);
            exit;
        }
        
        // Add security headers to prevent caching and back-button access
        Auth::setSecurityHeaders();
        
        $this->habitModel = new Habit();
    }

    public function list() {
        try {
            $userId = 1; // Auth::user()['id']; // Temporarily hardcoded for testing
            $habits = $this->habitModel->getByUserId($userId);
            
            $this->json([
                'habits' => $habits,
                'message' => 'Habits retrieved successfully'
            ]);
            
        } catch (Exception $e) {
            error_log("HabitApiControl list error: " . $e->getMessage());
            $this->json(['error' => 'Failed to retrieve habits: ' . $e->getMessage()], 500);
        }
    }

    public function create() {
        try {
            $data = $this->getJsonInput();
            $userId = 1; // Auth::user()['id']; // Temporarily hardcoded for testing
            
            // Debug: Log received data
            error_log("HabitApiControl create - Received data: " . json_encode($data));
            
            // Validate required fields
            $required = ['name', 'category'];
            foreach ($required as $field) {
                if (!isset($data[$field]) || $data[$field] === '') {
                    error_log("HabitApiControl create - Missing required field: $field");
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
            
            $this->json(['id' => $habitId, 'message' => 'Habit created successfully'], 201);
            
        } catch (Exception $e) {
            error_log("HabitApiControl create error: " . $e->getMessage());
            $this->json(['error' => 'Failed to create habit: ' . $e->getMessage()], 500);
        }
    }

    public function update() {
        try {
            $data = $this->getJsonInput();
            $userId = 1; // Auth::user()['id']; // Temporarily hardcoded for testing
            
            if (!isset($data['id']) || $data['id'] === '') {
                return $this->json(['error' => 'Habit ID is required'], 400);
            }
            
            $result = $this->habitModel->update(
                (int)$data['id'],
                $userId,
                trim($data['name']),
                $data['description'] ?? null,
                $data['category'] ?? 'other',
                $data['frequency'] ?? 'daily',
                (int)($data['target_days'] ?? 1),
                $data['color'] ?? '#10b981',
                $data['icon'] ?? '🎯'
            );
            
            if ($result) {
                $this->json(['message' => 'Habit updated successfully'], 200);
            } else {
                $this->json(['error' => 'Habit not found or could not be updated'], 404);
            }
            
        } catch (Exception $e) {
            error_log("HabitApiControl update error: " . $e->getMessage());
            $this->json(['error' => 'Failed to update habit: ' . $e->getMessage()], 500);
        }
    }

    public function delete() {
        try {
            $data = $this->getJsonInput();
            $userId = 1; // Auth::user()['id']; // Temporarily hardcoded for testing
            
            if (!isset($data['id']) || $data['id'] === '') {
                return $this->json(['error' => 'Habit ID is required'], 400);
            }
            
            $result = $this->habitModel->delete((int)$data['id'], $userId);
            
            if ($result) {
                $this->json(['message' => 'Habit deleted successfully'], 200);
            } else {
                $this->json(['error' => 'Habit not found or could not be deleted'], 404);
            }
            
        } catch (Exception $e) {
            error_log("HabitApiControl delete error: " . $e->getMessage());
            $this->json(['error' => 'Failed to delete habit: ' . $e->getMessage()], 500);
        }
    }

    public function complete() {
        try {
            $data = $this->getJsonInput();
            $userId = 1; // Auth::user()['id']; // Temporarily hardcoded for testing
            
            if (!isset($data['habit_id']) || !isset($data['date'])) {
                return $this->json(['error' => 'Habit ID and date are required'], 400);
            }
            
            $result = $this->habitModel->completeHabit(
                (int)$data['habit_id'],
                $userId,
                $data['date'],
                $data['notes'] ?? null,
                $data['mood_rating'] ?? null
            );
            
            if ($result) {
                $this->json(['message' => 'Habit completed successfully'], 200);
            } else {
                $this->json(['error' => 'Failed to complete habit'], 400);
            }
            
        } catch (Exception $e) {
            error_log("HabitApiControl complete error: " . $e->getMessage());
            $this->json(['error' => 'Failed to complete habit: ' . $e->getMessage()], 500);
        }
    }

    public function uncomplete() {
        try {
            $data = $this->getJsonInput();
            $userId = 1; // Auth::user()['id']; // Temporarily hardcoded for testing
            
            if (!isset($data['habit_id']) || !isset($data['date'])) {
                return $this->json(['error' => 'Habit ID and date are required'], 400);
            }
            
            $result = $this->habitModel->uncompleteHabit(
                (int)$data['habit_id'],
                $userId,
                $data['date']
            );
            
            if ($result) {
                $this->json(['message' => 'Habit uncompleted successfully'], 200);
            } else {
                $this->json(['error' => 'Failed to uncomplete habit'], 400);
            }
            
        } catch (Exception $e) {
            error_log("HabitApiControl uncomplete error: " . $e->getMessage());
            $this->json(['error' => 'Failed to uncomplete habit: ' . $e->getMessage()], 500);
        }
    }

    public function stats() {
        try {
            $userId = 1; // Auth::user()['id']; // Temporarily hardcoded for testing
            $stats = $this->habitModel->getStats($userId);
            
            $this->json([
                'stats' => $stats,
                'message' => 'Stats retrieved successfully'
            ]);
            
        } catch (Exception $e) {
            error_log("HabitApiControl stats error: " . $e->getMessage());
            $this->json(['error' => 'Failed to retrieve stats: ' . $e->getMessage()], 500);
        }
    }

    public function test() {
        try {
            $pdo = Database::getConnection();
            
            // Test habits table
            $stmt = $pdo->query("DESCRIBE habits");
            $habitsColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Test habit_completions table
            $stmt = $pdo->query("DESCRIBE habit_completions");
            $completionsColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Test habit_streaks table
            $stmt = $pdo->query("DESCRIBE habit_streaks");
            $streaksColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $this->json([
                'status' => 'success',
                'message' => 'Database connection successful',
                'tables' => [
                    'habits' => $habitsColumns,
                    'habit_completions' => $completionsColumns,
                    'habit_streaks' => $streaksColumns
                ]
            ]);
            
        } catch (Exception $e) {
            error_log("HabitApiControl test error: " . $e->getMessage());
            $this->json(['error' => 'Database test failed: ' . $e->getMessage()], 500);
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
