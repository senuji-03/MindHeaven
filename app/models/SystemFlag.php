<?php

require_once __DIR__ . '/../../core/Database.php';

class SystemFlag
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function create($data)
    {
        $contentId = $data['content_id'] ?? null;
        $contentType = trim((string) ($data['content_type'] ?? ''));
        $userId = $data['user_id'] ?? null;
        $matchedKeyword = trim((string) ($data['matched_keyword'] ?? ''));

        // Normalize content type to match DB enum('thread','post')
        if (in_array($contentType, ['reply', 'reply_reply', 'post_reply'], true)) {
            $contentType = 'post';
        }

        // Reject invalid / empty content types
        if (!in_array($contentType, ['thread', 'post'], true)) {
            return false;
        }

        if (empty($contentId) || empty($userId) || $matchedKeyword === '') {
            return false;
        }

        // Prevent duplicates
        $sql = "SELECT id FROM system_flags 
                WHERE content_id = ? AND content_type = ? AND matched_keyword = ? AND status = 'pending'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$contentId, $contentType, $matchedKeyword]);

        if ($stmt->fetchColumn()) {
            return false;
        }

        $sql = "INSERT INTO system_flags (content_id, content_type, user_id, matched_keyword) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $contentId,
            $contentType,
            $userId,
            $matchedKeyword
        ]);
    }

    public function getAll($status = 'pending')
    {
        $sql = "SELECT sf.*, 
                       u.username as owner_name,
                       u.strike_count,
                       u.account_status,
                       u.id as owner_id
                FROM system_flags sf 
                JOIN users u ON sf.user_id = u.id 
                WHERE sf.status = ? 
                ORDER BY sf.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveFlagCount()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM system_flags WHERE status = 'pending'");
        return $stmt->fetchColumn();
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE system_flags SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    /**
     * Resolve all pending system flags associated with a specific piece of content
     */
    public function resolveByContent($contentType, $contentId)
    {
        // Normalize content type for DB
        if (in_array($contentType, ['reply', 'reply_reply', 'post_reply'], true)) {
            $contentType = 'post';
        }

        $sql = "UPDATE system_flags SET status = 'resolved' WHERE content_type = ? AND content_id = ? AND status = 'pending'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$contentType, $contentId]);
    }
}