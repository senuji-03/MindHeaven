<?php

class ReportControl
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
    }

    public function submit()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        // Validation
        if (empty($input['content_type']) || empty($input['content_id']) || empty($input['category_id'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        require_once BASE_PATH . '/app/models/Report.php';
        $reportModel = new Report();

        // Check for duplicates
        if ($reportModel->hasUserReported($_SESSION['user_id'], $input['content_type'], $input['content_id'])) {
            echo json_encode(['success' => false, 'message' => 'You have already reported this content']);
            exit;
        }

        // Get content owner ID (This usually requires querying the specific content table: threads or posts)
        // For now, we'll assume the frontend passes the content_owner_id or we fetch it here.
        // Fetching here is safer.
        $ownerId = $this->getContentOwner($input['content_type'], $input['content_id']);

        if (!$ownerId) {
            echo json_encode(['success' => false, 'message' => 'Content not found']);
            exit;
        }

        $data = [
            'reporter_id' => $_SESSION['user_id'],
            'content_owner_id' => $ownerId,
            'content_type' => $input['content_type'],
            'content_id' => $input['content_id'],
            'category_id' => $input['category_id'],
            'explanation' => trim($input['explanation'] ?? '')
        ];

        if ($reportModel->create($data)) {
            echo json_encode(['success' => true, 'message' => 'Report submitted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit report']);
        }
        exit;
    }

    public function getCategories()
    {
        header('Content-Type: application/json');
        require_once BASE_PATH . '/app/models/Report.php';
        $reportModel = new Report();
        $categories = $reportModel->getCategories();
        echo json_encode(['success' => true, 'categories' => $categories]);
        exit;
    }

    private function getContentOwner($type, $id)
    {
        $pdo = Database::getConnection();

        if ($type === 'thread') {
            $stmt = $pdo->prepare("SELECT user_id FROM forum_threads WHERE id = ?");
        } elseif ($type === 'post' || $type === 'reply') {
            $stmt = $pdo->prepare("SELECT user_id FROM forum_posts WHERE id = ?");
        } else {
            return null;
        }

        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
}
