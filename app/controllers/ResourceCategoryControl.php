<?php

class ResourceCategoryControl
{
    public function __construct()
    {
        // Enforce Access: Admin, Moderator, or Counselor
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator', 'counselor'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT id, name, description, is_active FROM resource_categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        view('Admin/customize-forum-categories', [
            'categories' => $categories,
            'mode' => 'resource'
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/resource-categories');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] = 'Category name is required.';
        } else {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("INSERT INTO resource_categories (name, description) VALUES (?, ?)");
                $stmt->execute([$name, $description]);
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

        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (!$id || empty($name)) {
            $_SESSION['error'] = 'Invalid data provided.';
        } else {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("UPDATE resource_categories SET name = ?, description = ? WHERE id = ?");
                $stmt->execute([$name, $description, $id]);
                $_SESSION['success'] = 'Resource category updated.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Failed to update category.';
            }
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

        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            try {
                $pdo = Database::getConnection();
                // We use soft delete / deactivation as per existing patterns
                $stmt = $pdo->prepare("UPDATE resource_categories SET is_active = 0 WHERE id = ?");
                $stmt->execute([$id]);
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

        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("UPDATE resource_categories SET is_active = 1 WHERE id = ?");
                $stmt->execute([$id]);
                $_SESSION['success'] = 'Resource category reactivated.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Failed to reactivate category.';
            }
        }

        header('Location: ' . BASE_URL . '/resource-categories');
        exit;
    }
}
