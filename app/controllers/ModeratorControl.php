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
        } catch (Exception $e) {
            view('Moderator/editPosts', array('resources' => array(), 'error' => 'Failed to load resources: ' . $e->getMessage()));
        }
    }

    public function flagged()
    {
        view('Moderator/FlaggedUsers');
    }

    public function ModeratorDashboard()
    {
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

    public function warn()
    {
        view('Moderator/warnForm');
>>>>>>> origin/uni-representative
    }


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
            
=======
            $userId = $_SESSION['user_id'] ?? 1; // Fallback to 1 for testing

            // Validate required fields
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');

>>>>>>> origin/uni-representative
            if (empty($title) || empty($category) || empty($contentType) || empty($summary)) {
                header('Location: ' . BASE_URL . '/EditPosts?error=missing_fields');
                exit;
            }
<<<<<<< HEAD
            
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
                
=======
            ];

            // Handle content based on type
            if ($contentType === 'article') {
                $data['content'] = trim($_POST['content'] ?? '');

>>>>>>> origin/uni-representative
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
            } else {
<<<<<<< HEAD
                $data['content'] = trim(isset($_POST['content']) ? $_POST['content'] : '');
                
=======
                $data['content'] = trim($_POST['content'] ?? '');

>>>>>>> origin/uni-representative
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

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/EditPosts?error=deletion_failed');
            exit;
        }
    }
<<<<<<< HEAD
    
    public function editResource() {
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
            
            view('Moderator/editResource', array('resource' => $resource));
            
=======

            view('Moderator/editResource', ['resource' => $resource]);

>>>>>>> origin/uni-representative
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

            // Validate required fields
<<<<<<< HEAD
            $title = trim(isset($_POST['title']) ? $_POST['title'] : '');
            $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
            $contentType = trim(isset($_POST['content_type']) ? $_POST['content_type'] : '');
            $summary = trim(isset($_POST['summary']) ? $_POST['summary'] : '');
            
=======
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');

>>>>>>> origin/uni-representative
            if (empty($title) || empty($category) || empty($contentType) || empty($summary)) {
                header('Location: ' . BASE_URL . '/EditPosts?error=missing_fields');
                exit;
            }
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
        $uploadPath = BASE_PATH . '/public/uploads/' . $uploadDir . '/';

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadPath . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return array(
                'success' => true,
                'path' => '/uploads/' . $uploadDir . '/' . $fileName,
                'name' => $file['name'],
                'size' => $file['size'],
                'type' => $file['type']
            );
        }
<<<<<<< HEAD
        
        return array('success' => false);
=======

        return ['success' => false];
>>>>>>> origin/uni-representative
    }
}
