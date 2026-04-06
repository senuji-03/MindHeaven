<?php

class Counselor
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Create a new counselor record
     */
    public function create($userId, $data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO counselors (
                user_id, full_name, email, phone_number, license_number,
                specialization, years_experience, bio, is_approved
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)
        ");

        $stmt->execute([
            $userId,
            $data['full_name'],
            $data['email'] ?? null,
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
    public function getByUserId($userId)
    {
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
    public function update($userId, $data)
    {
        $fields = [];
        $values = [];

        $allowedFields = [
            'full_name', 'email', 'phone_number', 'license_number', 
            'specialization', 'years_experience', 'bio', 'hourly_rate', 'profile_picture'
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
    public function emailExists($email, $excludeUserId = null)
    {
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
    public function licenseExists($licenseNumber, $excludeUserId = null)
    {
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
    public function getAll($limit = null, $offset = 0)
    {
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
    public function getApproved($limit = null, $offset = 0)
    {
        $sql = "
            SELECT c.*, u.username, u.role 
            FROM counselors c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.is_active = 1 AND c.is_approved = 1
            ORDER BY c.created_at DESC
        ";

        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit',  (int)$limit,  PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
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
    public function approve($userId, $approvedBy)
    {
        $stmt = $this->pdo->prepare("
            UPDATE counselors 
            SET is_approved = 1, approved_at = CURRENT_TIMESTAMP, approved_by = ?
            WHERE user_id = ?
        ");
        return $stmt->execute([$approvedBy, $userId]);
    }

    /**
     * Deactivate counselor
     */
    public function deactivate($userId)
    {
        $stmt = $this->pdo->prepare("UPDATE counselors SET is_active = 0 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    /**
     * Get counselors by specialization
     */
    public function getBySpecialization($specialization)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.username, u.role 
            FROM counselors c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.is_active = 1 AND c.status = 'approved'
            AND c.specialization LIKE ?
            ORDER BY c.created_at DESC
        ");
        $stmt->execute(["%$specialization%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Get qualifications for a counselor
     */
    public function getQualifications($counselorId) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM counselor_qualifications 
            WHERE counselor_id = ?
            ORDER BY id ASC
        ");
        $stmt->execute([$counselorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sync qualifications for a counselor
     */
    public function syncQualifications($counselorId, $qualificationsList) {
        $this->pdo->beginTransaction();
        try {
            // Get existing qualifications
            $existing = $this->getQualifications($counselorId);
            $existingIds = array_column($existing, 'id');
            
            $incomingIds = [];
            foreach ($qualificationsList as $qual) {
                if (!empty($qual['id'])) {
                    $incomingIds[] = $qual['id'];
                }
            }
            
            // Delete missing qualifications
            $toDelete = array_diff($existingIds, $incomingIds);
            if (!empty($toDelete)) {
                $placeholders = str_repeat('?,', count($toDelete) - 1) . '?';
                $stmt = $this->pdo->prepare("DELETE FROM counselor_qualifications WHERE id IN ($placeholders) AND counselor_id = ?");
                $deleteParams = array_merge($toDelete, [$counselorId]);
                $stmt->execute($deleteParams);
            }
            
            // Insert or Update remaining
            $insertStmt = $this->pdo->prepare("
                INSERT INTO counselor_qualifications (counselor_id, title, institution, year_range, description)
                VALUES (?, ?, ?, ?, ?)
            ");
            $updateStmt = $this->pdo->prepare("
                UPDATE counselor_qualifications
                SET title = ?, institution = ?, year_range = ?, description = ?
                WHERE id = ? AND counselor_id = ?
            ");
            
            foreach ($qualificationsList as $qual) {
                if (empty($qual['id'])) {
                    $insertStmt->execute([
                        $counselorId,
                        $qual['title'],
                        $qual['institution'],
                        $qual['year'],
                        $qual['description']
                    ]);
                } else {
                    $updateStmt->execute([
                        $qual['title'],
                        $qual['institution'],
                        $qual['year'],
                        $qual['description'],
                        $qual['id'],
                        $counselorId
                    ]);
                }
            }
            
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error syncing qualifications: " . $e->getMessage());
            return false;
        }
    }
}
