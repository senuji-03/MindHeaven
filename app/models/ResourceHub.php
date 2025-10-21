<?php

class ResourceHub {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO resource_hub (
                title, category, content_type, content, file_path, file_name, 
                file_size, file_type, summary, tags, status, created_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['title'],
            $data['category'],
            $data['content_type'],
            $data['content'] ?? null,
            $data['file_path'] ?? null,
            $data['file_name'] ?? null,
            $data['file_size'] ?? null,
            $data['file_type'] ?? null,
            $data['summary'] ?? null,
            $data['tags'] ?? null,
            $data['status'] ?? 'draft',
            $data['created_by']
        ]);
    }

    public function getAll($status = null) {
        $sql = "SELECT * FROM resource_hub";
        $params = [];
        
        if ($status) {
            $sql .= " WHERE status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM resource_hub WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE resource_hub SET 
                title = ?, category = ?, content_type = ?, content = ?, 
                file_path = ?, file_name = ?, file_size = ?, file_type = ?, 
                summary = ?, tags = ?, status = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['title'],
            $data['category'],
            $data['content_type'],
            $data['content'] ?? null,
            $data['file_path'] ?? null,
            $data['file_name'] ?? null,
            $data['file_size'] ?? null,
            $data['file_type'] ?? null,
            $data['summary'] ?? null,
            $data['tags'] ?? null,
            $data['status'] ?? 'draft',
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM resource_hub WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getByCategory($category, $status = 'published') {
        $stmt = $this->pdo->prepare("SELECT * FROM resource_hub WHERE category = ? AND status = ? ORDER BY created_at DESC");
        $stmt->execute([$category, $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByContentType($contentType) {
        $stmt = $this->pdo->prepare("SELECT * FROM resource_hub WHERE content_type = ? AND status = 'published' ORDER BY created_at DESC");
        $stmt->execute([$contentType]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($query) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM resource_hub 
            WHERE (title LIKE ? OR content LIKE ? OR summary LIKE ? OR tags LIKE ?) 
            AND status = 'published' 
            ORDER BY created_at DESC
        ");
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->pdo->prepare("SELECT DISTINCT category FROM resource_hub WHERE status = 'published' ORDER BY category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
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
}
