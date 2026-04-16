<?php

class AdminKeywordControl
{
    private $keywordModel;

    public function __construct()
    {
        // Enforce Access (Admin or Moderator)
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'moderator')) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require_once BASE_PATH . '/app/models/Keyword.php';
        $this->keywordModel = new Keyword();
    }

    public function index()
    {
        $keywords = $this->keywordModel->getAll();
        view('Admin/keywords', ['keywords' => $keywords]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/keywords');
            exit;
        }

        $keyword = trim($_POST['keyword'] ?? '');

        if (strlen($keyword) < 2) {
            $_SESSION['error'] = "Keyword must be at least 2 characters.";
        } else {
            if ($this->keywordModel->exists($keyword)) {
                $_SESSION['error'] = "Keyword already exists.";
            } else {
                if ($this->keywordModel->add($keyword)) {
                    $_SESSION['success'] = "Keyword added successfully.";
                } else {
                    $_SESSION['error'] = "Failed to add keyword.";
                }
            }
        }

        header('Location: ' . BASE_URL . '/admin/keywords');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/keywords');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if ($id) {
            if ($this->keywordModel->delete($id)) {
                $_SESSION['success'] = "Keyword deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete keyword.";
            }
        }

        header('Location: ' . BASE_URL . '/admin/keywords');
        exit;
    }
}


