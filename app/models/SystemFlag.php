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
        // Prevent duplicates
        $sql = "SELECT id FROM system_flags 
                WHERE content_id = ? AND content_type = ? AND matched_keyword = ? AND status = 'pending'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data['content_id'], $data['content_type'], $data['matched_keyword']]);

        if ($stmt->fetchColumn()) {
            return false; // Already flagged
        }

        $sql = "INSERT INTO system_flags (content_id, content_type, user_id, matched_keyword) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['content_id'],
            $data['content_type'],
            $data['user_id'],
            $data['matched_keyword']
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
}
