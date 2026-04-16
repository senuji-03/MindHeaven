<?php

class Notification
{
    /**
     * Create a new notification
     */
    public function create($userId, $message, $type, $relatedId = null, $senderId = null)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO notifications (user_id, sender_id, message, type, related_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$userId, $senderId, $message, $type, $relatedId]);
    }

    /**
     * Get recent notifications for a user (limited to latest 20 as requested)
     */
    public function getRecentForUser($userId, $limit = 20)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT * FROM notifications 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        // Bind limit as integer
        $stmt->bindValue(1, (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get unread count for a user
     */
    public function getUnreadCount($userId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['count'] : 0;
    }

    /**
     * Mark a specific notification as read
     */
    public function markAsRead($id, $userId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
