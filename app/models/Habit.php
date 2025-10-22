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
        string $description = null,
        string $category = 'other',
        string $frequency = 'daily',
        int $targetDays = 1,
        string $color = '#10b981',
        string $icon = '🎯'
    ): int {
        // Debug: Log the data being inserted
        error_log("Habit model create - Data: userId=$userId, name=$name, description=$description, category=$category, frequency=$frequency, targetDays=$targetDays, color=$color, icon=$icon");
        
        $stmt = $this->pdo->prepare("
            INSERT INTO habits (
                user_id, name, description, category, frequency, target_days, color, icon
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $userId, $name, $description, $category, $frequency, $targetDays, $color, $icon
        ]);
        
        if (!$result) {
            error_log("Habit model create - SQL execution failed: " . json_encode($stmt->errorInfo()));
            throw new Exception("Failed to insert habit into database");
        }
        
        $habitId = (int)$this->pdo->lastInsertId();
        error_log("Habit model create - Created habit with ID: $habitId");
        
        // Initialize streak tracking
        $this->initializeStreak($habitId, $userId);
        
        return $habitId;
    }

    public function getByUserId(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT h.*, 
                   COALESCE(s.current_streak, 0) as current_streak,
                   COALESCE(s.longest_streak, 0) as longest_streak
            FROM habits h
            LEFT JOIN habit_streaks s ON h.id = s.habit_id AND s.user_id = h.user_id
            WHERE h.user_id = ? AND h.is_active = 1
            ORDER BY h.created_at DESC
        ");
        
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id, int $userId): ?array {
        $stmt = $this->pdo->prepare("
            SELECT h.*, 
                   COALESCE(s.current_streak, 0) as current_streak,
                   COALESCE(s.longest_streak, 0) as longest_streak
            FROM habits h
            LEFT JOIN habit_streaks s ON h.id = s.habit_id AND s.user_id = h.user_id
            WHERE h.id = ? AND h.user_id = ? AND h.is_active = 1
        ");
        
        $stmt->execute([$id, $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function update(
        int $id,
        int $userId,
        string $name,
        string $description = null,
        string $category = 'other',
        string $frequency = 'daily',
        int $targetDays = 1,
        string $color = '#10b981',
        string $icon = '🎯'
    ): bool {
        $stmt = $this->pdo->prepare("
            UPDATE habits 
            SET name = ?, description = ?, category = ?, frequency = ?, 
                target_days = ?, color = ?, icon = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ? AND user_id = ? AND is_active = 1
        ");
        
        $result = $stmt->execute([
            $name, $description, $category, $frequency, $targetDays, $color, $icon, $id, $userId
        ]);
        
        return $result && $stmt->rowCount() > 0;
    }

    public function delete(int $id, int $userId): bool {
        // Soft delete by setting is_active to false
        $stmt = $this->pdo->prepare("
            UPDATE habits 
            SET is_active = 0, updated_at = CURRENT_TIMESTAMP
            WHERE id = ? AND user_id = ?
        ");
        
        $result = $stmt->execute([$id, $userId]);
        return $result && $stmt->rowCount() > 0;
    }

    public function completeHabit(
        int $habitId,
        int $userId,
        string $date,
        string $notes = null,
        int $moodRating = null
    ): bool {
        try {
            $this->pdo->beginTransaction();
            
            // Insert completion record
            $stmt = $this->pdo->prepare("
                INSERT INTO habit_completions (habit_id, user_id, completion_date, completion_time, notes, mood_rating)
                VALUES (?, ?, ?, NOW(), ?, ?)
                ON DUPLICATE KEY UPDATE
                completion_time = NOW(),
                notes = COALESCE(?, notes),
                mood_rating = COALESCE(?, mood_rating)
            ");
            
            $stmt->execute([$habitId, $userId, $date, $notes, $moodRating, $notes, $moodRating]);
            
            // Update streak
            $this->updateStreak($habitId, $userId, $date);
            
            $this->pdo->commit();
            return true;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Habit completeHabit error: " . $e->getMessage());
            return false;
        }
    }

    public function uncompleteHabit(int $habitId, int $userId, string $date): bool {
        try {
            $this->pdo->beginTransaction();
            
            // Remove completion record
            $stmt = $this->pdo->prepare("
                DELETE FROM habit_completions 
                WHERE habit_id = ? AND user_id = ? AND completion_date = ?
            ");
            
            $stmt->execute([$habitId, $userId, $date]);
            
            // Update streak
            $this->updateStreak($habitId, $userId, $date);
            
            $this->pdo->commit();
            return true;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Habit uncompleteHabit error: " . $e->getMessage());
            return false;
        }
    }

    public function getCompletionsForMonth(int $habitId, int $userId, string $year, string $month): array {
        $stmt = $this->pdo->prepare("
            SELECT completion_date, completion_time, notes, mood_rating
            FROM habit_completions
            WHERE habit_id = ? AND user_id = ? 
            AND YEAR(completion_date) = ? AND MONTH(completion_date) = ?
            ORDER BY completion_date ASC
        ");
        
        $stmt->execute([$habitId, $userId, $year, $month]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStats(int $userId): array {
        // Get total habits
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total_habits
            FROM habits 
            WHERE user_id = ? AND is_active = 1
        ");
        $stmt->execute([$userId]);
        $totalHabits = $stmt->fetch(PDO::FETCH_ASSOC)['total_habits'];
        
        // Get today's completions
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as today_completions
            FROM habit_completions hc
            JOIN habits h ON hc.habit_id = h.id
            WHERE hc.user_id = ? AND hc.completion_date = CURDATE() AND h.is_active = 1
        ");
        $stmt->execute([$userId]);
        $todayCompletions = $stmt->fetch(PDO::FETCH_ASSOC)['today_completions'];
        
        // Get completion rate for today
        $completionRate = $totalHabits > 0 ? round(($todayCompletions / $totalHabits) * 100, 1) : 0;
        
        // Get longest streak
        $stmt = $this->pdo->prepare("
            SELECT MAX(longest_streak) as longest_streak
            FROM habit_streaks
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $longestStreak = $stmt->fetch(PDO::FETCH_ASSOC)['longest_streak'] ?? 0;
        
        return [
            'total_habits' => (int)$totalHabits,
            'today_completions' => (int)$todayCompletions,
            'completion_rate' => $completionRate,
            'longest_streak' => (int)$longestStreak
        ];
    }

    private function initializeStreak(int $habitId, int $userId): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO habit_streaks (habit_id, user_id, current_streak, longest_streak)
            VALUES (?, ?, 0, 0)
            ON DUPLICATE KEY UPDATE habit_id = habit_id
        ");
        $stmt->execute([$habitId, $userId]);
    }

    private function updateStreak(int $habitId, int $userId, string $date): void {
        // This is a simplified streak calculation
        // In a real application, you'd want more sophisticated streak logic
        $stmt = $this->pdo->prepare("
            UPDATE habit_streaks 
            SET current_streak = current_streak + 1,
                longest_streak = GREATEST(longest_streak, current_streak + 1),
                last_completion_date = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE habit_id = ? AND user_id = ?
        ");
        $stmt->execute([$date, $habitId, $userId]);
    }
}
