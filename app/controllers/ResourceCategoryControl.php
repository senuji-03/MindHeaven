<?php

class ResourceCategoryControl
{
    public function __construct()
    {
        // Enforce Access: Admin, Moderator, or Counselor
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], array('admin', 'moderator', 'counselor'))) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index()
    {
        $pdo = Database::getConnection();
        // Fetch thumbnail column as well
        $stmt = $pdo->query("SELECT id, name, description, is_active, thumbnail FROM resource_categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        view('Admin/customize-forum-categories', array(
            'categories' => $categories,
            'mode' => 'resource'
        ));
    }

    private function handleUpload()
    {
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/categories/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileExtension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('cat_') . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                // Return relative path for database storage
                return 'uploads/categories/' . $fileName;
            }
        }
        return null;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/resource-categories');
            exit;
        }

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $thumbnail = $this->handleUpload();

        if (empty($name)) {
            $_SESSION['error'] = 'Category name is required.';
        } else {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("INSERT INTO resource_categories (name, description, thumbnail) VALUES (?, ?, ?)");
                $stmt->execute(array($name, $description, $thumbnail));
                $_SESSION['success'] = 'Resource category created successfully.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Failed to create category: ' . $e->getMessage();
            }
        }

        header('Location: ' . BASE_URL . '/resource-categories');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/resource-categories');
            exit;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        
        if (!$id || empty($name)) {
            $_SESSION['error'] = 'Invalid data provided.';
            header('Location: ' . BASE_URL . '/resource-categories');
            exit;
        }

        try {
            $pdo = Database::getConnection();
            
            // 1. Get current category data to check for name change
            $stmt = $pdo->prepare("SELECT name, thumbnail FROM resource_categories WHERE id = ?");
            $stmt->execute(array($id));
            $currentData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$currentData) {
                $_SESSION['error'] = 'Category not found.';
                header('Location: ' . BASE_URL . '/resource-categories');
                exit;
            }

            $oldName = $currentData['name'];
            $newThumbnail = $this->handleUpload();
            if (!$newThumbnail) {
                $newThumbnail = $currentData['thumbnail'];
            }

            // 2. Update the category
            $stmt = $pdo->prepare("UPDATE resource_categories SET name = ?, description = ?, thumbnail = ? WHERE id = ?");
            $stmt->execute(array($name, $description, $newThumbnail, $id));

            // 3. PROPAGATE NAME CHANGE TO RESOURCE_HUB
            // If the name has changed, update all resources that were using the old name
            if ($oldName !== $name) {
                $stmtSync = $pdo->prepare("UPDATE resource_hub SET category = ? WHERE category = ?");
                $stmtSync->execute(array($name, $oldName));
                $_SESSION['success'] = 'Resource category and ' . $stmtSync->rowCount() . ' related resources updated.';
            } else {
                $_SESSION['success'] = 'Resource category updated.';
            }

        } catch (Exception $e) {
            $_SESSION['error'] = 'Failed to update category: ' . $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/resource-categories');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/resource-categories');
            exit;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id) {
            try {
                $pdo = Database::getConnection();
                // We use soft delete / deactivation as per existing patterns
                $stmt = $pdo->prepare("UPDATE resource_categories SET is_active = 0 WHERE id = ?");
                $stmt->execute(array($id));
                $_SESSION['success'] = 'Resource category deactivated.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Failed to deactivate category.';
            }
        }

        header('Location: ' . BASE_URL . '/resource-categories');
        exit;
    }

    public function activate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/resource-categories');
            exit;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id) {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("UPDATE resource_categories SET is_active = 1 WHERE id = ?");
                $stmt->execute(array($id));
                $_SESSION['success'] = 'Resource category reactivated.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Failed to reactivate category.';
            }
        }

        header('Location: ' . BASE_URL . '/resource-categories');
        exit;
    }
}
