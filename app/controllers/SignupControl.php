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
        
        // Basic validation
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
        
        // Additional validation for undergraduate students
        if ($role === 'undergrad') {
            $fullName = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phoneNumber = trim($_POST['phone_number'] ?? '');
            
            if (empty($fullName)) {
                $errors[] = 'Full name is required for undergraduate students';
            }
            
            if (empty($email)) {
                $errors[] = 'Email address is required for undergraduate students';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            } elseif (!preg_match('/^[0-9]{4}[a-z]{2}[0-9]{3}@stu\.ucsc\.cmb\.ac\.lk$/', $email)) {
                $errors[] = 'Email must be a valid university email address (e.g., 2023is030@stu.ucsc.cmb.ac.lk)';
            }
            
            if (empty($phoneNumber)) {
                $errors[] = 'Phone number is required for undergraduate students';
            } elseif (!preg_match('/^0[0-9]{9}$/', $phoneNumber)) {
                $errors[] = 'Phone number must be in format 0718580160 (10 digits starting with 0)';
            }
        }
        
        // Additional validation for counselors
        if ($role === 'counselor') {
            $fullName = trim($_POST['counselor_full_name'] ?? '');
            $email = trim($_POST['counselor_email'] ?? '');
            $phoneNumber = trim($_POST['counselor_phone'] ?? '');
            $licenseNumber = trim($_POST['license_number'] ?? '');
            $specialization = trim($_POST['specialization'] ?? '');
            
            if (empty($fullName)) {
                $errors[] = 'Full name is required for counselors';
            }
            
            if (empty($email)) {
                $errors[] = 'Email address is required for counselors';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
                $errors[] = 'Email must be a Gmail address (e.g., yourname@gmail.com)';
            }
            
            if (empty($phoneNumber)) {
                $errors[] = 'Phone number is required for counselors';
            } elseif (!preg_match('/^0[0-9]{9}$/', $phoneNumber)) {
                $errors[] = 'Phone number must be in format 0718580160 (10 digits starting with 0)';
            }
            
            if (empty($licenseNumber)) {
                $errors[] = 'License number is required for counselors';
            }
            
            if (empty($specialization)) {
                $errors[] = 'Mental health specialization is required for counselors';
            }
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
        
        // Check if email already exists (for undergrad students)
        if (empty($errors) && $role === 'undergrad') {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT id FROM undergraduate_students WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $errors[] = 'Email address already exists. Please use a different email.';
                }
            } catch (Exception $e) {
                $errors[] = 'Database error. Please try again.';
            }
        }
        
        // Check if email and license number already exist (for counselors)
        if (empty($errors) && $role === 'counselor') {
            try {
                $pdo = Database::getConnection();
                
                // Check email in counselors table
                $stmt = $pdo->prepare("SELECT id FROM counselors WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $errors[] = 'Email address already exists. Please use a different email.';
                }
                
                // Check license number
                $stmt = $pdo->prepare("SELECT id FROM counselors WHERE license_number = ?");
                $stmt->execute([$licenseNumber]);
                if ($stmt->fetch()) {
                    $errors[] = 'License number already exists. Please verify your license number.';
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
            
            // Start transaction
            $pdo->beginTransaction();
            
            // Insert into users table
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashedPassword, $role]);
            $userId = $pdo->lastInsertId();
            
            // If undergraduate student, insert additional data
            if ($role === 'undergrad') {
                $undergraduateModel = new Undergraduate();
                $undergradData = [
                    'full_name' => trim($_POST['full_name']),
                    'email' => trim($_POST['email']),
                    'phone_number' => trim($_POST['phone_number']),
                    'date_of_birth' => $_POST['date_of_birth'] ?? null,
                    'gender' => $_POST['gender'] ?? null,
                    'preferred_language' => trim($_POST['preferred_language'] ?? 'en')
                ];
                
                $undergraduateModel->create($userId, $undergradData);
            }
            
            // If counselor, insert additional data
            if ($role === 'counselor') {
                $counselorModel = new Counselor();
                $counselorData = [
                    'full_name' => trim($_POST['counselor_full_name']),
                    'email' => trim($_POST['counselor_email']),
                    'phone_number' => trim($_POST['counselor_phone']),
                    'license_number' => trim($_POST['license_number']),
                    'specialization' => trim($_POST['specialization']),
                    'years_experience' => !empty($_POST['years_experience']) ? (int)$_POST['years_experience'] : null,
                    'bio' => trim($_POST['bio'] ?? '')
                ];
                
                $counselorModel->create($userId, $counselorData);
            }
            
            // Commit transaction
            $pdo->commit();
            
            // Registration successful - redirect to login with success message
            if ($role === 'counselor') {
                header('Location: ' . BASE_URL . '/login?registered=1&username=' . urlencode($username) . '&pending_approval=1');
            } else {
                header('Location: ' . BASE_URL . '/login?registered=1&username=' . urlencode($username));
            }
            exit;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            if (isset($pdo)) {
                $pdo->rollback();
            }
            $this->view('layouts/signup', ['errors' => ['Registration failed. Please try again. Error: ' . $e->getMessage()]]);
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
