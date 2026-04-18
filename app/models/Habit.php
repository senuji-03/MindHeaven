<?php
require_once BASE_PATH . '/core/Database.php';

class Habit {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // ----------------------------------------------------------------
    // CREATE a new habit with full scheduling info
    // ----------------------------------------------------------------
    public function create(
        int     $userId,
        string  $name,
        ?string $description    = null,
        string  $category       = 'other',
        string  $frequency      = 'today',
        ?string $startDate      = null,
        ?string $endDate        = null,
        ?string $daysOfWeek     = null,
        int     $repeatInterval = 1,
        string  $color          = '#10b981',
        string  $icon           = '🎯'
    ): int {
        // Default start_date to today if omitted
        if (!$startDate) {
            $startDate = date('Y-m-d');
        }
        // For 'today', end_date always equals start_date
        if ($frequency === 'today') {
            $endDate = $startDate;
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO habits
                (user_id, name, description, category, frequency,
                 start_date, end_date, days_of_week, repeat_interval, color, icon)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $result = $stmt->execute([
            $userId, $name, $description, $category, $frequency,
            $startDate, $endDate, $daysOfWeek, $repeatInterval, $color, $icon
        ]);

        if (!$result) {
            throw new Exception("Failed to insert habit into database");
        }
        return (int)$this->pdo->lastInsertId();
    }

    // ----------------------------------------------------------------
    // READ all active habits for a user with today's completion status
    // ----------------------------------------------------------------
    public function getByUser(int $userId): array {
        $today = date('Y-m-d');
        $stmt  = $this->pdo->prepare("
            SELECT h.*,
                   CASE WHEN hc.id IS NOT NULL THEN 1 ELSE 0 END AS completed_today
            FROM habits h
            LEFT JOIN habit_completions hc
                   ON hc.habit_id = h.id
                  AND hc.user_id  = h.user_id
                  AND hc.completion_date = ?
            WHERE h.user_id  = ?
              AND h.is_active = 1
            ORDER BY h.created_at DESC
        ");
        $stmt->execute([$today, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id, int $userId): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM habits WHERE id = ? AND user_id = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$id, $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // ----------------------------------------------------------------
    // READ calendar data: count of scheduled (active) habits per day
    // Returns: ['YYYY-MM-DD' => count, ...]
    // ----------------------------------------------------------------
    public function getCalendarData(int $userId, int $year, int $month): array {
        // Fetch all active habit scheduling rules
        $stmt = $this->pdo->prepare("
            SELECT id, frequency, start_date, end_date, days_of_week, repeat_interval, color
            FROM habits
            WHERE user_id = ? AND is_active = 1
        ");
        $stmt->execute([$userId]);
        $habits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($habits)) return [];

        $from    = new DateTime(sprintf('%04d-%02d-01', $year, $month));
        $to      = new DateTime($from->format('Y-m-t'));
        $result  = [];
        $current = clone $from;

        while ($current <= $to) {
            $dateStr = $current->format('Y-m-d');
            $count   = 0;
            foreach ($habits as $habit) {
                if ($this->isScheduledOnDate($habit, $dateStr)) {
                    $count++;
                }
            }
            if ($count > 0) {
                $result[$dateStr] = $count;
            }
            $current->modify('+1 day');
        }
        return $result;
    }

    // ----------------------------------------------------------------
    // READ habits with completion status for a SPECIFIC DATE
    // Only returns habits that are scheduled (active) on that date
    // ----------------------------------------------------------------
    public function getWithCompletionForDate(int $userId, string $date): array {
        $stmt = $this->pdo->prepare("
            SELECT h.*,
                   hc.id           AS completion_id,
                   hc.notes        AS completion_notes,
                   hc.mood_rating,
                   CASE WHEN hc.id IS NOT NULL THEN 1 ELSE 0 END AS completed_on_date
            FROM habits h
            LEFT JOIN habit_completions hc
                   ON hc.habit_id = h.id
                  AND hc.user_id  = h.user_id
                  AND hc.completion_date = ?
            WHERE h.user_id  = ?
              AND h.is_active = 1
            ORDER BY h.created_at ASC
        ");
        $stmt->execute([$date, $userId]);
        $habits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Filter to only habits scheduled on this date
        $filtered = array_filter($habits, function ($habit) use ($date) {
            return $this->isScheduledOnDate($habit, $date);
        });
        return array_values($filtered);
    }

    // ----------------------------------------------------------------
    // LOG a habit completion for a specific date
    // ----------------------------------------------------------------
    public function completeForDate(
        int $habitId, int $userId, string $date,
        ?string $notes = null, ?int $moodRating = null
    ): int {
        $time = date('H:i:s');
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO habit_completions
                (habit_id, user_id, completion_date, completion_time, notes, mood_rating)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$habitId, $userId, $date, $time, $notes, $moodRating]);

        $stmt2 = $this->pdo->prepare("
            SELECT id FROM habit_completions
            WHERE habit_id = ? AND user_id = ? AND completion_date = ?
            LIMIT 1
        ");
        $stmt2->execute([$habitId, $userId, $date]);
        return (int)$stmt2->fetchColumn();
    }

    // ----------------------------------------------------------------
    // REMOVE a habit completion for a specific date
    // ----------------------------------------------------------------
    public function uncompleteForDate(int $habitId, int $userId, string $date): void {
        $stmt = $this->pdo->prepare("
            DELETE FROM habit_completions
            WHERE habit_id = ? AND user_id = ? AND completion_date = ?
        ");
        $stmt->execute([$habitId, $userId, $date]);
    }

    // ----------------------------------------------------------------
    // UPDATE a habit
    // ----------------------------------------------------------------
    public function update(
        int $id, int $userId,
        ?string $name = null, ?string $description = null,
        ?string $category = null, ?string $frequency = null,
        ?string $startDate = null, ?string $endDate = null,
        ?string $daysOfWeek = null, ?int $repeatInterval = null,
        ?string $color = null, ?string $icon = null
    ): bool {
        $fields = []; $params = [];
        if ($name           !== null) { $fields[] = 'name = ?';          $params[] = $name; }
        if ($description    !== null) { $fields[] = 'description = ?';   $params[] = $description; }
        if ($category       !== null) { $fields[] = 'category = ?';      $params[] = $category; }
        if ($frequency      !== null) { $fields[] = 'frequency = ?';     $params[] = $frequency; }
        if ($startDate      !== null) { $fields[] = 'start_date = ?';    $params[] = $startDate; }
        if ($endDate        !== null) { $fields[] = 'end_date = ?';      $params[] = $endDate; }
        if ($daysOfWeek     !== null) { $fields[] = 'days_of_week = ?';  $params[] = $daysOfWeek; }
        if ($repeatInterval !== null) { $fields[] = 'repeat_interval = ?'; $params[] = $repeatInterval; }
        if ($color          !== null) { $fields[] = 'color = ?';          $params[] = $color; }
        if ($icon           !== null) { $fields[] = 'icon = ?';           $params[] = $icon; }
        if (empty($fields)) return false;
        $params[] = $id; $params[] = $userId;
        $stmt = $this->pdo->prepare(
            "UPDATE habits SET " . implode(', ', $fields) .
            " WHERE id = ? AND user_id = ? AND is_active = 1"
        );
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    // ----------------------------------------------------------------
    // HARD-DELETE a habit
    // ----------------------------------------------------------------
    public function delete(int $id, int $userId): bool {
        $stmt = $this->pdo->prepare("DELETE FROM habits WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        return $stmt->rowCount() > 0;
    }

    // ----------------------------------------------------------------
    // COMPLETE — record completion for today (legacy helper)
    // ----------------------------------------------------------------
    public function complete(int $habitId, int $userId, ?string $notes = null, ?int $moodRating = null): int {
        return $this->completeForDate($habitId, $userId, date('Y-m-d'), $notes, $moodRating);
    }

    // ----------------------------------------------------------------
    // UNCOMPLETE — remove today's completion (legacy helper)
    // ----------------------------------------------------------------
    public function uncomplete(int $habitId, int $userId): void {
        $this->uncompleteForDate($habitId, $userId, date('Y-m-d'));
    }

    // ----------------------------------------------------------------
    // STATS — summary counts
    // ----------------------------------------------------------------
    public function getStats(int $userId): array {
        $today = date('Y-m-d');

        // Total active habits
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM habits WHERE user_id = ? AND is_active = 1");
        $stmt->execute([$userId]);
        $total = (int)$stmt->fetchColumn();

        // Habits scheduled for today
        $allHabits    = $this->getByUser($userId);
        $scheduledToday = 0;
        foreach ($allHabits as $h) {
            if ($this->isScheduledOnDate($h, $today)) $scheduledToday++;
        }

        // Completed today
        $stmt = $this->pdo->prepare("
            SELECT COUNT(DISTINCT hc.habit_id)
            FROM habit_completions hc
            INNER JOIN habits h ON h.id = hc.habit_id AND h.user_id = hc.user_id AND h.is_active = 1
            WHERE hc.user_id = ? AND hc.completion_date = ?
        ");
        $stmt->execute([$userId, $today]);
        $completedToday = (int)$stmt->fetchColumn();

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM habit_completions WHERE user_id = ?");
        $stmt->execute([$userId]);
        $totalCompletions = (int)$stmt->fetchColumn();

        return [
            'total_habits'      => $total,
            'scheduled_today'   => $scheduledToday,
            'completed_today'   => $completedToday,
            'total_completions' => $totalCompletions,
            'completion_rate'   => $scheduledToday > 0
                                    ? round(($completedToday / $scheduledToday) * 100)
                                    : 0
        ];
    }

    // ================================================================
    // Private helpers
    // ================================================================

    /**
     * Determine if a habit is "scheduled" (should appear) on a given date.
     */
    public function isScheduledOnDate(array $habit, string $date): bool {
        $startDate      = $habit['start_date']      ?? null;
        $endDate        = $habit['end_date']        ?? null;
        $frequency      = $habit['frequency']       ?? 'daily';
        $daysOfWeek     = $habit['days_of_week']    ?? '';
        $repeatInterval = max(1, (int)($habit['repeat_interval'] ?? 1));

        // Legacy habits with no start_date: always show (backwards compat)
        if (!$startDate) return true;

        // Outside date range
        if ($date < $startDate)              return false;
        if ($endDate && $date > $endDate)    return false;

        switch ($frequency) {
            case 'today':
                return $date === $startDate;

            case 'daily':
                return true; // already checked start/end

            case 'weekly':
                // days_of_week = comma-separated 0-6 (0=Sun, 6=Sat)
                $dayOfWeek  = (int)date('w', strtotime($date));
                $activeDays = array_filter(array_map('trim', explode(',', (string)$daysOfWeek)));
                return in_array((string)$dayOfWeek, $activeDays, true);

            case 'custom':
                // every N days from start_date
                $diff = (int)(
                    (strtotime($date) - strtotime($startDate)) / 86400
                );
                return $diff >= 0 && ($diff % $repeatInterval === 0);

            default:
                return false;
        }
    }

    /**
     * Calculate the current consecutive day streak for a habit.
     */
    public function getCurrentStreak(int $habitId, int $userId): int {
        $stmt = $this->pdo->prepare("
            SELECT completion_date 
            FROM habit_completions 
            WHERE habit_id = ? AND user_id = ? 
            ORDER BY completion_date DESC
        ");
        $stmt->execute([$habitId, $userId]);
        $dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($dates)) return 0;

        $streak = 0;
        $curr = new DateTime(date('Y-m-d'));
        
        // If the most recent completion wasn't today or yesterday, streak is 0
        $lastDate = new DateTime($dates[0]);
        $diff = $curr->diff($lastDate)->days;
        
        if ($diff > 1) return 0;

        $streak = 1;
        $prev = $lastDate;

        for ($i = 1; $i < count($dates); $i++) {
            $thisDate = new DateTime($dates[$i]);
            $interval = $prev->diff($thisDate)->days;
            
            if ($interval === 1) {
                $streak++;
                $prev = $thisDate;
            } elseif ($interval === 0) {
                // Same day completion, ignore
                continue;
            } else {
                break;
            }
        }
        
        return $streak;
    }

    /**
     * Get habits scheduled for today that haven't been completed yet.
     */
    public function getIncompleteHabitsForToday(int $userId): array {
        $today = date('Y-m-d');
        $all = $this->getByUser($userId);
        
        $pending = [];
        foreach ($all as $h) {
            if ($this->isScheduledOnDate($h, $today) && !$h['completed_today']) {
                $pending[] = $h;
            }
        }
        return $pending;
    }
}
