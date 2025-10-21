<?php

class Undergraduate {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Create a new undergraduate student record
     */
    public function create($userId, $data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO undergraduate_students (
                user_id, full_name, email, phone_number, date_of_birth, gender, preferred_language
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $userId,
            $data['full_name'],
            $data['email'],
            $data['phone_number'],
            $data['date_of_birth'] ?? null,
            $data['gender'] ?? null,
            $data['preferred_language'] ?? 'en'
        ]);
        
        return $this->pdo->lastInsertId();
    }

    /**
     * Get undergraduate student by user ID
     */
    public function getByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT us.*, u.username, u.role 
            FROM undergraduate_students us 
            JOIN users u ON us.user_id = u.id 
            WHERE us.user_id = ? AND us.is_active = 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update undergraduate student information
     */
    public function update($userId, $data) {
        $fields = [];
        $values = [];
        
        $allowedFields = [
            'full_name', 'email', 'phone_number', 'date_of_birth', 'gender', 'preferred_language'
        ];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                $values[] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $values[] = $userId;
        $sql = "UPDATE undergraduate_students SET " . implode(', ', $fields) . " WHERE user_id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Check if email already exists
     */
    public function emailExists($email, $excludeUserId = null) {
        $sql = "SELECT id FROM undergraduate_students WHERE email = ?";
        $params = [$email];
        
        if ($excludeUserId) {
            $sql .= " AND user_id != ?";
            $params[] = $excludeUserId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }

    /**
     * Get all undergraduate students (for admin)
     */
    public function getAll($limit = null, $offset = 0) {
        $sql = "
            SELECT us.*, u.username, u.role 
            FROM undergraduate_students us 
            JOIN users u ON us.user_id = u.id 
            WHERE us.is_active = 1
            ORDER BY us.created_at DESC
        ";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$limit, $offset]);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Deactivate undergraduate student
     */
    public function deactivate($userId) {
        $stmt = $this->pdo->prepare("UPDATE undergraduate_students SET is_active = 0 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
