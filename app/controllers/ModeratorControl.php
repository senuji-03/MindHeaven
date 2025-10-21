<?php

require_once BASE_PATH . '/app/models/ResourceHub.php';

class ModeratorControl{
    public function edit() {
        try {
            $resourceHub = new ResourceHub();
            $resources = $resourceHub->getAll();
            view('Moderator/editPosts', ['resources' => $resources]);
        } catch (Exception $e) {
            view('Moderator/editPosts', ['resources' => [], 'error' => 'Failed to load resources: ' . $e->getMessage()]);
        }
    }
    
    public function flagged() {
        view('Moderator/FlaggedUsers');
    }
    
    public function ModeratorDashboard() {
        view('Moderator/ModeratorDashboard');
    }
    
    public function warn() {
        view('Moderator/warnForm');
    }
    
    
    public function createResource() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/EditPosts');
            exit;
        }
        
        try {
            $resourceHub = new ResourceHub();
            
            // Get current user ID (assuming session is set)
            $userId = $_SESSION['user_id'] ?? 1; // Fallback to 1 for testing
            
            // Validate required fields
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');
            
            if (empty($title) || empty($category) || empty($contentType) || empty($summary)) {
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
                'created_by' => $userId
            ];
            
            // Handle content based on type
            if ($contentType === 'article') {
                $data['content'] = trim($_POST['content'] ?? '');
                
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
                $data['content'] = trim($_POST['content'] ?? '');
                
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
    
    public function deleteResource() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/EditPosts');
            exit;
        }
        
        try {
            $resourceId = (int)($_POST['id'] ?? 0);
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
    
    public function editResource() {
        $resourceId = (int)($_GET['id'] ?? 0);
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
    
    public function updateResource() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/EditPosts');
            exit;
        }
        
        try {
            $resourceId = (int)($_POST['id'] ?? 0);
            if ($resourceId <= 0) {
                header('Location: ' . BASE_URL . '/EditPosts?error=invalid_id');
                exit;
            }
            
            $resourceHub = new ResourceHub();
            
            // Validate required fields
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $contentType = trim($_POST['content_type'] ?? '');
            $summary = trim($_POST['summary'] ?? '');
            
            if (empty($title) || empty($category) || empty($contentType) || empty($summary)) {
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
                'content' => trim($_POST['content'] ?? '')
            ];
            
            $resourceHub->update($resourceId, $data);
            header('Location: ' . BASE_URL . '/EditPosts?updated=1');
            exit;
            
        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/EditPosts?error=update_failed');
            exit;
        }
    }
    
    private function handleFileUpload($file, $uploadDir) {
        $uploadPath = BASE_PATH . '/public/uploads/' . $uploadDir . '/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadPath . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => true,
                'path' => '/uploads/' . $uploadDir . '/' . $fileName,
                'name' => $file['name'],
                'size' => $file['size'],
                'type' => $file['type']
            ];
        }
        
        return ['success' => false];
    }
}