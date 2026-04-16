<?php

class ResourceHub {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO resource_hub (
                    title, category, content_type, content, file_path, file_name, 
                    file_size, file_type, youtube_url, summary, tags, status, created_by
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $values = array(
                $data['title'],
                $data['category'],
                $data['content_type'],
                isset($data['content']) ? $data['content'] : null,
                isset($data['file_path']) ? $data['file_path'] : null,
                isset($data['file_name']) ? $data['file_name'] : null,
                isset($data['file_size']) ? $data['file_size'] : null,
                isset($data['file_type']) ? $data['file_type'] : null,
                isset($data['youtube_url']) ? $data['youtube_url'] : null,
                isset($data['summary']) ? $data['summary'] : null,
                isset($data['tags']) ? $data['tags'] : null,
                isset($data['status']) ? $data['status'] : 'draft',
                $data['created_by']
            );

            $result = $stmt->execute($values);
            
            // Log successful creation
            if ($result) {
                $statusLog = isset($data['status']) ? $data['status'] : 'draft';
                error_log("Resource created successfully: " . $data['title'] . " (Status: " . $statusLog . ")");
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Resource creation failed: " . $e->getMessage());
            return false;
        }
    }

    public function getAll($status = null) {
        $sql = "SELECT * FROM resource_hub";
        $params = array();
        
        if ($status) {
            $sql .= " WHERE status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY likes_count DESC, created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM resource_hub WHERE id = ?");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE resource_hub SET 
                title = ?, category = ?, content_type = ?, content = ?, 
                file_path = ?, file_name = ?, file_size = ?, file_type = ?, 
                youtube_url = ?, summary = ?, tags = ?, status = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        
        return $stmt->execute(array(
            $data['title'],
            $data['category'],
            $data['content_type'],
            isset($data['content']) ? $data['content'] : null,
            isset($data['file_path']) ? $data['file_path'] : null,
            isset($data['file_name']) ? $data['file_name'] : null,
            isset($data['file_size']) ? $data['file_size'] : null,
            isset($data['file_type']) ? $data['file_type'] : null,
            isset($data['youtube_url']) ? $data['youtube_url'] : null,
            isset($data['summary']) ? $data['summary'] : null,
            isset($data['tags']) ? $data['tags'] : null,
            isset($data['status']) ? $data['status'] : 'draft',
            $id
        ));
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM resource_hub WHERE id = ?");
        return $stmt->execute(array($id));
    }

    public function getByCategory($category, $status = 'published') {
        $stmt = $this->pdo->prepare("SELECT * FROM resource_hub WHERE category = ? AND status = ? ORDER BY likes_count DESC, created_at DESC");
        $stmt->execute(array($category, $status));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByContentType($contentType) {
        $stmt = $this->pdo->prepare("SELECT * FROM resource_hub WHERE content_type = ? AND status = 'published' ORDER BY likes_count DESC, created_at DESC");
        $stmt->execute(array($contentType));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($query) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM resource_hub 
            WHERE (title LIKE ? OR content LIKE ? OR summary LIKE ? OR tags LIKE ?) 
            AND status = 'published' 
            ORDER BY likes_count DESC, created_at DESC
        ");
        $searchTerm = "%" . $query . "%";
        $stmt->execute(array($searchTerm, $searchTerm, $searchTerm, $searchTerm));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT name, description, thumbnail FROM resource_categories WHERE is_active = 1 ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStats() {
        $stmt = $this->pdo->prepare("
            SELECT 
                COUNT(*) as total_resources,
                SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived
            FROM resource_hub
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCountByCategory() {
        $stmt = $this->pdo->prepare("
            SELECT category, COUNT(*) as count 
            FROM resource_hub 
            GROUP BY category
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function toggleLike($resourceId, $userId) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM resource_likes WHERE resource_id = ? AND user_id = ?");
        $stmt->execute(array($resourceId, $userId));
        if ($stmt->fetch()) {
            $stmt = $this->pdo->prepare("DELETE FROM resource_likes WHERE resource_id = ? AND user_id = ?");
            $stmt->execute(array($resourceId, $userId));
            $stmt = $this->pdo->prepare("UPDATE resource_hub SET likes_count = GREATEST(0, likes_count - 1) WHERE id = ?");
            $stmt->execute(array($resourceId));
            return array('action' => 'unliked');
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO resource_likes (resource_id, user_id) VALUES (?, ?)");
            $stmt->execute(array($resourceId, $userId));
            $stmt = $this->pdo->prepare("UPDATE resource_hub SET likes_count = likes_count + 1 WHERE id = ?");
            $stmt->execute(array($resourceId));
            return array('action' => 'liked');
        }
    }

    public function getUserLikes($userId) {
        $stmt = $this->pdo->prepare("SELECT resource_id FROM resource_likes WHERE user_id = ?");
        $stmt->execute(array($userId));
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getComments($resourceId) {
        $stmt = $this->pdo->prepare("
            SELECT rc.*, u.username as user_name 
            FROM resource_comments rc 
            LEFT JOIN users u ON rc.user_id = u.id 
            WHERE rc.resource_id = ? 
            ORDER BY rc.created_at DESC
        ");
        $stmt->execute(array($resourceId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment($resourceId, $userId, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO resource_comments (resource_id, user_id, comment) VALUES (?, ?, ?)");
        return $stmt->execute(array($resourceId, $userId, $comment));
    }

    public function hasUserReportedResource($resourceId, $userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM resource_reports WHERE resource_id = ? AND user_id = ?");
        $stmt->execute(array($resourceId, $userId));
        return $stmt->fetchColumn() > 0;
    }

    public function hasUserExceededDailyReports($userId, $limit = 5) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM resource_reports WHERE user_id = ? AND DATE(created_at) = CURDATE()");
        $stmt->execute(array($userId));
        return $stmt->fetchColumn() >= $limit;
    }

    public function reportResource($resourceId, $userId, $reason, $description) {
        if ($this->hasUserReportedResource($resourceId, $userId) || $this->hasUserExceededDailyReports($userId)) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO resource_reports (resource_id, user_id, reason, description) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute(array($resourceId, $userId, $reason, $description));

        if ($success) {
            // Check threshold for auto-flagging
            $stmtCount = $this->pdo->prepare("SELECT COUNT(*) FROM resource_reports WHERE resource_id = ? AND status = 'pending'");
            $stmtCount->execute(array($resourceId));
            $count = $stmtCount->fetchColumn();

            if ($count >= 3) {
                // Auto-hide the resource
                $stmtHide = $this->pdo->prepare("UPDATE resource_hub SET status = 'flagged' WHERE id = ?");
                $stmtHide->execute(array($resourceId));
            }
        }
        return $success;
    }

    public function getPendingReports() {
        $stmt = $this->pdo->prepare("
            SELECT r.*, rh.title as resource_title, u.username as reported_by
            FROM resource_reports r
            JOIN resource_hub rh ON r.resource_id = rh.id
            JOIN users u ON r.user_id = u.id
            WHERE r.status = 'pending'
            ORDER BY r.created_at ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function reviewReport($reportId, $moderatorId, $actionTaken, $rejectOrReviewed) {
        // rejectOrReviewed can be 'rejected' or 'reviewed'
        $stmt = $this->pdo->prepare("UPDATE resource_reports SET status = ?, reviewed_by = ?, action_taken = ? WHERE id = ?");
        return $stmt->execute(array($rejectOrReviewed, $moderatorId, $actionTaken, $reportId));
    }

}
