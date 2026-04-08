<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/app/models/Habit.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class HabitApiControl {
    private $habitModel;

    public function __construct() {
        $this->habitModel = new Habit();
    }

    // ----------------------------------------------------------------
    // GET /api/habits  — list all habits for the logged-in student
    // ----------------------------------------------------------------
    public function list() {
        $userId = $this->requireAuth();
        try {
            $habits = $this->habitModel->getByUser($userId);
            $this->json(['habits' => $habits]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to load habits: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // GET /api/habits/for-date?date=YYYY-MM-DD
    // Returns all habits with completion status for the given date
    // ----------------------------------------------------------------
    public function listByDate() {
        $userId = $this->requireAuth();
        $date   = $_GET['date'] ?? '';

        if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->json(['error' => 'Valid date (YYYY-MM-DD) is required'], 400);
        }

        try {
            $habits = $this->habitModel->getWithCompletionForDate($userId, $date);
            $this->json(['date' => $date, 'habits' => $habits]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to load habits for date: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // GET /api/habits/calendar?year=YYYY&month=M
    // Returns a map of date => completion count for the month
    // ----------------------------------------------------------------
    public function calendarData() {
        $userId = $this->requireAuth();
        $year   = (int)($_GET['year']  ?? date('Y'));
        $month  = (int)($_GET['month'] ?? date('n'));

        if ($year < 2000 || $year > 2100 || $month < 1 || $month > 12) {
            return $this->json(['error' => 'Invalid year or month'], 400);
        }

        try {
            $data = $this->habitModel->getCalendarData($userId, $year, $month);
            $this->json(['year' => $year, 'month' => $month, 'data' => $data]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to load calendar data: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // POST /api/habits/log-date
    // Body: { habit_id, date, notes?, mood_rating? }
    // ----------------------------------------------------------------
    public function logForDate() {
        $userId = $this->requireAuth();
        try {
            $data    = $this->getJsonInput();
            $habitId = (int)($data['habit_id'] ?? 0);
            $date    = trim($data['date'] ?? '');

            if (!$habitId) {
                return $this->json(['error' => 'habit_id is required'], 400);
            }
            if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return $this->json(['error' => 'Valid date (YYYY-MM-DD) is required'], 400);
            }

            $completionId = $this->habitModel->completeForDate(
                $habitId,
                $userId,
                $date,
                $data['notes']       ?? null,
                isset($data['mood_rating']) ? (int)$data['mood_rating'] : null
            );

            $this->json(['id' => $completionId, 'message' => 'Habit logged for ' . $date], 201);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to log habit: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // POST /api/habits/unlog-date
    // Body: { habit_id, date }
    // ----------------------------------------------------------------
    public function unlogForDate() {
        $userId = $this->requireAuth();
        try {
            $data    = $this->getJsonInput();
            $habitId = (int)($data['habit_id'] ?? 0);
            $date    = trim($data['date'] ?? '');

            if (!$habitId) {
                return $this->json(['error' => 'habit_id is required'], 400);
            }
            if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return $this->json(['error' => 'Valid date (YYYY-MM-DD) is required'], 400);
            }

            $this->habitModel->uncompleteForDate($habitId, $userId, $date);
            $this->json(['message' => 'Habit unlogged for ' . $date]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to unlog habit: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // POST /api/habits/create
    // ----------------------------------------------------------------
    public function create() {
        $userId = $this->requireAuth();
        try {
            $data = $this->getJsonInput();

            foreach (['name', 'category'] as $field) {
                if (empty($data[$field])) {
                    return $this->json(['error' => "$field is required"], 400);
                }
            }

            $freq           = $data['frequency']       ?? 'today';
            $startDate      = $data['start_date']      ?? date('Y-m-d');
            $endDate        = !empty($data['end_date']) ? $data['end_date'] : null;
            $daysOfWeek     = !empty($data['days_of_week']) ? $data['days_of_week'] : null;
            $repeatInterval = (int)($data['repeat_interval'] ?? 1);

            $habitId = $this->habitModel->create(
                $userId,
                trim($data['name']),
                $data['description'] ?? null,
                $data['category']    ?? 'other',
                $freq,
                $startDate,
                $endDate,
                $daysOfWeek,
                $repeatInterval,
                $data['color']       ?? '#10b981',
                $data['icon']        ?? '🎯'
            );

            $this->log("Habit ID $habitId (freq=$freq) created by User ID $userId");
            $this->json(['id' => $habitId, 'message' => 'Habit created successfully'], 201);

        } catch (Exception $e) {
            $this->log("Error creating habit: " . $e->getMessage());
            $this->json(['error' => 'Failed to create habit: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // PUT /api/habits/update
    // ----------------------------------------------------------------
    public function update() {
        $userId = $this->requireAuth();
        try {
            $data = $this->getJsonInput();
            if (empty($data['id'])) {
                return $this->json(['error' => 'Habit id is required'], 400);
            }

            $updated = $this->habitModel->update(
                (int)$data['id'],
                $userId,
                $data['name']        ?? null,
                $data['description'] ?? null,
                $data['category']    ?? null,
                $data['frequency']   ?? null,
                !empty($data['start_date']) ? $data['start_date'] : null,
                array_key_exists('end_date', $data) ? ($data['end_date'] ?: null) : null,
                !empty($data['days_of_week']) ? $data['days_of_week'] : null,
                isset($data['repeat_interval']) ? (int)$data['repeat_interval'] : null,
                $data['color']       ?? null,
                $data['icon']        ?? null
            );

            if ($updated) {
                $this->json(['message' => 'Habit updated successfully']);
            } else {
                $this->json(['error' => 'Habit not found or not authorised'], 404);
            }
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to update habit: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // DELETE /api/habits/delete
    // ----------------------------------------------------------------
    public function delete() {
        $userId = $this->requireAuth();
        try {
            $data = $this->getJsonInput();
            $id   = (int)($data['id'] ?? $_GET['id'] ?? 0);

            if (!$id) {
                return $this->json(['error' => 'Habit id is required'], 400);
            }

            $deleted = $this->habitModel->delete($id, $userId);
            if ($deleted) {
                $this->json(['message' => 'Habit deleted successfully']);
            } else {
                $this->json(['error' => 'Habit not found or not authorised'], 404);
            }
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to delete habit: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // POST /api/habits/complete  (today only — legacy)
    // ----------------------------------------------------------------
    public function complete() {
        $userId = $this->requireAuth();
        try {
            $data    = $this->getJsonInput();
            $habitId = (int)($data['habit_id'] ?? 0);
            if (!$habitId) {
                return $this->json(['error' => 'habit_id is required'], 400);
            }

            $completionId = $this->habitModel->complete(
                $habitId,
                $userId,
                $data['notes']       ?? null,
                $data['mood_rating'] ?? null
            );

            $this->json(['id' => $completionId, 'message' => 'Habit marked as complete'], 201);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to mark complete: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // POST /api/habits/uncomplete  (today only — legacy)
    // ----------------------------------------------------------------
    public function uncomplete() {
        $userId = $this->requireAuth();
        try {
            $data    = $this->getJsonInput();
            $habitId = (int)($data['habit_id'] ?? 0);
            if (!$habitId) {
                return $this->json(['error' => 'habit_id is required'], 400);
            }

            $this->habitModel->uncomplete($habitId, $userId);
            $this->json(['message' => 'Habit completion removed']);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to uncomplete: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // GET /api/habits/stats
    // ----------------------------------------------------------------
    public function stats() {
        $userId = $this->requireAuth();
        try {
            $stats = $this->habitModel->getStats($userId);
            $this->json(['stats' => $stats]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to load stats: ' . $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------
    // GET /api/habits/test
    // ----------------------------------------------------------------
    public function test() {
        $this->json([
            'status'  => 'ok',
            'message' => 'HabitApiControl is reachable',
            'user_id' => $_SESSION['user_id'] ?? null
        ]);
    }

    // ================================================================
    // Private helpers
    // ================================================================

    private function requireAuth(): int {
        if (!isset($_SESSION['user_id'])) {
            $this->json(['error' => 'Authentication required. Please log in.'], 401);
        }
        return (int)$_SESSION['user_id'];
    }

    private function getJsonInput(): array {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }

    private function json($data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function log(string $message): void {
        $dir = BASE_PATH . '/logs';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        file_put_contents($dir . '/habit_api.log', date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
    }
}
