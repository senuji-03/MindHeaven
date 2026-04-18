<?php

class Report
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getTotalCount($status = null)
    {
        if ($status) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reports WHERE status = ?");
            $stmt->execute([$status]);
            return $stmt->fetchColumn();
        }
        
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM reports");
        return $stmt->fetchColumn();
    }

    /**
     * Create a new report
     */
    public function create($data)
    {
        $sql = "INSERT INTO reports (reporter_id, content_owner_id, content_type, content_id, category_id, explanation) 
                VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['reporter_id'],
                $data['content_owner_id'],
                $data['content_type'],
                $data['content_id'],
                $data['category_id'],
                $data['explanation'] ?? null
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Report Create Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all active report categories
     */
    public function getCategories()
    {
        $stmt = $this->pdo->query("SELECT * FROM report_categories WHERE is_active = 1 ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get report by ID
     */
    public function getById($id)
    {
        $sql = "SELECT r.*, 
                       u_reporter.username as reporter_name, u_reporter.role as reporter_role,
                       u_owner.username as owner_name, u_owner.role as owner_role,
                       cat.name as category_name
                FROM reports r
                JOIN users u_reporter ON r.reporter_id = u_reporter.id
                JOIN users u_owner ON r.content_owner_id = u_owner.id
                JOIN report_categories cat ON r.category_id = cat.id
                WHERE r.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all reports with filters
     */
    public function getAll($status = 'pending', $limit = 20, $offset = 0)
    {
        $sql = "SELECT r.*, 
                       u_reporter.username as reporter_name, 
                       u_owner.username as owner_name,
                       u_owner.strike_count,
                       u_owner.account_status,
                       u_owner.id as owner_id,
                       cat.name as category_name
                FROM reports r
                JOIN users u_reporter ON r.reporter_id = u_reporter.id
                JOIN users u_owner ON r.content_owner_id = u_owner.id
                JOIN report_categories cat ON r.category_id = cat.id
                WHERE r.status = ?
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $status);
        $stmt->bindValue(2, (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update report status
     */
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE reports SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    /**
     * Get all categories (including inactive if requested)
     */
    public function getAllCategories($includeInactive = false)
    {
        $sql = "SELECT * FROM report_categories";
        if (!$includeInactive) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY name ASC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCategory($name, $description)
    {
        $sql = "INSERT INTO report_categories (name, description, is_active) VALUES (?, ?, 1)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description]);
    }

    public function updateCategory($id, $name, $description)
    {
        $sql = "UPDATE report_categories SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $id]);
    }

    public function deleteCategory($id)
    {
        // Soft delete
        $sql = "UPDATE report_categories SET is_active = 0 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function activateCategory($id)
    {
        $sql = "UPDATE report_categories SET is_active = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Check if user has already reported this content
     */
    public function hasUserReported($userId, $contentType, $contentId)
    {
        $sql = "SELECT id FROM reports WHERE reporter_id = ? AND content_type = ? AND content_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $contentType, $contentId]);
        return $stmt->fetchColumn() !== false;
    }

    public function markStrikeGiven($id)
    {
        $sql = "UPDATE reports SET strike_given = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Resolve all pending reports associated with a specific piece of content
     */
    public function resolveByContent($contentType, $contentId)
    {
        // If it's any form of post/reply, we want to clear all variants
        if (in_array($contentType, ['post', 'reply', 'reply_reply'])) {
            $types = ['post', 'reply', 'reply_reply'];
            $placeholders = implode(',', array_fill(0, count($types), '?'));
            $sql = "UPDATE reports SET status = 'resolved' WHERE content_type IN ($placeholders) AND content_id = ? AND status = 'pending'";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array_merge($types, [$contentId]));
        }

        $sql = "UPDATE reports SET status = 'resolved' WHERE content_type = ? AND content_id = ? AND status = 'pending'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$contentType, $contentId]);
    }
}
