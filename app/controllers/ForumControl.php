<?php

class ForumControl
{

    public function __construct()
    {
        // Constructor no longer forces authentication on all routes to allow guests to view the forum
    }

    private function requireAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index()
    {
        require_once BASE_PATH . '/app/models/Thread.php';
        $threadModel = new Thread();

        $threads    = $threadModel->getAll(20);
        $categories = $threadModel->getCategories();
        $userRole   = $_SESSION['role'] ?? 'guest';

        $this->view('forum/index', [
            'threads'    => $threads,
            'categories' => $categories,
            'userRole'   => $userRole,
            'PAGE_CSS'   => [BASE_URL . '/css/forum.css']
        ]);
    }

    public function create()
    {
        $this->requireAuth();

        $userRole = $_SESSION['role'] ?? '';
        if ($userRole === 'university_representative') {
            $_SESSION['error'] = "You do not have permission to create threads.";
            header('Location: ' . BASE_URL . '/forum');
            exit;
        }

        require_once BASE_PATH . '/app/models/Thread.php';
        $threadModel = new Thread();
        $categories  = $threadModel->getCategories();

        $this->view('forum/create', ['categories' => $categories]);
    }

    public function store()
    {
        $this->requireAuth();

        // DEBUG: Temporary check to see if we reach here
        // DEBUG: Temporary check to see if we reach here
        // die("DEBUG: Reached ForumControl::store. Request Method: " . $_SERVER['REQUEST_METHOD'] . " POST: " . print_r($_POST, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/forum');
            exit;
        }

        // Access Control
        $userRole = $_SESSION['role'] ?? '';
        if ($userRole === 'university_representative') {
            $_SESSION['error'] = "You do not have permission to create threads.";
            header('Location: ' . BASE_URL . '/forum');
            exit;
        }

        // Input Validation
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['content'] ?? ''); // View uses 'content' name
        $category = $_POST['category'] ?? '';
        $isAnonymous = isset($_POST['anonymous']) ? 1 : 0;
        $allowTransparency = isset($_POST['transparency']) ? 1 : 0;

        // Student-only fields logic enforcement
        if ($userRole !== 'undergraduate') {
            $isAnonymous = 0; // Only students can be anonymous
            $allowTransparency = 0;
        }

        if (empty($title) || empty($description) || empty($category)) {
            $_SESSION['error'] = "All fields are required.";
            $this->view('forum/create', ['error' => 'All fields are required.', 'old' => $_POST]);
            return;
        }

        try {
            require_once BASE_PATH . '/app/models/Thread.php';
            $threadModel = new Thread();

            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => $title,
                'description' => $description,
                'category' => $category, // Warning: This assumes category is a string column. If using category_id, this will fail.
                'is_anonymous' => $isAnonymous,
                'allow_transparency' => $allowTransparency
            ];

            $threadId = $threadModel->create($data);

            // Check for flags
            $this->checkKeywords($title . ' ' . $description, $threadId, 'thread');

            $_SESSION['success'] = "Thread created successfully! (ID: " . $threadId . ")";
            header('Location: ' . BASE_URL . '/forum'); // Redirect to list or specific thread
            exit;

        } catch (Exception $e) {
            error_log("Thread Create Error: " . $e->getMessage());
            $_SESSION['error'] = "Failed to create thread. Error: " . $e->getMessage();
            $this->view('forum/create', ['error' => 'Failed to create thread. ' . $e->getMessage(), 'old' => $_POST]);
        }
    }

    public function show($id)
    {
        require_once BASE_PATH . '/app/models/Thread.php';
        $threadModel = new Thread();

        $thread = $threadModel->getById($id);

        if (!$thread) {
            $_SESSION['error'] = "Thread not found.";
            header('Location: ' . BASE_URL . '/forum');
            exit;
        }

        // Increment view count
        $threadModel->incrementViews($id);

        // Get posts (replies) with like status for current user
        $currentUserId = $_SESSION['user_id'] ?? null;
        $posts = $threadModel->getPosts($id, $currentUserId);

        $this->view('forum/show', [
            'thread_data' => $thread,
            'posts' => $posts,
            'PAGE_CSS' => [BASE_URL . '/css/forum.css']
        ]);
    }

    public function reply()
    {
        $this->requireAuth();
        $this->checkSuspension();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/forum');
            exit;
        }

        require_once BASE_PATH . '/app/models/Thread.php';
        $threadModel = new Thread();

        $threadId = $_POST['thread_id'] ?? 0;
        $content = trim($_POST['content'] ?? '');
        $parentReplyId = !empty($_POST['parent_reply_id']) ? (int) $_POST['parent_reply_id'] : null;

        if (!$threadId || empty($content)) {
            $_SESSION['error'] = "Reply cannot be empty.";
            header('Location: ' . BASE_URL . '/forum/thread/' . $threadId);
            exit;
        }

        // Validate Nesting Depth (Strict 1-level)
        if ($parentReplyId) {
            $parentPost = $threadModel->getPostById($parentReplyId);

            if (!$parentPost) {
                $_SESSION['error'] = "Parent reply not found.";
                header('Location: ' . BASE_URL . '/forum/thread/' . $threadId);
                exit;
            }

            // If parent already has a parent, BLOCK it (Strict 1-level)
            if (!empty($parentPost['parent_reply_id'])) {
                $_SESSION['error'] = "You cannot reply to a nested reply.";
                header('Location: ' . BASE_URL . '/forum/thread/' . $threadId);
                exit;
            }
        }

        $isAnonymous = isset($_POST['anonymous']) ? 1 : 0;

        // Student-only fields logic enforcement
        $userRole = $_SESSION['role'] ?? '';
        if ($userRole !== 'undergraduate') {
            $isAnonymous = 0; // Only students can be anonymous
        }

        $data = [
            'thread_id' => $threadId,
            'user_id' => $_SESSION['user_id'],
            'content' => $content,
            'parent_reply_id' => $parentReplyId,
            'is_anonymous' => $isAnonymous
        ];

        if ($postId = $threadModel->createPost($data)) {
            // Check for flags
            $type = $parentReplyId ? 'reply_reply' : 'reply';
            $this->checkKeywords($content, $postId, $type);

            $_SESSION['success'] = "Reply posted successfully!";
        } else {
            $_SESSION['error'] = "Failed to post reply.";
        }

        header('Location: ' . BASE_URL . '/forum/thread/' . $threadId);
        exit;
    }

    public function toggleLike()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            exit;
        }

        require_once BASE_PATH . '/app/models/Thread.php';
        $threadModel = new Thread();

        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        $postId = $input['post_id'] ?? null;

        if (!$postId) {
            echo json_encode(['success' => false, 'message' => 'Post ID required']);
            exit;
        }

        $result = $threadModel->toggleLike($postId, $_SESSION['user_id']);
        echo json_encode($result);
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/forum');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "You must be logged in to delete content.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require_once BASE_PATH . '/app/models/Thread.php';
        $threadModel = new Thread();

        $type = $_POST['type'] ?? ''; // 'thread' or 'post'
        $id = (int) ($_POST['id'] ?? 0);

        if (!$id || !in_array($type, ['thread', 'post'])) {
            $_SESSION['error'] = "Invalid request.";
            header('Location: ' . BASE_URL . '/forum');
            exit;
        }

        $currentUserId = $_SESSION['user_id'];
        $userRole = $_SESSION['role'] ?? '';

        if ($type === 'thread') {
            $thread = $threadModel->getById($id);
            if (!$thread) {
                $_SESSION['error'] = "Thread not found.";
                header('Location: ' . BASE_URL . '/forum');
                exit;
            }

            // Check ownership or admin/moderator privilege
            if ($thread['user_id'] != $currentUserId && $userRole !== 'admin' && $userRole !== 'moderator') {
                $_SESSION['error'] = "You do not have permission to delete this thread.";
                header('Location: ' . BASE_URL . '/forum/thread/' . $id);
                exit;
            }

            if ($threadModel->delete($id)) {
                $_SESSION['success'] = "Thread deleted successfully.";
                header('Location: ' . BASE_URL . '/forum');
            } else {
                $_SESSION['error'] = "Failed to delete thread.";
                header('Location: ' . BASE_URL . '/forum/thread/' . $id);
            }

        } elseif ($type === 'post') {
            $post = $threadModel->getPostById($id);
            if (!$post) {
                $_SESSION['error'] = "Post not found.";
                header('Location: ' . BASE_URL . '/forum');
                exit;
            }

            // Check ownership or admin/moderator privilege
            if ($post['user_id'] != $currentUserId && $userRole !== 'admin' && $userRole !== 'moderator') {
                $_SESSION['error'] = "You do not have permission to delete this post.";
                header('Location: ' . BASE_URL . '/forum/thread/' . $post['thread_id']);
                exit;
            }

            if ($threadModel->deletePost($id)) {
                $_SESSION['success'] = "Reply deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete reply.";
            }
            header('Location: ' . BASE_URL . '/forum/thread/' . $post['thread_id']);
        }
        exit;
    }

    private function checkKeywords($text, $contentId, $contentType)
    {
        require_once BASE_PATH . '/app/models/Keyword.php';
        require_once BASE_PATH . '/app/models/SystemFlag.php';

        $keywordModel = new Keyword();
        $systemFlagModel = new SystemFlag();

        $keywords = $keywordModel->getAll();
        $userId = $_SESSION['user_id'] ?? null;

        foreach ($keywords as $kw) {
            if (stripos($text, (string) $kw['keyword']) !== false) {
                $systemFlagModel->create([
                    'content_id' => $contentId,
                    'content_type' => $contentType,
                    'user_id' => $userId,
                    'matched_keyword' => $kw['keyword']
                ]);
            }
        }
    }

    private function checkSuspension()
    {
        if (isset($_SESSION['user_id'])) {
            require_once BASE_PATH . '/app/models/User.php';
            $userModel = new User();
            if ($userModel->isSuspended($_SESSION['user_id'])) {
                $_SESSION['error'] = "Your account is suspended. You cannot perform this action.";
                header('Location: ' . BASE_URL . '/forum');
                exit;
            }
        }
    }

    // Helper to load views
    private function view($view, $data = [])
    {
        extract($data);
        $viewFile = BASE_PATH . '/app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file not found: " . $viewFile);
        }
    }
}
