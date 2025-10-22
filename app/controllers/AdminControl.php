<?php
class AdminControl {
    public function index() {
        // This will load the main admin dashboard
        view('Admin/index');
    }

    public function manageUsers() {
        try {
            $pdo = Database::getConnection();
            
            // Get all users with their details (for general user management)
            $stmt = $pdo->prepare("
                SELECT u.id, u.username, u.full_name, u.role, 
                       CASE 
                           WHEN u.role = 'counselor' THEN c.full_name
                           WHEN u.role = 'undergrad' THEN us.full_name
                           ELSE u.full_name
                       END as display_name,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.email
                           WHEN u.role = 'undergrad' THEN us.email
                           ELSE NULL
                       END as email,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.phone_number
                           WHEN u.role = 'undergrad' THEN us.phone_number
                           ELSE NULL
                       END as phone_number,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.created_at
                           WHEN u.role = 'undergrad' THEN us.created_at
                           ELSE NULL
                       END as created_at
                FROM users u
                LEFT JOIN counselors c ON u.id = c.user_id AND u.role = 'counselor'
                LEFT JOIN undergraduate_students us ON u.id = us.user_id AND u.role = 'undergrad'
                ORDER BY 
                    CASE 
                        WHEN u.role = 'counselor' THEN c.created_at
                        WHEN u.role = 'undergrad' THEN us.created_at
                        ELSE u.id
                    END DESC
            ");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch undergraduate students separately
            $stmt = $pdo->prepare("
                SELECT u.*, us.*, us.full_name as display_name, us.email, us.phone_number, us.created_at
                FROM users u
                JOIN undergraduate_students us ON u.id = us.user_id
                WHERE u.role = 'undergrad'
                ORDER BY us.created_at DESC
            ");
            $stmt->execute();
            $undergraduateStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch counselors separately
            $stmt = $pdo->prepare("
                SELECT u.*, c.*, c.full_name as display_name, c.email, c.phone_number, c.created_at
                FROM users u
                JOIN counselors c ON u.id = c.user_id
                WHERE u.role = 'counselor'
                ORDER BY c.created_at DESC
            ");
            $stmt->execute();
            $counselors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            view('Admin/manage-users', [
                'users' => $users,
                'undergraduateStudents' => $undergraduateStudents,
                'counselors' => $counselors
            ]);
        } catch (Exception $e) {
            view('Admin/manage-users', [
                'users' => [], 
                'undergraduateStudents' => [],
                'counselors' => [],
                'error' => 'Failed to load users: ' . $e->getMessage()
            ]);
        }
    }
    
    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/manage-users');
            exit;
        }
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? '';
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phoneNumber = trim($_POST['phone_number'] ?? '');
        
        $errors = [];
        
        // Validation
        if (empty($username)) {
            $errors[] = 'Username is required';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters long';
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
            $errors[] = 'Role is required';
        } elseif (!in_array($role, ['admin', 'call_responder', 'counselor', 'donor', 'moderator', 'undergrad', 'university_rep'])) {
            $errors[] = 'Invalid role selected';
        }
        
        if (empty($fullName)) {
            $errors[] = 'Full name is required';
        }
        
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address';
        } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
            $errors[] = 'Email must be a Gmail address';
        }
        
        if (empty($phoneNumber)) {
            $errors[] = 'Phone number is required';
        } elseif (!preg_match('/^0[0-9]{9}$/', $phoneNumber)) {
            $errors[] = 'Phone number must be in format 0718580160 (10 digits starting with 0)';
        }
        
        // Check if username already exists
        if (empty($errors)) {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $errors[] = 'Username already exists';
                }
                
                // Check if email already exists
                if ($role === 'counselor') {
                    $stmt = $pdo->prepare("SELECT id FROM counselors WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        $errors[] = 'Email already exists';
                    }
                } elseif ($role === 'undergrad') {
                    $stmt = $pdo->prepare("SELECT id FROM undergraduate_students WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        $errors[] = 'Email already exists';
                    }
                }
            } catch (Exception $e) {
                $errors[] = 'Database error: ' . $e->getMessage();
            }
        }
        
        if (!empty($errors)) {
            header('Location: ' . BASE_URL . '/admin/manage-users?error=' . urlencode(implode(', ', $errors)));
            exit;
        }
        
        // Create user
        try {
            $pdo = Database::getConnection();
            $pdo->beginTransaction();
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, full_name, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $fullName, $hashedPassword, $role]);
            $userId = $pdo->lastInsertId();
            
            // Insert into role-specific table
            if ($role === 'counselor') {
                $licenseNumber = trim($_POST['license_number'] ?? '');
                $specialization = trim($_POST['specialization'] ?? '');
                $yearsExperience = !empty($_POST['years_experience']) ? (int)$_POST['years_experience'] : null;
                $bio = trim($_POST['bio'] ?? '');
                
                if (empty($licenseNumber)) {
                    $errors[] = 'License number is required for counselors';
                }
                if (empty($specialization)) {
                    $errors[] = 'Specialization is required for counselors';
                }
                
                if (!empty($errors)) {
                    $pdo->rollback();
                    header('Location: ' . BASE_URL . '/admin/manage-users?error=' . urlencode(implode(', ', $errors)));
                    exit;
                }
                
                // Try to insert with all fields first, fallback to basic fields if some columns don't exist
                try {
                    $stmt = $pdo->prepare("INSERT INTO counselors (user_id, full_name, email, phone_number, license_number, specialization, experience_years, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$userId, $fullName, $email, $phoneNumber, $licenseNumber, $specialization, $yearsExperience, $bio]);
                } catch (PDOException $e) {
                    // If the full insert fails, try with just the basic fields
                    if (strpos($e->getMessage(), 'Unknown column') !== false) {
                        $stmt = $pdo->prepare("INSERT INTO counselors (user_id, full_name, email, phone_number, license_number) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$userId, $fullName, $email, $phoneNumber, $licenseNumber]);
                    } else {
                        throw $e; // Re-throw if it's not a column issue
                    }
                }
            } elseif ($role === 'undergrad') {
                $stmt = $pdo->prepare("INSERT INTO undergraduate_students (user_id, full_name, email, phone_number) VALUES (?, ?, ?, ?)");
                $stmt->execute([$userId, $fullName, $email, $phoneNumber]);
            } elseif ($role === 'university_rep') {
                // For now, just create the user without additional data until university_representatives table is created
                // TODO: Add university_representatives table and uncomment the following lines
                /*
                $universityName = trim($_POST['university_name'] ?? '');
                $position = trim($_POST['position'] ?? '');
                
                $stmt = $pdo->prepare("INSERT INTO university_representatives (user_id, full_name, email, phone_number, university_name, position) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$userId, $fullName, $email, $phoneNumber, $universityName, $position]);
                */
            }
            
            $pdo->commit();
            header('Location: ' . BASE_URL . '/admin/manage-users?success=User created successfully');
            exit;
            
        } catch (Exception $e) {
            $pdo->rollback();
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to create user: ' . $e->getMessage());
            exit;
        }
    }
    
    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/manage-users');
            exit;
        }
        
        $userId = $_POST['user_id'] ?? '';
        $username = trim($_POST['username'] ?? '');
        $role = $_POST['role'] ?? '';
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phoneNumber = trim($_POST['phone_number'] ?? '');
        $password = $_POST['password'] ?? '';
        
        $errors = [];
        
        if (empty($userId) || !is_numeric($userId)) {
            $errors[] = 'Invalid user ID';
        }
        
        if (empty($username)) {
            $errors[] = 'Username is required';
        }
        
        if (empty($fullName)) {
            $errors[] = 'Full name is required';
        }
        
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address';
        } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
            $errors[] = 'Email must be a Gmail address';
        }
        
        if (empty($phoneNumber)) {
            $errors[] = 'Phone number is required';
        } elseif (!preg_match('/^0[0-9]{9}$/', $phoneNumber)) {
            $errors[] = 'Phone number must be in format 0718580160 (10 digits starting with 0)';
        }
        
        if (!empty($errors)) {
            header('Location: ' . BASE_URL . '/admin/manage-users?error=' . urlencode(implode(', ', $errors)));
            exit;
        }
        
        try {
            $pdo = Database::getConnection();
            $pdo->beginTransaction();
            
            // Update users table
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = ?, full_name = ?, password = ? WHERE id = ?");
                $stmt->execute([$username, $fullName, $hashedPassword, $userId]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username = ?, full_name = ? WHERE id = ?");
                $stmt->execute([$username, $fullName, $userId]);
            }
            
            // Update role-specific table
            if ($role === 'counselor') {
                $licenseNumber = trim($_POST['license_number'] ?? '');
                $specialization = trim($_POST['specialization'] ?? '');
                $yearsExperience = !empty($_POST['years_experience']) ? (int)$_POST['years_experience'] : null;
                $bio = trim($_POST['bio'] ?? '');
                
                if (empty($licenseNumber)) {
                    $errors[] = 'License number is required for counselors';
                }
                if (empty($specialization)) {
                    $errors[] = 'Specialization is required for counselors';
                }
                
                if (!empty($errors)) {
                    $pdo->rollback();
                    header('Location: ' . BASE_URL . '/admin/manage-users?error=' . urlencode(implode(', ', $errors)));
                    exit;
                }
                
                // Try to update with all fields first, fallback to basic fields if some columns don't exist
                try {
                    $stmt = $pdo->prepare("UPDATE counselors SET full_name = ?, email = ?, phone_number = ?, license_number = ?, specialization = ?, experience_years = ?, bio = ? WHERE user_id = ?");
                    $stmt->execute([$fullName, $email, $phoneNumber, $licenseNumber, $specialization, $yearsExperience, $bio, $userId]);
                } catch (PDOException $e) {
                    // If the full update fails, try with just the basic fields
                    if (strpos($e->getMessage(), 'Unknown column') !== false) {
                        $stmt = $pdo->prepare("UPDATE counselors SET full_name = ?, email = ?, phone_number = ?, license_number = ? WHERE user_id = ?");
                        $stmt->execute([$fullName, $email, $phoneNumber, $licenseNumber, $userId]);
                    } else {
                        throw $e; // Re-throw if it's not a column issue
                    }
                }
            } elseif ($role === 'undergrad') {
                $stmt = $pdo->prepare("UPDATE undergraduate_students SET full_name = ?, email = ?, phone_number = ? WHERE user_id = ?");
                $stmt->execute([$fullName, $email, $phoneNumber, $userId]);
            } elseif ($role === 'university_rep') {
                // For now, just update the user without additional data until university_representatives table is created
                // TODO: Add university_representatives table and uncomment the following lines
                /*
                $universityName = trim($_POST['university_name'] ?? '');
                $position = trim($_POST['position'] ?? '');
                
                $stmt = $pdo->prepare("UPDATE university_representatives SET full_name = ?, email = ?, phone_number = ?, university_name = ?, position = ? WHERE user_id = ?");
                $stmt->execute([$fullName, $email, $phoneNumber, $universityName, $position, $userId]);
                */
            }
            
            $pdo->commit();
            header('Location: ' . BASE_URL . '/admin/manage-users?success=User updated successfully');
            exit;
            
        } catch (Exception $e) {
            $pdo->rollback();
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to update user: ' . $e->getMessage());
            exit;
        }
    }
    
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/manage-users');
            exit;
        }
        
        $userId = $_POST['user_id'] ?? '';
        
        if (empty($userId) || !is_numeric($userId)) {
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Invalid user ID');
            exit;
        }
        
        try {
            $pdo = Database::getConnection();
            $pdo->beginTransaction();
            
            // Delete from role-specific tables first (due to foreign key constraints)
            $stmt = $pdo->prepare("DELETE FROM counselors WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            $stmt = $pdo->prepare("DELETE FROM undergraduate_students WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            // Delete from users table
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            
            $pdo->commit();
            header('Location: ' . BASE_URL . '/admin/manage-users?success=User deleted successfully');
            exit;
            
        } catch (Exception $e) {
            $pdo->rollback();
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to delete user: ' . $e->getMessage());
            exit;
        }
    }

    public function resourceHub() {
        view('Admin/resource-hub');
    }

    public function moderateForum() {
        view('Admin/moderate-forum');
    }

    public function counselors() {
        view('Admin/counselors');
    }

    public function appointments() {
        view('Admin/appointments');
    }

    public function approveCounselors() {
        view('Admin/approve-counselors');
    }

    public function reports() {
        view('Admin/reports');
    }

    public function donations() {
        view('Admin/donations');
    }

    public function awareness() {
        view('Admin/awareness');
    }

    public function monitoring() {
        view('Admin/monitoring');
    }

    public function settings() {
        view('Admin/settings');
    }

    public function profile() {
        view('Admin/profile');
    }
}