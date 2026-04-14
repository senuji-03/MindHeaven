<?php

class CallResponderControl {

    public function index() {
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['call_responder', 'admin'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require BASE_PATH . '/app/views/CallResponder/CallPage.php';
    }

    public function dashboard() {
        $this->index();
    }

    public function success() {
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['call_responder', 'admin'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT c.*, COALESCE(u.full_name, u.username, 'Anonymous') AS caller_name 
                                   FROM crisis_calls c 
                                   LEFT JOIN users u ON c.caller_user_id = u.id 
                                   WHERE c.status IN ('completed', 'escalated') AND c.responder_user_id = ?
                                   ORDER BY c.updated_at DESC");
            $stmt->execute([$_SESSION['user_id']]);
            $callLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $callLogs = [];
        }

        require BASE_PATH . '/app/views/CallResponder/CallSuccess.php';
    }

}