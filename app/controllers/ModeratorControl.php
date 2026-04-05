<?php

require_once BASE_PATH . '/app/models/ResourceHub.php';

class ModeratorControl
{
    public function edit()
    {
        try {
            $resourceHub = new ResourceHub();
            $resources = $resourceHub->getAll();
            view('Moderator/editPosts', array('resources' => $resources));
        }
        catch (Exception $e) {
            view('Moderator/editPosts', array('resources' => array(), 'error' => 'Failed to load resources: ' . $e->getMessage()));
        }
    }

    public function flagged()
    {
        view('Moderator/FlaggedUsers');
    }

    public function ModeratorDashboard()
    {
<<<<<<< HEAD
        require_once BASE_PATH . '/app/models/Report.php';
        require_once BASE_PATH . '/app/models/Thread.php';

        $reportModel = new Report();
        $threadModel = new Thread();

        // Fetch pending reports
        // Note: Admin uses getAll('pending'). We can assume Moderators see the same.
        $reports = $reportModel->getAll('pending');

        $flaggedPosts = [];

        foreach ($reports as $report) {
            // We only care about threads/posts/replies for the dashboard "Flagged Posts" section
            if (in_array($report['content_type'], ['thread', 'post', 'reply'])) {
                $content = null;
                if ($report['content_type'] === 'thread') {
                    $content = $threadModel->getById($report['content_id']);
                    $report['content'] = $content['description'] ?? '';
                    $report['title'] = $content['title'] ?? 'Thread';
                } else {
                    $content = $threadModel->getPostById($report['content_id']);
                    $report['content'] = $content['content'] ?? '';
                    $report['title'] = 'Post';
                }

                if ($content) {
                    $report['full_content'] = $report['content'];
                    $flaggedPosts[] = $report;
                }
            }
        }

        // Pass data to view
        $data = [
            'flaggedPosts' => $flaggedPosts,
            'pendingPosts' => [], // Placeholder
            'flaggedUsers' => [] // Placeholder
        ];

        view('Moderator/ModeratorDashboard', ['data' => $data]);
    }
<<<<<<< HEAD
    
    public function warn() {
=======
        view('Moderator/ModeratorDashboard');
    }
    public function resourceHub() {
        try {
            $resourceHub = new ResourceHub();
            $allResources = $resourceHub->getAll('published');
            $resourcesByCategory = [];
            foreach ($allResources as $resource) {
                $cat = $resource['category'];
                if (!isset($resourcesByCategory[$cat])) $resourcesByCategory[$cat] = [];
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
                    $allCategories[$cat] = count(array_filter($allResources, function($r) use ($cat) {
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
                if (isset($resourcesByType[$ct])) $resourcesByType[$ct][] = $resource;
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
>>>>>>> origin/moderator_branch
        // Get user data from URL parameters
        $data = array(
            'userId' => isset($_GET['userId']) ? $_GET['userId'] : null,
            'username' => isset($_GET['username']) ? $_GET['username'] : null,
            'email' => isset($_GET['email']) ? $_GET['email'] : null,
            'strikes' => isset($_GET['strikes']) ? $_GET['strikes'] : 0,
            'joinDate' => isset($_GET['joinDate']) ? $_GET['joinDate'] : null,
            'lastActivity' => isset($_GET['lastActivity']) ? $_GET['lastActivity'] : null
        );

        view('Moderator/WarnForm', $data);
=======

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
                // Update report status if needed, similar to Admin
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

<<<<<<< HEAD
    public function warn()
    {
        view('Moderator/warnForm');
>>>>>>> origin/uni-representative
    }

=======
>>>>>>> origin/moderator_branch

    public function createResource()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/EditPosts');
            exit;
        }

        try {
            $resourceHub = new ResourceHub();

            // Get current user ID (assuming session is set)
<<<<<<< HEAD
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Fallback to 1 for testing

            // Validate required fields
            $title = trim(isset($_POST['title']) ? $_POST['title'] : '');
            $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
            $contentType = trim(isset($_POST['content_type']) ? $_POST['content_type'] : '');
            $summary = trim(isset($_POST['summary']) ? $_POST['summary'] : '');
<<<<<<< HEAD
            
=======
            $userId = $_SESSION['user_id'] ?? 1; // Fallback to 1 for testing

            // Validate required fields
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');

>>>>>>> origin/uni-representative
=======

>>>>>>> origin/moderator_branch
            if (empty($title) || empty($category) || empty($contentType) || empty($summary)) {
                header('Location: ' . BASE_URL . '/EditPosts?error=missing_fields');
                exit;
            }
<<<<<<< HEAD
<<<<<<< HEAD
            
=======

>>>>>>> origin/moderator_branch
            $data = array(
=======

            $data = [
>>>>>>> origin/uni-representative
                'title' => $title,
                'category' => $category,
                'content_type' => $contentType,
                'summary' => $summary,
                'tags' => trim(isset($_POST['tags']) ? $_POST['tags'] : ''),
                'status' => isset($_POST['status']) ? $_POST['status'] : 'draft',
                'created_by' => $userId
<<<<<<< HEAD
            );

            // Handle content based on type
            if ($contentType === 'article') {
                $data['content'] = trim(isset($_POST['content']) ? $_POST['content'] : '');
<<<<<<< HEAD
                
=======
            ];

            // Handle content based on type
            if ($contentType === 'article') {
                $data['content'] = trim($_POST['content'] ?? '');

>>>>>>> origin/uni-representative
=======

>>>>>>> origin/moderator_branch
                // Handle article image upload
                if (isset($_FILES['article_image']) && $_FILES['article_image']['error'] === 0) {
                    $uploadResult = $this->handleFileUpload($_FILES['article_image'], 'images');
                    if ($uploadResult['success']) {
                        $data['file_path'] = $uploadResult['path'];
                        $data['file_name'] = $uploadResult['name'];
                        $data['file_size'] = $uploadResult['size'];
                        $data['file_type'] = $uploadResult['type'];
                    }
                }
<<<<<<< HEAD
            } else {
<<<<<<< HEAD
                $data['content'] = trim(isset($_POST['content']) ? $_POST['content'] : '');
                
=======
                $data['content'] = trim($_POST['content'] ?? '');

>>>>>>> origin/uni-representative
=======
            }
            else {
                $data['content'] = trim(isset($_POST['content']) ? $_POST['content'] : '');

>>>>>>> origin/moderator_branch
                // Handle file upload for video/audio
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

<<<<<<< HEAD
        } catch (Exception $e) {
=======
        }
        catch (Exception $e) {
>>>>>>> origin/moderator_branch
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
<<<<<<< HEAD
            $resourceId = (int)(isset($_POST['id']) ? $_POST['id'] : 0);
=======
            $resourceId = (int) ($_POST['id'] ?? 0);
>>>>>>> origin/uni-representative
            if ($resourceId <= 0) {
                header('Location: ' . BASE_URL . '/EditPosts?error=invalid_id');
                exit;
            }

            $resourceHub = new ResourceHub();
            $resourceHub->delete($resourceId);
            header('Location: ' . BASE_URL . '/EditPosts?deleted=1');
            exit;

<<<<<<< HEAD
        } catch (Exception $e) {
=======
        }
        catch (Exception $e) {
>>>>>>> origin/moderator_branch
            header('Location: ' . BASE_URL . '/EditPosts?error=deletion_failed');
            exit;
        }
    }
<<<<<<< HEAD
<<<<<<< HEAD
    
    public function editResource() {
=======

    public function editResource()
    {
>>>>>>> origin/moderator_branch
        $resourceId = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
=======

    public function editResource()
    {
        $resourceId = (int) ($_GET['id'] ?? 0);
>>>>>>> origin/uni-representative
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
<<<<<<< HEAD
<<<<<<< HEAD
            
            view('Moderator/editResource', array('resource' => $resource));
            
=======

            view('Moderator/editResource', ['resource' => $resource]);

>>>>>>> origin/uni-representative
        } catch (Exception $e) {
=======

            view('Moderator/editResource', array('resource' => $resource));

        }
        catch (Exception $e) {
>>>>>>> origin/moderator_branch
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
<<<<<<< HEAD
            $resourceId = (int)(isset($_POST['id']) ? $_POST['id'] : 0);
=======
            $resourceId = (int) ($_POST['id'] ?? 0);
>>>>>>> origin/uni-representative
            if ($resourceId <= 0) {
                header('Location: ' . BASE_URL . '/EditPosts?error=invalid_id');
                exit;
            }

            $resourceHub = new ResourceHub();

<<<<<<< HEAD
=======
            // Load existing record so we can preserve file info if no new file is uploaded
            $existing = $resourceHub->getById($resourceId);
            if (!$existing) {
                header('Location: ' . BASE_URL . '/EditPosts?error=resource_not_found');
                exit;
            }

>>>>>>> origin/moderator_branch
            // Validate required fields
<<<<<<< HEAD
            $title = trim(isset($_POST['title']) ? $_POST['title'] : '');
            $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
            $contentType = trim(isset($_POST['content_type']) ? $_POST['content_type'] : '');
            $summary = trim(isset($_POST['summary']) ? $_POST['summary'] : '');
<<<<<<< HEAD
            
=======
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');

>>>>>>> origin/uni-representative
=======

>>>>>>> origin/moderator_branch
            if (empty($title) || empty($category) || empty($contentType) || empty($summary)) {
                header('Location: ' . BASE_URL . '/EditPosts?error=missing_fields');
                exit;
            }
<<<<<<< HEAD
<<<<<<< HEAD
            
            $data = array(
=======

            $data = [
>>>>>>> origin/uni-representative
                'title' => $title,
                'category' => $category,
                'content_type' => $contentType,
                'summary' => $summary,
<<<<<<< HEAD
                'tags' => trim(isset($_POST['tags']) ? $_POST['tags'] : ''),
                'status' => isset($_POST['status']) ? $_POST['status'] : 'draft',
                'content' => trim(isset($_POST['content']) ? $_POST['content'] : '')
            );
            
=======
                'tags' => trim($_POST['tags'] ?? ''),
                'status' => $_POST['status'] ?? 'draft',
                'content' => trim($_POST['content'] ?? '')
            ];

>>>>>>> origin/uni-representative
=======

            $data = array(
                'title'        => $title,
                'category'     => $category,
                'content_type' => $contentType,
                'summary'      => $summary,
                'tags'         => trim(isset($_POST['tags']) ? $_POST['tags'] : ''),
                'status'       => isset($_POST['status']) ? $_POST['status'] : 'draft',
                'content'      => trim(isset($_POST['content']) ? $_POST['content'] : ''),
                // Preserve existing file info by default
                'file_path'    => $existing['file_path'],
                'file_name'    => $existing['file_name'],
                'file_size'    => $existing['file_size'],
                'file_type'    => $existing['file_type'],
            );

            // Handle file upload based on content type (mirrors createResource logic)
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

>>>>>>> origin/moderator_branch
            $resourceHub->update($resourceId, $data);
            header('Location: ' . BASE_URL . '/EditPosts?updated=1');
            exit;

<<<<<<< HEAD
        } catch (Exception $e) {
=======
        }
        catch (Exception $e) {
>>>>>>> origin/moderator_branch
            header('Location: ' . BASE_URL . '/EditPosts?error=update_failed');
            exit;
        }
    }

    private function handleFileUpload($file, $uploadDir)
    {
<<<<<<< HEAD
        $uploadPath = BASE_PATH . '/public/uploads/' . $uploadDir . '/';

        // Create directory if it doesn't exist
=======
        // Allowed types per category
        $allowedTypes = [
            'images'    => ['image/jpeg','image/png','image/gif','image/webp'],
            'videos'    => ['video/mp4','video/avi','video/quicktime','video/x-msvideo'],
            'audio'     => ['audio/mpeg','audio/mp3','audio/wav','audio/x-wav','audio/mp4','audio/m4a','audio/x-m4a'],
            'resources' => ['image/jpeg','image/png','image/gif','image/webp',
                            'video/mp4','video/avi','video/quicktime',
                            'audio/mpeg','audio/mp3','audio/wav','audio/mp4'],
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

>>>>>>> origin/moderator_branch
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

<<<<<<< HEAD
        $fileName = uniqid() . '_' . basename($file['name']);
=======
        $safeBase   = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file['name']));
        $fileName   = time() . '_' . $safeBase;
>>>>>>> origin/moderator_branch
        $targetPath = $uploadPath . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => true,
                'path'    => 'uploads/resources/' . $fileName,   // relative, NO leading slash
                'name'    => $file['name'],
                'size'    => $file['size'],
                'type'    => $mimeType,
            ];
        }
<<<<<<< HEAD
<<<<<<< HEAD
        
        return array('success' => false);
=======

        return ['success' => false];
>>>>>>> origin/uni-representative
=======

        error_log("move_uploaded_file failed: tmp={$file['tmp_name']} target={$targetPath}");
        return ['success' => false, 'error' => 'Could not move uploaded file.'];
>>>>>>> origin/moderator_branch
    }
}
