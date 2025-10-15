<?php

class SignupControl {
    
    public function index() {
        // If user is already logged in, redirect to their dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role']);
            return;
        }
        
        // Show signup form
        $this->view('layouts/signup');
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/signup');
            exit;
        }
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? '';
        
        $errors = [];
        
        // Validation
        if (empty($username)) {
            $errors[] = 'Username is required';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters long';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = 'Username can only contain letters, numbers, and underscores';
        }
        
        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }
        
        if (empty($role)) {
            $errors[] = 'Please select a role';
        } elseif (!in_array($role, ['admin', 'call_responder', 'counselor', 'donor', 'moderator', 'undergrad'])) {
            $errors[] = 'Invalid role selected';
        }
        
        // Check if username already exists
        if (empty($errors)) {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $errors[] = 'Username already exists. Please choose a different username.';
                }
            } catch (Exception $e) {
                $errors[] = 'Database error. Please try again.';
            }
        }
        
        // If there are errors, show the form again
        if (!empty($errors)) {
            $this->view('layouts/signup', ['errors' => $errors, 'form_data' => $_POST]);
            return;
        }
        
        // Create the user account
        try {
            $pdo = Database::getConnection();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashedPassword, $role]);
            
            // Registration successful - redirect to login with success message
            header('Location: ' . BASE_URL . '/login?registered=1&username=' . urlencode($username));
            exit;
            
        } catch (Exception $e) {
            $this->view('layouts/signup', ['errors' => ['Registration failed. Please try again.']]);
        }
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
