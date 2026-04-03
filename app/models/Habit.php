<?php
require_once BASE_PATH . '/core/Database.php';

class Habit {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create(
        int $userId,
        string $name,
        ?string $description = null,
        string $category = 'other',
        string $frequency = 'daily',
        int $targetDays = 1,
        string $color = '#10b981',
        string $icon = '🎯'
    ): int {
        // Prepare the SQL statement
        $stmt = $this->pdo->prepare("
            INSERT INTO habits (
                user_id, name, description, category, frequency, target_days, color, icon
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $userId, $name, $description, $category, $frequency, $targetDays, $color, $icon
        ]);
        
        if (!$result) {
            throw new Exception("Failed to insert habit into database");
        }
        
        $habitId = (int)$this->pdo->lastInsertId();
        
        // Initialize the streak tracking for this newly created habit (disabled until streaks table is created)
        // $this->initializeStreak($habitId, $userId);
        
        return $habitId;
    }

    private function initializeStreak(int $habitId, int $userId): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO habit_streaks (habit_id, user_id, current_streak, longest_streak)
            VALUES (?, ?, 0, 0)
            ON DUPLICATE KEY UPDATE habit_id = habit_id
        ");
        $stmt->execute([$habitId, $userId]);
    }
}
