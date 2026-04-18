<?php
require_once BASE_PATH . '/core/Database.php';

class Journal
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Fetch all reflections for a specific user
     */
    public function getByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `journal_entries` WHERE `user_id` = ? ORDER BY date(`created_at`) DESC, `created_at` DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new reflection
     */
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO `journal_entries` 
            (`user_id`, `title`, `content`, `mood_tag`, `category_tags`, `gratitude`, `highlight`, `created_at`)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $data['user_id'],
            $data['title'],
            $data['content'],
            $data['mood_tag'],
            $data['category_tags'],
            $data['gratitude'],
            $data['highlight']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Update an existing reflection
     */
    public function update(int $id, int $userId, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE `journal_entries` 
            SET `title` = ?, `content` = ?, `mood_tag` = ?, `category_tags` = ?, `gratitude` = ?, `highlight` = ?
            WHERE `id` = ? AND `user_id` = ?
        ");

        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['mood_tag'],
            $data['category_tags'],
            $data['gratitude'],
            $data['highlight'],
            $id,
            $userId
        ]);
    }

    /**
     * Delete a reflection
     */
    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM `journal_entries` WHERE `id` = ? AND `user_id` = ?");
        return $stmt->execute([$id, $userId]);
    }
}
