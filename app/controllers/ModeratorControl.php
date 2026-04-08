<?php

require_once BASE_PATH . '/app/models/ResourceHub.php';

class ModeratorControl
{
    public function edit()
    {
        try {
            $resourceHub = new ResourceHub();
            $resources = $resourceHub->getAll();
            view('Moderator/editPosts', ['resources' => $resources]);
        } catch (Exception $e) {
            view('Moderator/editPosts', ['resources' => [], 'error' => 'Failed to load resources: ' . $e->getMessage()]);
        }
    }

    public function flagged()
    {
        view('Moderator/FlaggedUsers');
    }

    public function ModeratorDashboard()
    {
        view('Moderator/ModeratorDashboard');
    }

    public function resourceHub()
    {
        try {
            $resourceHub = new ResourceHub();
            $allResources = $resourceHub->getAll('published');
            $resourcesByCategory = [];
            foreach ($allResources as $resource) {
                $cat = $resource['category'];
                if (!isset($resourcesByCategory[$cat])) {
                    $resourcesByCategory[$cat] = [];
                }
                $resourcesByCategory[$cat][] = $resource;
            }
            $stats = $resourceHub->getStats();
            view('undergrad/resources', [
                'resources'           => $allResources,
                'resourcesByCategory' => $resourcesByCategory,
                'stats'               => $stats,
                'lastUpdated'         => date('Y-m-d H:i:s'),
                'categoryBaseUrl'     => BASE_URL . '/Moderator/category-resources'
            ]);
        } catch (Exception $e) {
            view('undergrad/resources', [
                'resources'           => [],
                'resourcesByCategory' => [],
                'stats'               => ['total_resources' => 0, 'published' => 0],
                'error'               => 'Unable to load resources.',
                'lastUpdated'         => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function categoryResources()
    {
        try {
            $category = $_GET['category'] ?? '';
            if (empty($category)) {
                header('Location: ' . BASE_URL . '/Moderator/resource-hub');
                exit;
            }
            $resourceHub = new ResourceHub();
            $categoryResources = $resourceHub->getByCategory($category, 'published');
            $allResources = $resourceHub->getAll('published');
            $allCategories = [];
            foreach ($allResources as $resource) {
                $cat = $resource['category'];
                if (!isset($allCategories[$cat])) {
                    $allCategories[$cat] = count(array_filter($allResources, function ($r) use ($cat) {
                        return $r['category'] === $cat;
                    }));
                }
            }
            $categoryInfo = [
                'Mental Health Basics'     => ['icon' => '🧠', 'description' => 'Understanding mental health, common conditions, and when to seek help'],
                'Anxiety & Stress'         => ['icon' => '😰', 'description' => 'Coping strategies and techniques for managing anxiety and stress'],
                'Depression Support'       => ['icon' => '😢', 'description' => 'Resources and support for dealing with depression'],
                'Mindfulness & Meditation' => ['icon' => '🧘‍♀️', 'description' => 'Guided practices for mindfulness and meditation'],
                'Sleep & Wellness'         => ['icon' => '💤', 'description' => 'Tips for better sleep and overall wellness'],
                'Relationships & Social'   => ['icon' => '👥', 'description' => 'Building healthy relationships and social connections'],
                'Crisis Support'           => ['icon' => '🆘', 'description' => 'Emergency resources and crisis intervention'],
                'Self-Help Tools'          => ['icon' => '🛠️', 'description' => 'Interactive tools and exercises for mental wellness'],
                'Professional Development' => ['icon' => '🎓', 'description' => 'Resources for academic and career success']
            ];
            $currentCategoryInfo = $categoryInfo[$category] ?? ['icon' => '📚', 'description' => 'Resources for ' . $category];
            $resourcesByType = ['article' => [], 'video' => [], 'audio' => []];
            foreach ($categoryResources as $resource) {
                $ct = $resource['content_type'];
                if (isset($resourcesByType[$ct])) {
                    $resourcesByType[$ct][] = $resource;
                }
            }
            view('undergrad/category-resources', [
                'category'         => $category,
                'categoryInfo'     => $currentCategoryInfo,
                'resources'        => $categoryResources,
                'resourcesByType'  => $resourcesByType,
                'allCategories'    => $allCategories,
                'totalResources'   => count($categoryResources),
                'categoryBaseUrl'  => BASE_URL . '/Moderator/category-resources',
                'backUrl'          => BASE_URL . '/Moderator/resource-hub'
            ]);
        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/Moderator/resource-hub?error=category_not_found');
            exit;
        }
    }

    public function warn()
    {
        // Get user data from URL parameters
        $data = [
            'userId' => $_GET['userId'] ?? null,
            'username' => $_GET['username'] ?? null,
            'email' => $_GET['email'] ?? null,
            'strikes' => $_GET['strikes'] ?? 0,
            'joinDate' => $_GET['joinDate'] ?? null,
            'lastActivity' => $_GET['lastActivity'] ?? null
        ];

        view('Moderator/WarnForm', $data);
    }

    public function editReportedContent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/ModeratorDashboard');
            exit;
        }

        $reportId = $_POST['report_id'] ?? null;
        $content = $_POST['content'] ?? '';
        $postId = $_POST['post_id'] ?? null;

        if ($postId && $content) {
            require_once BASE_PATH . '/app/models/Thread.php';
            $threadModel = new Thread();

            // Update the post content marked as edited by Moderator
            if ($threadModel->updatePost($postId, $content, 'Moderator')) {
                // Update report status if needed
                if ($reportId) {
                    require_once BASE_PATH . '/app/models/Report.php';
                    $reportModel = new Report();
                    $reportModel->updateStatus($reportId, 'reviewed');
                }
            }
        }

        header('Location: ' . BASE_URL . '/ModeratorDashboard');
        exit;
    }

    public function createResource()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/EditPosts');
            exit;
        }

        try {
            $resourceHub = new ResourceHub();

            // Get current user ID
            $userId = $_SESSION['user_id'] ?? 1;

            // Validate required fields
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');

            if (empty($title) || empty($category) || empty($contentType)) {
                header('Location: ' . BASE_URL . '/EditPosts?error=missing_fields');
                exit;
            }

            $data = [
                'title' => $title,
                'category' => $category,
                'content_type' => $contentType,
                'summary' => $summary,
                'tags' => trim($_POST['tags'] ?? ''),
                'status' => $_POST['status'] ?? 'draft',
                'created_by' => $userId,
                'content' => trim($_POST['content'] ?? ''),
                'youtube_url' => trim($_POST['youtube_url'] ?? '') ?: null,
            ];

            // Handle file upload based on content type
            if ($contentType === 'article') {
                if (isset($_FILES['article_image']) && $_FILES['article_image']['error'] === 0) {
                    $uploadResult = $this->handleFileUpload($_FILES['article_image'], 'images');
                    if ($uploadResult['success']) {
                        $data['file_path'] = $uploadResult['path'];
                        $data['file_name'] = $uploadResult['name'];
                        $data['file_size'] = $uploadResult['size'];
                        $data['file_type'] = $uploadResult['type'];
                    }
                }
            } else {
                $fileField = $contentType === 'video' ? 'video_file' : 'audio_file';
                $uploadDir = $contentType === 'video' ? 'videos' : 'audio';

                if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === 0) {
                    $uploadResult = $this->handleFileUpload($_FILES[$fileField], $uploadDir);
                    if ($uploadResult['success']) {
                        $data['file_path'] = $uploadResult['path'];
                        $data['file_name'] = $uploadResult['name'];
                        $data['file_size'] = $uploadResult['size'];
                        $data['file_type'] = $uploadResult['type'];
                    }
                }
            }

            $resourceHub->create($data);
            header('Location: ' . BASE_URL . '/EditPosts?created=1');
            exit;

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/EditPosts?error=creation_failed');
            exit;
        }
    }

    public function deleteResource()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/EditPosts');
            exit;
        }

        try {
            $resourceId = (int) ($_POST['id'] ?? 0);
            if ($resourceId <= 0) {
                header('Location: ' . BASE_URL . '/EditPosts?error=invalid_id');
                exit;
            }

            $resourceHub = new ResourceHub();
            $resourceHub->delete($resourceId);
            header('Location: ' . BASE_URL . '/EditPosts?deleted=1');
            exit;

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/EditPosts?error=deletion_failed');
            exit;
        }
    }

    public function editResource()
    {
        $resourceId = (int) ($_GET['id'] ?? 0);
        if ($resourceId <= 0) {
            header('Location: ' . BASE_URL . '/EditPosts?error=invalid_id');
            exit;
        }

        try {
            $resourceHub = new ResourceHub();
            $resource = $resourceHub->getById($resourceId);

            if (!$resource) {
                header('Location: ' . BASE_URL . '/EditPosts?error=resource_not_found');
                exit;
            }

            view('Moderator/editResource', ['resource' => $resource]);

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/EditPosts?error=load_failed');
            exit;
        }
    }

    public function updateResource()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/EditPosts');
            exit;
        }

        try {
            $resourceId = (int) ($_POST['id'] ?? 0);
            if ($resourceId <= 0) {
                header('Location: ' . BASE_URL . '/EditPosts?error=invalid_id');
                exit;
            }

            $resourceHub = new ResourceHub();

            // Load existing record so we can preserve file info if no new file is uploaded
            $existing = $resourceHub->getById($resourceId);
            if (!$existing) {
                header('Location: ' . BASE_URL . '/EditPosts?error=resource_not_found');
                exit;
            }

            // Validate required fields
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');

            if (empty($title) || empty($category) || empty($contentType)) {
                header('Location: ' . BASE_URL . '/EditPosts?error=missing_fields');
                exit;
            }

            $data = [
                'title'        => $title,
                'category'     => $category,
                'content_type' => $contentType,
                'summary'      => $summary,
                'tags'         => trim($_POST['tags'] ?? ''),
                'status'       => $_POST['status'] ?? 'draft',
                'content'      => trim($_POST['content'] ?? ''),
                'youtube_url'  => trim($_POST['youtube_url'] ?? '') ?: null,
                // Preserve existing file info by default
                'file_path'    => $existing['file_path'],
                'file_name'    => $existing['file_name'],
                'file_size'    => $existing['file_size'],
                'file_type'    => $existing['file_type'],
            ];

            // Handle file upload based on content type
            if ($contentType === 'article') {
                if (isset($_FILES['article_image']) && $_FILES['article_image']['error'] === 0) {
                    $uploadResult = $this->handleFileUpload($_FILES['article_image'], 'images');
                    if ($uploadResult['success']) {
                        $data['file_path'] = $uploadResult['path'];
                        $data['file_name'] = $uploadResult['name'];
                        $data['file_size'] = $uploadResult['size'];
                        $data['file_type'] = $uploadResult['type'];
                    }
                }
            } else {
                $fileField = $contentType === 'video' ? 'video_file' : 'audio_file';
                $uploadDir = $contentType === 'video' ? 'videos' : 'audio';

                if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === 0) {
                    $uploadResult = $this->handleFileUpload($_FILES[$fileField], $uploadDir);
                    if ($uploadResult['success']) {
                        $data['file_path'] = $uploadResult['path'];
                        $data['file_name'] = $uploadResult['name'];
                        $data['file_size'] = $uploadResult['size'];
                        $data['file_type'] = $uploadResult['type'];
                    }
                }
            }

            $resourceHub->update($resourceId, $data);
            header('Location: ' . BASE_URL . '/EditPosts?updated=1');
            exit;

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/EditPosts?error=update_failed');
            exit;
        }
    }

    private function handleFileUpload($file, $uploadDir)
    {
        // Allowed types per category
        $allowedTypes = [
            'images'    => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            'videos'    => ['video/mp4', 'video/avi', 'video/quicktime', 'video/x-msvideo'],
            'audio'     => ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav', 'audio/mp4', 'audio/m4a', 'audio/x-m4a'],
            'resources' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp',
                            'video/mp4', 'video/avi', 'video/quicktime',
                            'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/mp4'],
        ];

        $mimeType = mime_content_type($file['tmp_name']);
        $allowed  = $allowedTypes[$uploadDir] ?? [];

        if (!empty($allowed) && !in_array($mimeType, $allowed)) {
            error_log("File upload rejected — mime type '{$mimeType}' not allowed in '{$uploadDir}'.");
            return ['success' => false, 'error' => 'File type not allowed.'];
        }

        // Always store under public/uploads/resources/ for simplicity
        $storeDir  = 'resources';
        $uploadPath = BASE_PATH . '/public/uploads/' . $storeDir . '/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $safeBase   = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file['name']));
        $fileName   = time() . '_' . $safeBase;
        $targetPath = $uploadPath . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => true,
                'path'    => 'uploads/resources/' . $fileName,
                'name'    => $file['name'],
                'size'    => $file['size'],
                'type'    => $mimeType,
            ];
        }

        error_log("move_uploaded_file failed: tmp={$file['tmp_name']} target={$targetPath}");
        return ['success' => false, 'error' => 'Could not move uploaded file.'];
    }

    public function reportedResources()
    {
        try {
            $resourceHub = new ResourceHub();
            $reports = $resourceHub->getPendingReports();
            view('Moderator/reportedResources', ['reports' => $reports]);
        } catch (Exception $e) {
            echo "Failed to load reports: " . $e->getMessage();
        }
    }

    public function resolveReport()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/Moderator/reported-resources');
            exit;
        }

        $reportId = (int)($_POST['report_id'] ?? 0);
        $action = $_POST['action'] ?? '';
        
        if ($reportId > 0 && in_array($action, ['removed', 'warning issued', 'ignored'])) {
            $resourceHub = new ResourceHub();
            
            // Default to 'reviewed'. Except maybe 'ignored' would still be reviewed?
            $status = 'reviewed';
            
            // Get original report to know which resource to update if "removed"
            $stmt = Database::getConnection()->prepare("SELECT resource_id FROM resource_reports WHERE id = ?");
            $stmt->execute([$reportId]);
            $res = $stmt->fetch();

            if ($action === 'removed' && $res) {
                // If the moderator decides to remove the content, set resource status to 'archived' or 'flagged' permanently
                $upd = Database::getConnection()->prepare("UPDATE resource_hub SET status = 'archived' WHERE id = ?");
                $upd->execute([$res['resource_id']]);
            }

            $resourceHub->reviewReport($reportId, $_SESSION['user_id'] ?? null, $action, $status);
        }

        header('Location: ' . BASE_URL . '/Moderator/reported-resources?resolved=1');
        exit;
    }
}
