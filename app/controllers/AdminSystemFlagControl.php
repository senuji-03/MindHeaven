<?php

class AdminSystemFlagControl
{
    private $systemFlagModel;

    public function __construct()
    {
        // Enforce Admin Access
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require_once BASE_PATH . '/app/models/SystemFlag.php';
        $this->systemFlagModel = new SystemFlag();
    }

    public function index()
    {
        $flags = $this->systemFlagModel->getAll('pending');
        view('Admin/system-flags', ['flags' => $flags]);
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/system-flags');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? ''; // 'reviewed' or 'dismissed'

        if ($id && in_array($status, ['reviewed', 'dismissed'])) {
            if ($this->systemFlagModel->updateStatus($id, $status)) {
                $_SESSION['success'] = "Flag marked as " . $status . ".";
            } else {
                $_SESSION['error'] = "Failed to update flag.";
            }
        }

        header('Location: ' . BASE_URL . '/admin/system-flags');
        exit;
    }
}

// Re-declare view helper if not already available in global scope or valid include approach.
// Ideally, this should be in a base controller or helper file.
if (!function_exists('view')) {
    function view($view, $data = [])
    {
        extract($data);
        require BASE_PATH . '/app/views/' . $view . '.php';
    }
}
