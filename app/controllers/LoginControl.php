<?php

class LoginControl {
    
    public function index() {
        // If user is already logged in, redirect to their dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role']);
            return;
        }
        
        // Check for registration success message
        $data = [];
        if (isset($_GET['registered']) && $_GET['registered'] == '1') {
            $data['success'] = 'Account created successfully! You can now login with your credentials.';
            if (isset($_GET['username'])) {
                $data['username'] = $_GET['username'];
            }
        }
        
        // Show login form
        $this->view('layouts/login', $data);
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $this->view('layouts/login', ['error' => 'Please enter both username and password']);
            return;
        }
        
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                $this->redirectToDashboard($user['role']);
            } else {
                $this->view('layouts/login', ['error' => 'Invalid username or password']);
            }
        } catch (Exception $e) {
            $this->view('layouts/login', ['error' => 'Login failed. Please try again.']);
        }
    }
    
    public function logout() {
        // Clear all session data
        session_unset();
        session_destroy();
        
        // Redirect to login page
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
    
    private function redirectToDashboard($role) {
        $dashboardUrls = [
            'admin' => BASE_URL . '/admin',
            'call_responder' => BASE_URL . '/CallResponder',
            'counselor' => BASE_URL . '/counselor',
            'donor' => BASE_URL . '/DonationForm',
            'moderator' => BASE_URL . '/ModeratorDashboard',
            'undergrad' => BASE_URL . '/ug'
        ];
        
        $url = $dashboardUrls[$role] ?? BASE_URL . '/ug';
        header('Location: ' . $url);
        exit;
    }
    
    private function view($view, $data = []) {
        // Extract data array to variables
        extract($data);
        
        // Include the view file
        $viewFile = BASE_PATH . '/app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            die("View file not found: " . $viewFile);
        }
    }
}
