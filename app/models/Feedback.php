<?php

class Feedback
{
    private $db;

    public function __construct()
    {
        require_once __DIR__ . '/../../core/Database.php';
        $this->db = Database::getConnection();
    }

    /**
     * Create a new feedback entry
     */
    public function create($data)
    {
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
     * Read all feedback entries with privacy filtering.
     * @param array $filters 
     *      - feedback_type
     *      - counselor_id
     *      - user_id
     *      - viewer_id (The ID of the user requesting the data)
     *      - viewer_role (The role of the user requesting the data: 'undergraduate', 'counselor', 'admin', etc.)
     */
    public function read($filters = array())
    {
        $sql = "SELECT f.*, 
                COALESCE(us.full_name, u.full_name, u.username) as user_name, 
                c.full_name as counselor_name 
                FROM feedback f 
                LEFT JOIN users u ON f.user_id = u.id 
                LEFT JOIN undergraduate_students us ON f.user_id = us.user_id 
                LEFT JOIN counselors c ON f.counselor_id = c.id 
                WHERE 1=1";

        $params = array();

        // --- Privacy Logic ---
        $viewerId = $filters['viewer_id'] ?? null;
        $viewerRole = $filters['viewer_role'] ?? 'public';

        if ($viewerRole !== 'admin' && $viewerRole !== 'moderator') {
            // Non-admins have restricted access to counselor feedback
            $sql .= " AND (f.feedback_type != 'counselor' "; // Platform/General is public
            
            if ($viewerId !== null) {
                if ($viewerRole === 'undergraduate') {
                    // Students can also see their own counselor feedback
                    $sql .= " OR f.user_id = :viewer_id";
                    $params[':viewer_id'] = $viewerId;
                } elseif ($viewerRole === 'counselor') {
                    // Counselors can see feedback directed at them
                    // We need to match f.counselor_id with the counselor's ID in the counselors table
                    $sql .= " OR f.counselor_id = (SELECT id FROM counselors WHERE user_id = :viewer_id LIMIT 1)";
                    $params[':viewer_id'] = $viewerId;
                }
            }
            $sql .= ")";
        }

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
    public function readById($id)
    {
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
    public function update($id, $data)
    {
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
    public function delete($id, $user_id)
    {
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
    public function getCounselors()
    {
        $sql = "SELECT id, full_name, specialization, years_experience 
                FROM counselors 
                WHERE is_active = 1 
                ORDER BY full_name";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get feedback statistics with privacy filtering
     */
    public function getStats($filters = array())
    {
        $sql = "SELECT 
                COUNT(*) as total_feedback,
                AVG(rating) as avg_rating,
                COUNT(CASE WHEN feedback_type = 'general' THEN 1 END) as general_feedback_count,
                COUNT(CASE WHEN feedback_type = 'counselor' THEN 1 END) as counselor_feedback_count,
                COUNT(CASE WHEN feedback_type = 'platform' THEN 1 END) as platform_feedback_count,
                COUNT(CASE WHEN feedback_type = 'feature_request' THEN 1 END) as feature_request_count
                FROM feedback f
                WHERE 1=1";

        $params = array();

        // --- Privacy Logic ---
        $viewerId = $filters['viewer_id'] ?? null;
        $viewerRole = $filters['viewer_role'] ?? 'public';

        if ($viewerRole !== 'admin' && $viewerRole !== 'moderator') {
            // Non-admins have restricted access to counselor feedback stats
            $sql .= " AND (f.feedback_type != 'counselor' ";
            
            if ($viewerId !== null) {
                if ($viewerRole === 'undergraduate') {
                    $sql .= " OR f.user_id = :viewer_id";
                    $params[':viewer_id'] = $viewerId;
                } elseif ($viewerRole === 'counselor') {
                    $sql .= " OR f.counselor_id = (SELECT id FROM counselors WHERE user_id = :viewer_id LIMIT 1)";
                    $params[':viewer_id'] = $viewerId;
                }
            }
            $sql .= ")";
        }

        if (isset($filters['counselor_id'])) {
            $sql .= " AND f.counselor_id = :counselor_id";
            $params[':counselor_id'] = $filters['counselor_id'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get counselor feedback (feedback_type = 'counselor') for a specific counselor.
     * Used on counselor dashboard to show feedback from undergraduates.
     */
    public function getCounselorFeedback($counselor_id, $limit = 10) {
        $sql = "SELECT f.*, 
                COALESCE(us.full_name, u.full_name, u.username) as user_name, 
                c.full_name as counselor_name 
                FROM feedback f 
                LEFT JOIN users u ON f.user_id = u.id 
                LEFT JOIN undergraduate_students us ON f.user_id = us.user_id 
                LEFT JOIN counselors c ON f.counselor_id = c.id 
                WHERE f.feedback_type = 'counselor' AND f.counselor_id = :counselor_id 
                ORDER BY f.created_at DESC 
                LIMIT " . (int) $limit;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':counselor_id' => $counselor_id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if user owns the feedback
     */
    public function isOwner($feedback_id, $user_id)
    {
        $sql = "SELECT COUNT(*) FROM feedback WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':id' => $feedback_id, ':user_id' => $user_id));
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Get public platform/general feedbacks for display on the landing page.
     * Only returns entries with non-empty content.
     * @param int $limit
     * @return array
     */
    public function getPublicPlatformFeedbacks($limit = 6)
    {
        $sql = "SELECT f.id, f.content, f.rating, f.is_anonymous, f.feedback_type, f.created_at,
                CASE WHEN f.is_anonymous = 1 THEN NULL
                     ELSE COALESCE(us.full_name, u.full_name, u.username)
                END as user_name,
                us.year_of_study, us.major
                FROM feedback f
                LEFT JOIN users u ON f.user_id = u.id
                LEFT JOIN undergraduate_students us ON f.user_id = us.user_id
                WHERE f.feedback_type IN ('platform', 'general')
                  AND f.content IS NOT NULL
                  AND LENGTH(TRIM(f.content)) > 20
                ORDER BY f.rating DESC, f.created_at DESC
                LIMIT " . (int) $limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get average ratings for multiple counselors in bulk.
     * @param array $counselorIds
     * @return array Mapping of counselor_id => avg_rating
     */
    public function getAvgRatingsBulk($counselorIds)
    {
        if (empty($counselorIds)) return array();
        $placeholders = str_repeat('?,', count($counselorIds) - 1) . '?';
        $sql = "SELECT counselor_id, AVG(rating) as avg_rating 
                FROM feedback 
                WHERE counselor_id IN ($placeholders) 
                GROUP BY counselor_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($counselorIds);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
