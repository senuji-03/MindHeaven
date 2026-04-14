<?php

class LoginControl
{

    public function index()
    {
        // If user is already logged in, redirect to their dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role']);
            return;
        }

        // Check for registration success message
        $data = [];
        if (isset($_GET['registered']) && $_GET['registered'] == '1') {
            if (isset($_GET['pending_approval']) && $_GET['pending_approval'] == '1') {
                $data['success'] = 'Account created successfully! Your counselor account is pending admin approval. You will be able to login once approved.';
            } else {
                $data['success'] = 'Account created successfully! You can now login with your credentials.';
            }
            if (isset($_GET['username'])) {
                $data['username'] = $_GET['username'];
            }
        }

        // Show login form
        $this->view('layouts/login', $data);
    }

    public function authenticate()
    {
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
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Check if counselor is approved
                if ($user['role'] === 'counselor') {
                    $stmt = $pdo->prepare("SELECT is_approved FROM counselors WHERE user_id = ?");
                    $stmt->execute([$user['id']]);
                    $counselor = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$counselor || !$counselor['is_approved']) {
                        $this->view('layouts/login', ['error' => 'Your counselor account is pending approval. Please wait for admin approval before logging in.']);
                        return;
                    }
                }

                // 1. Check if deleted (only if column exists)
                if (!empty($user['is_deleted'])) {
                    $this->view('layouts/login', ['error' => 'Your account does not exist or has been deleted.']);
                    return;
                }

                // 2. Check suspension (only if column exists)
                if (isset($user['account_status'])) {
                    if ($user['account_status'] === 'suspended') {
                        // Try auto-unsuspend via model if available
                        if (file_exists(BASE_PATH . '/app/models/User.php')) {
                            require_once BASE_PATH . '/app/models/User.php';
                            $userModel = new User();
                            if ($userModel->isSuspended($user['id'])) {
                                $user = $userModel->getById($user['id']);
                                if (($user['account_status'] ?? '') === 'suspended') {
                                    $this->view('layouts/login', ['error' => 'Your account is suspended. Check back later.']);
                                    return;
                                }
                            }
                        }
                    }

                    // 3. Check active state (banned users)
                    if ($user['account_status'] === 'inactive' || $user['account_status'] === 'banned') {
                        $this->view('layouts/login', ['error' => 'Your account is currently inactive.']);
                        return;
                    }
                }

                // 4. Check if password reset is required (only if column exists)
                if (!empty($user['password_reset_required']) && $user['password_reset_required'] == 1) {
                    $_SESSION['force_password_change_user_id'] = $user['id'];
                    header('Location: ' . BASE_URL . '/login/forcePasswordChange');
                    exit;
                }

                // Login successful — set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                $assignedRole = $user['role'];
                // Preserve call_responder role (do NOT override with university_rep heuristic)
                if ($assignedRole !== 'call_responder') {
                    if (
                        stripos($user['username'], 'university') !== false ||
                        stripos($user['username'], 'rep') !== false ||
                        stripos($user['username'], 'representative') !== false
                    ) {
                        $assignedRole = 'university_representative';
                    }
                }
                $_SESSION['role'] = $assignedRole;

                // Fetch university name for University Representatives
                if ($_SESSION['role'] === 'university_representative') {
                    $uniStmt = $pdo->prepare("
                        SELECT u.name 
                        FROM universities u 
                        JOIN university_representatives ur ON u.id = ur.university_id 
                        WHERE ur.user_id = ?
                    ");
                    $uniStmt->execute([$user['id']]);
                    $uniName = $uniStmt->fetchColumn();
                    $_SESSION['university_name'] = $uniName ?: 'University';
                }

                $this->redirectToDashboard($_SESSION['role']);
            } else {
                $this->view('layouts/login', ['error' => 'Invalid username or password']);
            }
        } catch (Exception $e) {
            error_log('Login error: ' . $e->getMessage());
            $this->view('layouts/login', ['error' => 'Login failed. Please try again.']);
        }
    }

    public function forcePasswordChange()
    {
        if (!isset($_SESSION['force_password_change_user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->view('layouts/force-password-change', []);
    }

    public function processForcePasswordChange()
    {
        if (!isset($_SESSION['force_password_change_user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login/forcePasswordChange');
            exit;
        }

        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($password) || strlen($password) < 6) {
            $this->view('layouts/force-password-change', ['error' => 'Password must be at least 6 characters']);
            return;
        }

        if ($password !== $confirmPassword) {
            $this->view('layouts/force-password-change', ['error' => 'Passwords do not match']);
            return;
        }

        try {
            $userId = $_SESSION['force_password_change_user_id'];
            $pdo = Database::getConnection();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ?, password_reset_required = 0 WHERE id = ?");
            $stmt->execute([$hashedPassword, $userId]);

            // Now properly log them in by fetching their info again
            $stmt = $pdo->prepare("SELECT id, username, role FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            unset($_SESSION['force_password_change_user_id']); // Clear the flag

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            $assignedRole = $user['role'];
            $_SESSION['role'] = $assignedRole;

            $this->redirectToDashboard($_SESSION['role']);
        } catch (Exception $e) {
            $this->view('layouts/force-password-change', ['error' => 'Failed to update password.']);
        }
    }

    public function forgotPassword()
    {
        // If user is already logged in, redirect to their dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['role']);
            return;
        }

        $data = [];
        $this->view('layouts/forgot-password', $data);
    }

    public function processForgotPassword()
    {
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

                    // Check users table for email
                    $stmt = $pdo->prepare("SELECT id as user_id, username FROM users WHERE email = ? AND is_deleted = 0");
                    $stmt->execute([$email]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public function resetPassword()
    {
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

    public function logout()
    {
        // Clear all session data
        session_unset();
        session_destroy();

        // Add security headers to prevent caching and back-button access
        if (class_exists('Auth')) {
            Auth::setSecurityHeaders();
        }

        // Redirect to login page
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    private function redirectToDashboard($role)
    {
        // Debug: Log the role being processed
        error_log("LoginControl: Redirecting user with role: " . $role);

        $dashboardUrls = [
            'admin' => BASE_URL . '/admin',
            'call_responder' => BASE_URL . '/CallResponder',
            'counselor' => BASE_URL . '/counselor',
            'donor' => BASE_URL . '/donation',
            'moderator' => BASE_URL . '/ModeratorDashboard',
            'undergraduate' => BASE_URL . '/ug',
            'university_representative' => BASE_URL . '/university-rep/dashboard'
        ];

        if (isset($dashboardUrls[$role])) {
            $url = $dashboardUrls[$role];
            error_log("LoginControl: Redirecting to URL: " . $url);
            header('Location: ' . $url);
            exit;
        } else {
            // Role not found, prevent infinite loop by destroying session
            error_log("LoginControl: Unknown role '$role'. Logging out to prevent redirect loop.");

            // Clear all session data
            session_unset();
            session_destroy();

            // Redirect to login with error
            header('Location: ' . BASE_URL . '/login?error=Invalid+Role+Configuration');
            exit;
        }
    }

    private function view($view, $data = [])
    {
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
