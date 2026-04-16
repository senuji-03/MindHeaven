<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/core/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class MoodApiControl {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // ── Auth helper ──────────────────────────────────────────────────
    private function requireAuth(): int {
        if (empty($_SESSION['user_id'])) {
            $this->json(['error' => 'Unauthorized'], 401);
            exit;
        }
        return (int)$_SESSION['user_id'];
    }

    private function json($data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function body(): array {
        $raw = file_get_contents('php://input');
        return json_decode($raw, true) ?: [];
    }

    // ── GET /api/mood/list ───────────────────────────────────────────
    public function list(): void {
        $userId = $this->requireAuth();
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM mood_records
                WHERE user_id = ?
                ORDER BY recorded_at DESC
                LIMIT 200
            ");
            $stmt->execute([$userId]);
            $this->json(['records' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to load: ' . $e->getMessage()], 500);
        }
    }

    // ── POST /api/mood/create ────────────────────────────────────────
    public function create(): void {
        $userId = $this->requireAuth();
        $d = $this->body();

        $moodType = trim($d['mood_type'] ?? '');
        $moodLevel = (int)($d['mood_level'] ?? 5);

        if (!$moodType) {
            $this->json(['error' => 'mood_type is required'], 400);
            return;
        }

        $allowed = ['happy','sad','anxious','angry','calm','excited','tired','stressed','confused','grateful','neutral'];
        if (!in_array($moodType, $allowed)) {
            $this->json(['error' => 'Invalid mood_type'], 400);
            return;
        }

        $moodLevel = max(1, min(10, $moodLevel));

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO mood_records
                    (user_id, mood_type, mood_level, notes, triggers,
                     sleep_hours, exercise_minutes, social_interaction, recorded_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $userId,
                $moodType,
                $moodLevel,
                $d['notes']              ?? null,
                $d['triggers']           ?? null,
                isset($d['sleep_hours'])      && $d['sleep_hours'] !== '' ? $d['sleep_hours'] : null,
                isset($d['exercise_minutes']) && $d['exercise_minutes'] !== '' ? (int)$d['exercise_minutes'] : null,
                $d['social_interaction'] ?? null,
            ]);
            $this->json(['id' => (int)$this->pdo->lastInsertId(), 'message' => 'Mood logged'], 201);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to save: ' . $e->getMessage()], 500);
        }
    }

    // ── PUT /api/mood/update ─────────────────────────────────────────
    public function update(): void {
        $userId = $this->requireAuth();
        $d = $this->body();

        $id = (int)($d['id'] ?? 0);
        if (!$id) { $this->json(['error' => 'id is required'], 400); return; }

        $moodType  = trim($d['mood_type'] ?? '');
        $moodLevel = max(1, min(10, (int)($d['mood_level'] ?? 5)));

        if (!$moodType) { $this->json(['error' => 'mood_type is required'], 400); return; }

        $allowed = ['happy','sad','anxious','angry','calm','excited','tired','stressed','confused','grateful','neutral'];
        if (!in_array($moodType, $allowed)) {
            $this->json(['error' => 'Invalid mood_type'], 400);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("
                UPDATE mood_records
                SET mood_type = ?, mood_level = ?, notes = ?, triggers = ?,
                    sleep_hours = ?, exercise_minutes = ?, social_interaction = ?
                WHERE id = ? AND user_id = ?
            ");
            $stmt->execute([
                $moodType,
                $moodLevel,
                $d['notes']              ?? null,
                $d['triggers']           ?? null,
                isset($d['sleep_hours'])      && $d['sleep_hours'] !== '' ? $d['sleep_hours'] : null,
                isset($d['exercise_minutes']) && $d['exercise_minutes'] !== '' ? (int)$d['exercise_minutes'] : null,
                $d['social_interaction'] ?? null,
                $id,
                $userId,
            ]);
            if ($stmt->rowCount() === 0) {
                $this->json(['error' => 'Record not found or not yours'], 404);
                return;
            }
            $this->json(['message' => 'Updated']);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to update: ' . $e->getMessage()], 500);
        }
    }

    // ── DELETE /api/mood/delete ──────────────────────────────────────
    public function delete(): void {
        $userId = $this->requireAuth();
        $d = $this->body();

        $id = (int)($d['id'] ?? 0);
        if (!$id) { $this->json(['error' => 'id is required'], 400); return; }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM mood_records WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $userId]);
            if ($stmt->rowCount() === 0) {
                $this->json(['error' => 'Record not found or not yours'], 404);
                return;
            }
            $this->json(['message' => 'Deleted']);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to delete: ' . $e->getMessage()], 500);
        }
    }
}
