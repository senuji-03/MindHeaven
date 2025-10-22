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
                
                // Special handling for University Representatives
                // Check if this is a University Representative by username or other criteria
                if (stripos($user['username'], 'university') !== false || 
                    stripos($user['username'], 'rep') !== false ||
                    stripos($user['username'], 'representative') !== false) {
                    $_SESSION['role'] = 'university_rep';
                }
                
                $this->redirectToDashboard($_SESSION['role']);
            } else {
                $this->view('layouts/login', ['error' => 'Invalid username or password']);
            }
        } catch (Exception $e) {
            $this->view('layouts/login', ['error' => 'Login failed. Please try again.']);
        }
    }
    
    public function forgotPassword() {
        // If user is already logged in, redirect to their dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role']);
            return;
        }
        
        $data = [];
        $this->view('layouts/forgot-password', $data);
    }
    
    public function processForgotPassword() {
        // If user is already logged in, redirect to their dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role']);
            return;
        }
        
        $data = [];
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $errors = [];
            
            if (empty($email)) {
                $errors[] = 'Email address is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
                $errors[] = 'Email must be a Gmail address (e.g., yourname@gmail.com)';
            }
            
            if (empty($errors)) {
                try {
                    $pdo = Database::getConnection();
                    
                    // Check if user exists with this email in counselors or undergraduate_students tables
                    $user = null;
                    
                    // Check counselors table
                    $stmt = $pdo->prepare("SELECT c.user_id, u.username FROM counselors c JOIN users u ON c.user_id = u.id WHERE c.email = ?");
                    $stmt->execute([$email]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // If not found in counselors, check undergraduate_students table
                    if (!$user) {
                        $stmt = $pdo->prepare("SELECT us.user_id, u.username FROM undergraduate_students us JOIN users u ON us.user_id = u.id WHERE us.email = ?");
                        $stmt->execute([$email]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    
                    if ($user) {
                        // Generate reset token
                        $token = bin2hex(random_bytes(32));
                        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
                        
                        // Store token in database
                        $stmt = $pdo->prepare("INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
                        $stmt->execute([$user['user_id'], $token, $expiresAt]);
                        
                        // In a real application, you would send an email here
                        // For now, we'll just show the reset link
                        $resetLink = BASE_URL . '/login/reset-password?token=' . $token;
                        $data['success'] = 'Password reset link has been generated.';
                        $data['reset_link'] = $resetLink;
                    } else {
                        $data['error'] = 'No account found with this email address';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'An error occurred. Please try again.';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }
        
        $this->view('layouts/forgot-password', $data);
    }
    
    public function resetPassword() {
        // If user is already logged in, redirect to their dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role']);
            return;
        }
        
        $token = $_GET['token'] ?? $_POST['token'] ?? '';
        $data = ['token' => $token];
        
        if (empty($token)) {
            $data['error'] = 'Invalid or missing reset token';
            $this->view('layouts/reset-password', $data);
            return;
        }
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $errors = [];
            
            if (empty($password)) {
                $errors[] = 'Password is required';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters long';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                try {
                    $pdo = Database::getConnection();
                    
                    // Verify token
                    $stmt = $pdo->prepare("
                        SELECT prt.user_id, u.username 
                        FROM password_reset_tokens prt 
                        JOIN users u ON prt.user_id = u.id 
                        WHERE prt.token = ? AND prt.expires_at > NOW() AND prt.used = 0
                    ");
                    $stmt->execute([$token]);
                    $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($tokenData) {
                        // Update password
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $stmt->execute([$hashedPassword, $tokenData['user_id']]);
                        
                        // Mark token as used
                        $stmt = $pdo->prepare("UPDATE password_reset_tokens SET used = 1 WHERE token = ?");
                        $stmt->execute([$token]);
                        
                        $data['success'] = 'Password has been reset successfully. You can now login with your new password.';
                    } else {
                        $data['error'] = 'Invalid or expired reset token';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'An error occurred. Please try again.';
                }
            } else {
                $data['error'] = implode('<br>', $errors);
            }
        }
        
        $this->view('layouts/reset-password', $data);
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
        // Debug: Log the role being processed
        error_log("LoginControl: Redirecting user with role: " . $role);
        
        $dashboardUrls = [
            'admin' => BASE_URL . '/admin',
            'call_responder' => BASE_URL . '/CallResponder',
            'counselor' => BASE_URL . '/counselor',
            'donor' => BASE_URL . '/DonationForm',
            'moderator' => BASE_URL . '/ModeratorDashboard',
            'undergrad' => BASE_URL . '/ug',
            'university_rep' => BASE_URL . '/UniversityRepresentative/dashboard',
            'university_representative' => BASE_URL . '/UniversityRepresentative/dashboard'
        ];
        
        $url = $dashboardUrls[$role] ?? BASE_URL . '/ug';
        error_log("LoginControl: Redirecting to URL: " . $url);
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
