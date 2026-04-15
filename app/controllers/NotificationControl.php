<?php

require_once BASE_PATH . '/app/models/Notification.php';

class NotificationControl
{
    private $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new Notification();
    }

    /**
     * GET /api/notifications
     * Fetch the latest 20 notifications for the logged-in user.
     */
    public function list()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            return $this->json(['error' => 'Not logged in'], 401);
        }

        try {
            $userId = (int)$_SESSION['user_id'];
            $notifications = $this->notificationModel->getRecentForUser($userId, 20);
            $unreadCount = $this->notificationModel->getUnreadCount($userId);

            $this->json([
                'success' => true,
                'notifications' => $notifications,
                'unreadCount' => $unreadCount
            ]);
        } catch (Exception $e) {
            error_log("NotificationControl list error: " . $e->getMessage());
            $this->json(['error' => 'Failed to fetch notifications'], 500);
        }
    }

    /**
     * GET /api/notifications/unread-count
     */
    public function unreadCount()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            return $this->json(['error' => 'Not logged in'], 401);
        }

        try {
            $count = $this->notificationModel->getUnreadCount((int)$_SESSION['user_id']);
            $this->json(['success' => true, 'count' => $count]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to fetch count'], 500);
        }
    }

    /**
     * POST /api/notifications/mark-read
     */
    public function markRead()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            return $this->json(['error' => 'Not logged in'], 401);
        }

        $data = $this->getJsonInput();
        $userId = (int)$_SESSION['user_id'];

        try {
            if (isset($data['all']) && $data['all'] === true) {
                $this->notificationModel->markAllAsRead($userId);
            } elseif (isset($data['id'])) {
                $this->notificationModel->markAsRead((int)$data['id'], $userId);
            } else {
                return $this->json(['error' => 'Missing notification ID or all=true'], 400);
            }

            $this->json(['success' => true]);
        } catch (Exception $e) {
            $this->json(['error' => 'Failed to update notifications'], 500);
        }
    }

    private function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function getJsonInput()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
}
