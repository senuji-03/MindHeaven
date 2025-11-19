<?php

class Counselor {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Create a new counselor record
     */
    public function create($userId, $data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO counselors (
                user_id, full_name, email, phone_number, license_number,
                specialization, experience_years, bio, is_approved
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)
        ");
        
        $stmt->execute([
            $userId,
            $data['full_name'],
            $data['email'],
            $data['phone_number'],
            $data['license_number'],
            $data['specialization'] ?? null,
            $data['years_experience'] ?? null,
            $data['bio'] ?? null
        ]);
        
        return $this->pdo->lastInsertId();
    }

    /**
     * Get counselor by user ID
     */
    public function getByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.username, u.role 
            FROM counselors c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.user_id = ? AND c.is_active = 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update counselor information
     */
    public function update($userId, $data) {
        $fields = [];
        $values = [];
        
        $allowedFields = [
            'full_name', 'email', 'phone_number', 'license_number', 
            'specialization', 'years_experience', 'bio', 'hourly_rate'
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
        $sql = "UPDATE counselors SET " . implode(', ', $fields) . " WHERE user_id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Check if email already exists in counselors table
     */
    public function emailExists($email, $excludeUserId = null) {
        $sql = "SELECT id FROM counselors WHERE email = ?";
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
     * Check if license number already exists
     */
    public function licenseExists($licenseNumber, $excludeUserId = null) {
        $sql = "SELECT id FROM counselors WHERE license_number = ?";
        $params = [$licenseNumber];
        
        if ($excludeUserId) {
            $sql .= " AND user_id != ?";
            $params[] = $excludeUserId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }

    /**
     * Get all counselors (for admin)
     */
    public function getAll($limit = null, $offset = 0) {
        $sql = "
            SELECT c.*, u.username, u.role 
            FROM counselors c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.is_active = 1
            ORDER BY c.created_at DESC
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
     * Get approved counselors only
     */
    public function getApproved($limit = null, $offset = 0) {
        $sql = "
            SELECT c.*, u.username, u.role 
            FROM counselors c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.is_active = 1 AND c.is_approved = 1
            ORDER BY c.created_at DESC
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
     * Get pending counselors (not approved yet)
     */
    public function getPending($limit = null, $offset = 0) {
        $sql = "
            SELECT c.*, u.username, u.role 
            FROM counselors c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.is_active = 1 AND c.is_approved = 0
            ORDER BY c.created_at DESC
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
     * Approve counselor
     */
    public function approve($userId, $approvedBy) {
        $stmt = $this->pdo->prepare("
            UPDATE counselors 
            SET is_approved = 1, approved_at = NOW(), approved_by = ? 
            WHERE user_id = ?
        ");
        return $stmt->execute([$approvedBy, $userId]);
    }

    /**
     * Deactivate counselor
     */
    public function deactivate($userId) {
        $stmt = $this->pdo->prepare("UPDATE counselors SET is_active = 0 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    /**
     * Get counselors by specialization
     */
    public function getBySpecialization($specialization) {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.username, u.role 
            FROM counselors c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.is_active = 1 AND c.is_approved = 1 
            AND c.specialization LIKE ?
            ORDER BY c.created_at DESC
        ");
        $stmt->execute(["%$specialization%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
