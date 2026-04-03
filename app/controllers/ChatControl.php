<?php

require_once BASE_PATH . '/app/models/Chat.php';
require_once BASE_PATH . '/core/Auth.php';

/**
 * ChatControl
 * Page views + AJAX JSON endpoints for the secure chat system.
 * All endpoints verify the logged-in user belongs to the chat session
 * before touching any data.
 */
class ChatControl {

    private Chat $chatModel;

    public function __construct() {
        $this->chatModel = new Chat();
        $this->requireSession();
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    /** Redirect to login if no session is active. */
    private function requireSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /** Return the logged-in user's ID as int. */
    private function userId(): int {
        return (int)$_SESSION['user_id'];
    }

    /** Return the logged-in user's role. */
    private function userRole(): string {
        return $_SESSION['role'] ?? '';
    }

    /** Send a JSON response and stop execution. */
    private function json(array $payload, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($payload);
        exit;
    }

    /** Read JSON body sent via fetch(). */
    private function jsonBody(): array {
        $raw = file_get_contents('php://input');
        if (!$raw) {
            return [];
        }
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    // =========================================================================
    // PAGE VIEWS
    // =========================================================================

    /**
     * GET /chat
     * Chat inbox – list of sessions for the logged-in user.
     * Counselors see their undergrad contacts; undergrads see their counselors.
     */
    public function index(): void {
        $userId = $this->userId();
        $role   = $this->userRole();

        if ($role === 'counselor') {
            $sessions   = $this->chatModel->getSessionsForCounselor($userId);
            $undergrads = $this->chatModel->getUndergradsByAppointments($userId);
            view('/counselor/chat', [
                'sessions'   => $sessions,
                'undergrads' => $undergrads,
            ]);
        } elseif ($role === 'undergrad') {
            $sessions = $this->chatModel->getSessionsForUndergrad($userId);
            view('/undergrad/chat', [
                'sessions' => $sessions,
            ]);
        } else {
            // Only counselors and undergrads have chat access
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /**
     * GET /chat/room?session_id=X
     * Load the shared chat room view after verifying access.
     */
    public function room(): void {
        $sessionId = isset($_GET['session_id']) ? (int)$_GET['session_id'] : 0;
        $userId    = $this->userId();

        if (!$sessionId) {
            header('Location: ' . BASE_URL . '/chat');
            exit;
        }

        // Security: ensure user is a participant in this session
        if (!$this->chatModel->userBelongsToSession($sessionId, $userId)) {
            http_response_code(403);
            echo '<h2>Access Denied</h2><p>You do not have permission to view this chat.</p>';
            exit;
        }

        $session  = $this->chatModel->getSessionById($sessionId);
        $messages = $this->chatModel->getMessages($sessionId, $userId);

        // Determine the other participant's name for the header
        $otherUserId = ($session['counselor_user_id'] == $userId)
            ? $session['undergrad_user_id']
            : $session['counselor_user_id'];

        $pdo  = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT COALESCE(us.full_name, c.full_name, u.username) AS display_name, u.role
              FROM users u
              LEFT JOIN undergraduate_students us ON us.user_id = u.id
              LEFT JOIN counselors c ON c.user_id = u.id
             WHERE u.id = ?
        ");
        $stmt->execute([$otherUserId]);
        $other = $stmt->fetch(PDO::FETCH_ASSOC);
        $otherName = $other ? htmlspecialchars($other['display_name']) : 'Unknown';

        view('/chat/room', [
            'session'   => $session,
            'messages'  => $messages,
            'otherName' => $otherName,
            'userId'    => $userId,
            'sessionId' => $sessionId,
        ]);
    }

    // =========================================================================
    // AJAX ENDPOINTS  (JSON)
    // =========================================================================

    /**
     * POST /api/chat/start
     * Counselor starts (or resumes) a chat with an undergrad.
     * Body: { undergrad_user_id: int }
     */
    public function startSession(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        if ($this->userRole() !== 'counselor') {
            $this->json(['success' => false, 'message' => 'Only counselors can start sessions'], 403);
        }

        $body           = $this->jsonBody();
        $undergradUserId = isset($body['undergrad_user_id']) ? (int)$body['undergrad_user_id'] : 0;

        if (!$undergradUserId) {
            $this->json(['success' => false, 'message' => 'undergrad_user_id is required']);
        }

        $sessionId = $this->chatModel->findOrCreateSession($this->userId(), $undergradUserId);
        $this->json(['success' => true, 'session_id' => $sessionId]);
    }

    /**
     * GET /api/chat/messages?session_id=X
     * READ — Return all visible messages for a session.
     */
    public function getMessages(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        $sessionId = isset($_GET['session_id']) ? (int)$_GET['session_id'] : 0;
        $userId    = $this->userId();

        if (!$sessionId) {
            $this->json(['success' => false, 'message' => 'session_id is required']);
        }

        if (!$this->chatModel->userBelongsToSession($sessionId, $userId)) {
            $this->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $messages = $this->chatModel->getMessages($sessionId, $userId);
        $this->json(['success' => true, 'messages' => $messages]);
    }

    /**
     * POST /api/chat/send
     * CREATE — Send a new message.
     * Body: { session_id: int, message: string }
     */
    public function sendMessage(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        $body      = $this->jsonBody();
        $sessionId = isset($body['session_id']) ? (int)$body['session_id'] : 0;
        $message   = isset($body['message']) ? trim($body['message']) : '';
        $userId    = $this->userId();

        if (!$sessionId || $message === '') {
            $this->json(['success' => false, 'message' => 'session_id and message are required']);
        }

        if (!$this->chatModel->userBelongsToSession($sessionId, $userId)) {
            $this->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $msgId = $this->chatModel->sendMessage($sessionId, $userId, $message);
        $this->json(['success' => true, 'message_id' => $msgId]);
    }

    /**
     * POST /api/chat/edit
     * UPDATE — Edit an existing message.
     * Body: { message_id: int, message: string }
     */
    public function editMessage(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        $body      = $this->jsonBody();
        $messageId = isset($body['message_id']) ? (int)$body['message_id'] : 0;
        $newText   = isset($body['message']) ? trim($body['message']) : '';
        $userId    = $this->userId();

        if (!$messageId || $newText === '') {
            $this->json(['success' => false, 'message' => 'message_id and message are required']);
        }

        $result = $this->chatModel->editMessage($messageId, $userId, $newText);

        if ($result === true) {
            $this->json(['success' => true, 'message' => 'Message updated']);
        } else {
            $this->json(['success' => false, 'message' => $result]);
        }
    }

    /**
     * POST /api/chat/delete
     * DELETE (soft) — Remove a message from the conversation.
     * Body: { message_id: int }
     */
    public function deleteMessage(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Method not allowed'], 405);
        }

        $body      = $this->jsonBody();
        $messageId = isset($body['message_id']) ? (int)$body['message_id'] : 0;
        $userId    = $this->userId();

        if (!$messageId) {
            $this->json(['success' => false, 'message' => 'message_id is required']);
        }

        $result = $this->chatModel->deleteMessage($messageId, $userId);

        if ($result === true) {
            $this->json(['success' => true, 'message' => 'Message deleted']);
        } else {
            $this->json(['success' => false, 'message' => $result]);
        }
    }
}
