<?php

class Feedback {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../../core/Database.php';
        $this->db = Database::getConnection();
    }

    /**
     * Create a new feedback entry
     */
    public function create($data) {
        $sql = "INSERT INTO feedback (user_id, feedback_type, counselor_id, title, content, rating, is_anonymous) 
                VALUES (:user_id, :feedback_type, :counselor_id, :title, :content, :rating, :is_anonymous)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array(
            ':user_id' => $data['user_id'],
            ':feedback_type' => $data['feedback_type'],
            ':counselor_id' => isset($data['counselor_id']) ? $data['counselor_id'] : null,
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':rating' => isset($data['rating']) ? $data['rating'] : null,
            ':is_anonymous' => isset($data['is_anonymous']) ? $data['is_anonymous'] : 0
        ));
    }

    /**
     * Read all feedback entries with optional filters
     */
    public function read($filters = array()) {
        $sql = "SELECT f.*, 
                COALESCE(us.full_name, u.full_name, u.username) as user_name, 
                c.full_name as counselor_name 
                FROM feedback f 
                LEFT JOIN users u ON f.user_id = u.id 
                LEFT JOIN undergraduate_students us ON f.user_id = us.user_id 
                LEFT JOIN counselors c ON f.counselor_id = c.id 
                WHERE 1=1";
        
        $params = array();
        
        if (isset($filters['feedback_type'])) {
            $sql .= " AND f.feedback_type = :feedback_type";
            $params[':feedback_type'] = $filters['feedback_type'];
        }
        
        if (isset($filters['counselor_id'])) {
            $sql .= " AND f.counselor_id = :counselor_id";
            $params[':counselor_id'] = $filters['counselor_id'];
        }
        
        if (isset($filters['user_id'])) {
            $sql .= " AND f.user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }
        
        $sql .= " ORDER BY f.created_at DESC";
        
        if (isset($filters['limit'])) {
            $sql .= " LIMIT :limit";
            $params[':limit'] = $filters['limit'];
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Read a single feedback entry by ID
     */
    public function readById($id) {
        $sql = "SELECT f.*, 
                COALESCE(us.full_name, u.full_name, u.username) as user_name, 
                c.full_name as counselor_name 
                FROM feedback f 
                LEFT JOIN users u ON f.user_id = u.id 
                LEFT JOIN undergraduate_students us ON f.user_id = us.user_id 
                LEFT JOIN counselors c ON f.counselor_id = c.id 
                WHERE f.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':id' => $id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a feedback entry
     */
    public function update($id, $data) {
        $sql = "UPDATE feedback SET 
                title = :title, 
                content = :content, 
                rating = :rating, 
                is_anonymous = :is_anonymous,
                updated_at = CURRENT_TIMESTAMP 
                WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array(
            ':id' => $id,
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':rating' => isset($data['rating']) ? $data['rating'] : null,
            ':is_anonymous' => isset($data['is_anonymous']) ? $data['is_anonymous'] : 0
        ));
    }

    /**
     * Soft delete a feedback entry (mark as deleted)
     */
    public function delete($id, $user_id) {
        $sql = "DELETE FROM feedback WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array(
            ':id' => $id,
            ':user_id' => $user_id
        ));
    }

    /**
     * Get all counselors for feedback selection
     */
    public function getCounselors() {
        $sql = "SELECT id, full_name, specialization, experience_years 
                FROM counselors 
                WHERE is_active = 1 
                ORDER BY full_name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get feedback statistics
     */
    public function getStats($filters = array()) {
        $sql = "SELECT 
                COUNT(*) as total_feedback,
                AVG(rating) as avg_rating,
                COUNT(CASE WHEN feedback_type = 'general' THEN 1 END) as general_feedback_count,
                COUNT(CASE WHEN feedback_type = 'counselor' THEN 1 END) as counselor_feedback_count,
                COUNT(CASE WHEN feedback_type = 'platform' THEN 1 END) as platform_feedback_count,
                COUNT(CASE WHEN feedback_type = 'feature_request' THEN 1 END) as feature_request_count
                FROM feedback 
                WHERE 1=1";
        
        $params = array();
        
        if (isset($filters['counselor_id'])) {
            $sql .= " AND counselor_id = :counselor_id";
            $params[':counselor_id'] = $filters['counselor_id'];
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check if user owns the feedback
     */
    public function isOwner($feedback_id, $user_id) {
        $sql = "SELECT COUNT(*) FROM feedback WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':id' => $feedback_id, ':user_id' => $user_id));
        return $stmt->fetchColumn() > 0;
    }
}
