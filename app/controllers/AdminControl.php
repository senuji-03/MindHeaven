<?php
class AdminControl
{
    public function __construct()
    {
        // Enforce Admin Access
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index()
    {
        require_once BASE_PATH . '/app/models/User.php';
        $userModel = new User();
        $totalUsers = $userModel->getTotalCount();

        // This will load the main admin dashboard
        view('Admin/index', [
            'totalUsers' => $totalUsers
        ]);
    }

    public function manageUsers()
    {
        try {
            $pdo = Database::getConnection();

            // Get all users with their details (for general user management)
            $stmt = $pdo->prepare("
                SELECT u.id, u.username, u.role, u.account_status as status, u.strike_count, u.suspended_until, u.is_deleted,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.full_name
                           WHEN u.role = 'undergraduate' THEN us.full_name
                           ELSE u.username
                       END as display_name,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.full_name
                           WHEN u.role = 'undergraduate' THEN us.full_name
                           ELSE u.username
                       END as full_name,
                       u.email as email,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.phone_number
                           WHEN u.role = 'undergraduate' THEN us.phone_number
                           ELSE NULL
                       END as phone_number,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.created_at
                           WHEN u.role = 'undergraduate' THEN us.created_at
                           ELSE u.created_at
                       END as created_at
                FROM users u
                LEFT JOIN counselors c ON u.id = c.user_id AND u.role = 'counselor'
                LEFT JOIN undergraduate_students us ON u.id = us.user_id AND u.role = 'undergraduate'
                WHERE u.is_deleted = 0
                ORDER BY 
                    CASE 
                        WHEN u.role = 'counselor' THEN c.created_at
                        WHEN u.role = 'undergraduate' THEN us.created_at
                        ELSE u.id
                    END DESC
            ");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch undergraduate students separately
            $stmt = $pdo->prepare("
                SELECT u.*, us.*, us.full_name as display_name, u.email, us.phone_number, us.created_at
                FROM users u
                JOIN undergraduate_students us ON u.id = us.user_id
                WHERE u.role = 'undergraduate' AND u.is_deleted = 0
                ORDER BY us.created_at DESC
            ");
            $stmt->execute();
            $undergraduateStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch counselors separately
            $stmt = $pdo->prepare("
                SELECT u.*, c.*, c.full_name as display_name, u.email, c.phone_number, c.created_at
                FROM users u
                JOIN counselors c ON u.id = c.user_id
                WHERE u.role = 'counselor' AND u.is_deleted = 0
                ORDER BY c.created_at DESC
            ");
            $stmt->execute();
            $counselors = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch pending counselors (is_approved = 0)
            require_once BASE_PATH . '/app/models/Counselor.php';
            $counselorModel = new Counselor();
            $pendingCounselors = $counselorModel->getPending();

            view('Admin/manage-users', [
                'users' => $users,
                'undergraduateStudents' => $undergraduateStudents,
                'counselors' => $counselors,
                'pendingCounselors' => $pendingCounselors
            ]);
        } catch (Exception $e) {
            view('Admin/manage-users', [
                'users' => [],
                'undergraduateStudents' => [],
                'counselors' => [],
                'pendingCounselors' => [],
                'error' => 'Failed to load users: ' . $e->getMessage()
            ]);
        }
    }

    public function suspendedUsers()
    {
        try {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("
                SELECT u.id, u.username, u.email, u.suspended_until, u.strike_count, u.role,
                       CASE 
                           WHEN u.role = 'counselor' THEN c.full_name
                           WHEN u.role = 'undergraduate' THEN us.full_name
                           ELSE u.username
                       END as full_name
                FROM users u
                LEFT JOIN counselors c ON u.id = c.user_id AND u.role = 'counselor'
                LEFT JOIN undergraduate_students us ON u.id = us.user_id AND u.role = 'undergraduate'
                WHERE u.account_status = 'suspended' AND u.is_deleted = 0
                ORDER BY u.suspended_until ASC, u.id DESC
            ");
            $stmt->execute();
            $suspendedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            view('Admin/suspended-users', [
                'suspendedUsers' => $suspendedUsers
            ]);
        } catch (Exception $e) {
            view('Admin/suspended-users', [
                'suspendedUsers' => [],
                'error' => 'Failed to load suspended users: ' . $e->getMessage()
            ]);
        }
    }

    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/manage-users');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? '';

        $email = trim($_POST['email'] ?? '');
        if ($role === 'university_representative') {
            $role = 'university_representative'; // ensure it matches enum
            $username = $email;
            $password = substr(md5(uniqid()), 0, 8); // Temporary password
            $confirmPassword = $password;
        }

        $fullName = trim($_POST['full_name'] ?? '');
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
        } elseif (!in_array($role, ['admin', 'call_responder', 'counselor', 'donor', 'moderator', 'undergraduate', 'university_representative'])) {
            $errors[] = 'Invalid role selected';
        }

        if (empty($fullName)) {
            $errors[] = 'Full name is required';
        }

        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address';
        } elseif ($role !== 'university_representative' && !preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
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
                } elseif ($role === 'undergraduate') {
                    $stmt = $pdo->prepare("SELECT id FROM undergraduate_students WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        $errors[] = 'Email already exists';
                    }
                } elseif ($role === 'university_representative') {
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
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

            $passwordResetRequired = ($role === 'university_representative') ? 1 : 0;
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, email, status, account_status, password_reset_required) VALUES (?, ?, ?, ?, 'active', 'active', ?)");
            $stmt->execute([$username, $hashedPassword, $role, $email, $passwordResetRequired]);
            $userId = $pdo->lastInsertId();

            // Insert into role-specific table
            if ($role === 'counselor') {
                $licenseNumber = trim($_POST['license_number'] ?? '');
                $specialization = trim($_POST['specialization'] ?? '');
                $yearsExperience = !empty($_POST['years_experience']) ? (int) $_POST['years_experience'] : null;
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

                // Explicit schema mapping for counselor insert
                $stmt = $pdo->prepare("INSERT INTO counselors (user_id, full_name, phone_number, license_number, specialization, years_experience, bio, approved_by, approved_at) VALUES (?, ?, ?, ?, ?, ?, ?, NULL, NULL)");
                $stmt->execute([$userId, $fullName, $phoneNumber, $licenseNumber, $specialization, $yearsExperience, $bio]);
            } elseif ($role === 'undergraduate') {
                $stmt = $pdo->prepare("INSERT INTO undergraduate_students (user_id, full_name, phone_number) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $fullName, $phoneNumber]);
            } elseif ($role === 'university_representative') {
                $universityName = trim($_POST['university_name'] ?? '');
                $position = trim($_POST['position'] ?? 'University Representative');

                if (empty($universityName)) {
                    throw new Exception("University name is required for University Representative.");
                }

                $stmt = $pdo->prepare("SELECT id FROM universities WHERE name = ?");
                $stmt->execute([$universityName]);
                $universityId = $stmt->fetchColumn();

                if (!$universityId) {

                    $baseShortName = strtoupper(preg_replace('/[^A-Za-z0-9]+/', '_', $universityName));
                    $baseShortName = trim($baseShortName, '_');

                    if ($baseShortName === '') {
                        $baseShortName = 'UNI';
                    }

                    $shortName = $baseShortName;
                    $i = 1;

                    $checkStmt = $pdo->prepare("SELECT id FROM universities WHERE short_name = ?");

                    while (true) {
                        $checkStmt->execute([$shortName]);
                        if (!$checkStmt->fetchColumn()) {
                            break;
                        }
                        $shortName = $baseShortName . '_' . $i;
                        $i++;
                    }

                    $baseDomain = strtolower(preg_replace('/[^a-z0-9]+/', '-', $universityName));
                    $baseDomain = trim($baseDomain, '-');

                    if ($baseDomain === '') {
                        $baseDomain = 'university';
                    }

                    $domain = $baseDomain . '.local';
                    $d = 1;

                    $checkDomainStmt = $pdo->prepare("SELECT id FROM universities WHERE domain = ?");

                    while (true) {
                        $checkDomainStmt->execute([$domain]);
                        if (!$checkDomainStmt->fetchColumn()) {
                            break;
                        }
                        $domain = $baseDomain . '-' . $d . '.local';
                        $d++;
                    }

                    $stmt = $pdo->prepare("INSERT INTO universities (name, short_name, domain) VALUES (?, ?, ?)");
                    $stmt->execute([$universityName, $shortName, $domain]);

                    $universityId = $pdo->lastInsertId();
                }

                $stmt = $pdo->prepare("INSERT INTO university_representatives (user_id, university_id, position) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $universityId, $position]);

                $_SESSION['temp_username'] = $username;
                $_SESSION['temp_password'] = $password;
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

    public function updateUser()
    {
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
            if ($role === 'university_representative') {
                // Ignore email change for university rep
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
                    $stmt->execute([$username, $hashedPassword, $userId]);
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
                    $stmt->execute([$username, $userId]);
                }
            } else {
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
                    $stmt->execute([$username, $email, $hashedPassword, $userId]);
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
                    $stmt->execute([$username, $email, $userId]);
                }
            }

            // Update role-specific table
            if ($role === 'counselor') {
                $licenseNumber = trim($_POST['license_number'] ?? '');
                $specialization = trim($_POST['specialization'] ?? '');
                $yearsExperience = !empty($_POST['years_experience']) ? (int) $_POST['years_experience'] : null;
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

                // Explicit mapping for counselor update
                $stmt = $pdo->prepare("UPDATE counselors SET full_name = ?, phone_number = ?, license_number = ?, specialization = ?, years_experience = ?, bio = ? WHERE user_id = ?");
                $stmt->execute([$fullName, $phoneNumber, $licenseNumber, $specialization, $yearsExperience, $bio, $userId]);
            } elseif ($role === 'undergraduate') {
                $stmt = $pdo->prepare("UPDATE undergraduate_students SET full_name = ?, phone_number = ? WHERE user_id = ?");
                $stmt->execute([$fullName, $phoneNumber, $userId]);
            } elseif ($role === 'university_representative') {
                $universityId = $_POST['university_id'] ?? null;
                $position = trim($_POST['position'] ?? 'University Representative');

                if ($universityId) {
                    $stmt = $pdo->prepare("UPDATE university_representatives SET university_id = ?, position = ? WHERE user_id = ?");
                    $stmt->execute([$universityId, $position, $userId]);
                }
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

    public function deleteUser()
    {
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
            require_once BASE_PATH . '/app/models/User.php';
            $userModel = new User();
            $userModel->softDelete($userId);

            header('Location: ' . BASE_URL . '/admin/manage-users?success=User deleted successfully');
            exit;

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to delete user: ' . $e->getMessage());
            exit;
        }
    }

    public function activateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? '';
            if ($userId) {
                require_once BASE_PATH . '/app/models/User.php';
                $userModel = new User();
                $userModel->activate($userId);
                header('Location: ' . BASE_URL . '/admin/manage-users?success=User activated');
                exit;
            }
        }
        header('Location: ' . BASE_URL . '/admin/manage-users');
    }

    public function deactivateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? '';
            if ($userId) {
                require_once BASE_PATH . '/app/models/User.php';
                $userModel = new User();
                $userModel->deactivate($userId);
                header('Location: ' . BASE_URL . '/admin/manage-users?success=User deactivated');
                exit;
            }
        }
        header('Location: ' . BASE_URL . '/admin/manage-users');
    }

    public function unsuspendUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? '';
            if ($userId) {
                require_once BASE_PATH . '/app/models/User.php';
                $userModel = new User();
                $userModel->unsuspendUser($userId);
                // Check referer to return to suspended users page if we came from there
                $referer = $_SERVER['HTTP_REFERER'] ?? '';
                if (strpos($referer, 'suspended-users') !== false) {
                    header('Location: ' . BASE_URL . '/admin/suspended-users?success=User unsuspended');
                } else {
                    header('Location: ' . BASE_URL . '/admin/manage-users?success=User unsuspended');
                }
                exit;
            }
        }
        header('Location: ' . BASE_URL . '/admin/manage-users');
    }

    public function resetUserStrikes()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? '';
            if ($userId) {
                require_once BASE_PATH . '/app/models/User.php';
                $userModel = new User();
                $userModel->resetStrikes($userId);
                header('Location: ' . BASE_URL . '/admin/manage-users?success=Strikes reset to 0');
                exit;
            }
        }
        header('Location: ' . BASE_URL . '/admin/manage-users');
    }

    public function resourceHub()
    {
        view('Admin/resource-hub');
    }

    public function moderateForum()
    {
        require_once BASE_PATH . '/app/models/Report.php';
        require_once BASE_PATH . '/app/models/Thread.php';

        $reportModel = new Report();
        $threadModel = new Thread();

        // Fetch pending reports
        $reports = $reportModel->getAll('pending');

        $db = Database::getConnection();

        // Enrich reports with content details
        foreach ($reports as &$report) {
            $report['content_title'] = 'Unknown/Deleted Content';
            $report['content_snippet'] = 'Content could not be loaded.';
            $report['full_content'] = '';
            $report['context_url'] = null;

            if ($report['content_type'] === 'thread') {
                $content = $threadModel->getById($report['content_id']);
                if ($content) {
                    $report['content_title'] = 'Thread: ' . ($content['title'] ?? 'Deleted Content');
                    $report['content_snippet'] = substr($content['description'] ?? '', 0, 100);
                    $report['full_content'] = $content['description'] ?? '';
                    $report['context_url'] = BASE_URL . '/forum/thread/' . $content['id'];
                }
            } elseif (in_array($report['content_type'], ['post', 'reply', 'reply_reply'])) {
                $content = $threadModel->getPostById($report['content_id']);
                if ($content) {
                    $report['content_title'] = 'Reported ' . ucfirst($report['content_type']);
                    $report['content_snippet'] = substr($content['content'] ?? '', 0, 100);
                    $report['full_content'] = $content['content'] ?? '';
                    $report['context_url'] = BASE_URL . '/forum/thread/' . $content['thread_id'] . '#post-' . $content['id'];
                }
            }
        }

        // Fetch pending system flags
        require_once BASE_PATH . '/app/models/SystemFlag.php';
        $systemFlagModel = new SystemFlag();
        $systemFlags = $systemFlagModel->getAll('pending');

        // Enrich system flags with content details
        foreach ($systemFlags as &$flag) {
            if (empty($flag['content_type'])) {
                $stmt = $db->prepare("SELECT id FROM forum_posts WHERE id = ?");
                $stmt->execute([$flag['content_id']]);
                if ($stmt->fetchColumn()) {
                    $flag['content_type'] = 'post';
                } else {
                    $stmt = $db->prepare("SELECT id FROM forum_threads WHERE id = ?");
                    $stmt->execute([$flag['content_id']]);
                    if ($stmt->fetchColumn()) {
                        $flag['content_type'] = 'thread';
                    }
                }
            }

            $flag['content_title'] = 'Unknown/Deleted Content';
            $flag['content_snippet'] = 'Content could not be loaded.';
            $flag['full_content'] = '';
            $flag['context_url'] = null;

            $typeToCheck = $flag['content_type'] ?? '';

            if ($typeToCheck === 'thread') {
                $content = $threadModel->getById($flag['content_id']);
                if ($content) {
                    $flag['content_title'] = 'Thread: ' . ($content['title'] ?? 'Deleted Content');
                    $flag['content_snippet'] = substr($content['description'] ?? '', 0, 100);
                    $flag['full_content'] = $content['description'] ?? '';
                    $flag['context_url'] = BASE_URL . '/forum/thread/' . $content['id'];
                }
            } elseif (in_array($typeToCheck, ['post', 'reply', 'reply_reply'])) {
                $content = $threadModel->getPostById($flag['content_id']);
                if ($content) {
                    $flag['content_title'] = 'Flagged ' . ucfirst($typeToCheck);
                    $flag['content_snippet'] = substr($content['content'] ?? '', 0, 100);
                    $flag['full_content'] = $content['content'] ?? '';
                    $flag['context_url'] = BASE_URL . '/forum/thread/' . $content['thread_id'] . '#post-' . $content['id'];
                }
            }
        }

        view('Admin/moderate-forum', [
            'reports' => $reports,
            'systemFlags' => $systemFlags
        ]);
    }

    public function counselors()
    {
        view('Admin/counselors');
    }

    public function appointments()
    {
        view('Admin/appointments');
    }

    public function approveCounselors()
    {
        view('Admin/approve-counselors');
    }

    public function reports()
    {
        require_once BASE_PATH . '/app/models/Report.php';
        $reportModel = new Report();

        $status = $_GET['status'] ?? 'pending';
        $reports = $reportModel->getAll($status);
        $categories = $reportModel->getCategories();

        view('Admin/reports', [
            'reports' => $reports,
            'categories' => $categories,
            'currentStatus' => $status
        ]);
    }

    public function updateReportStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/reports');
            exit;
        }

        $reportId = $_POST['report_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($reportId && $status) {
            require_once BASE_PATH . '/app/models/Report.php';
            $reportModel = new Report();

            // If resolving and delete content is requested
            if ($status === 'resolved' && isset($_POST['delete_content']) && $_POST['delete_content'] == 1) {
                // Fetch report to get content info
                $report = $reportModel->getById($reportId);
                if ($report) {
                    require_once BASE_PATH . '/app/models/Thread.php';
                    require_once BASE_PATH . '/app/models/User.php'; // Require User model
                    $threadModel = new Thread();
                    $userModel = new User();

                    if ($report['content_type'] === 'thread') {
                        $threadModel->delete($report['content_id']);
                    } elseif ($report['content_type'] === 'post' || $report['content_type'] === 'reply') {
                        $threadModel->deletePost($report['content_id']);
                    }

                    // Add strike to content owner if not already given for this report
                    if (empty($report['strike_given']) && !empty($report['content_owner_id'])) {
                        $userModel->addStrike($report['content_owner_id']);
                        $reportModel->markStrikeGiven($reportId);
                    }
                }
            }

            $reportModel->updateStatus($reportId, $status);
            $_SESSION['success'] = "Report updated successfully.";
        }

        header('Location: ' . BASE_URL . '/admin/moderate-forum?tab=queue');
        exit;
    }

    public function updateSystemFlagStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/moderate-forum');
            exit;
        }

        $flagId = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($flagId && $status) {
            require_once BASE_PATH . '/app/models/SystemFlag.php';
            $flagModel = new SystemFlag();

            if ($status === 'resolved' && isset($_POST['delete_content']) && $_POST['delete_content'] == 1) {
                // Fetch flag to get content info
                $sql = "SELECT * FROM system_flags WHERE id = ?";
                $db = Database::getConnection();
                $stmt = $db->prepare($sql);
                $stmt->execute([$flagId]);
                $flag = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($flag) {
                    require_once BASE_PATH . '/app/models/Thread.php';
                    require_once BASE_PATH . '/app/models/User.php';
                    $threadModel = new Thread();
                    $userModel = new User();

                    if ($flag['content_type'] === 'thread') {
                        $threadModel->delete($flag['content_id']);
                    } elseif ($flag['content_type'] === 'post' || $flag['content_type'] === 'reply' || $flag['content_type'] === 'reply_reply') {
                        $threadModel->deletePost($flag['content_id']);
                    }

                    if (!empty($flag['user_id'])) {
                        $userModel->addStrike($flag['user_id']);
                    }
                }
            }

            $flagModel->updateStatus($flagId, $status);
            $_SESSION['success'] = "Automated flag updated successfully.";
        }

        header('Location: ' . BASE_URL . '/admin/moderate-forum?tab=auto-flags');
        exit;
    }

    public function editReportedContent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/reports');
            exit;
        }

        $reportId = $_POST['report_id'] ?? null;
        $flagId = $_POST['flag_id'] ?? null;
        $content = $_POST['content'] ?? '';
        $postId = $_POST['post_id'] ?? null;

        if ($postId && $content) {
            require_once BASE_PATH . '/app/models/Thread.php';
            $threadModel = new Thread();

            // Update the post content marked as edited by Admin
            if ($threadModel->updatePost($postId, $content, 'Admin')) {
                $_SESSION['success'] = "Content edited successfully.";

                // If report ID is provided, optionally resolve it or keep it pending
                if ($reportId) {
                    require_once BASE_PATH . '/app/models/Report.php';
                    $reportModel = new Report();
                    $reportModel->updateStatus($reportId, 'reviewed');
                }

                // If it's a system flag, mark as reviewed
                if ($flagId) {
                    require_once BASE_PATH . '/app/models/SystemFlag.php';
                    $flagModel = new SystemFlag();
                    $flagModel->updateStatus($flagId, 'reviewed');
                }
            } else {
                $_SESSION['error'] = "Failed to edit content.";
            }
        }

        // Redirect back to where we came from (likely moderate-forum or reports)
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'moderate-forum') !== false) {
            header('Location: ' . BASE_URL . '/admin/moderate-forum');
        } else {
            header('Location: ' . BASE_URL . '/admin/reports');
        }
        exit;
    }

    public function suspendUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/manage-users');
            exit;
        }

        $userId = $_POST['user_id'] ?? null;
        $suspensionDays = $_POST['suspension_days'] ?? null; // Optional duration

        if ($userId) {
            require_once BASE_PATH . '/app/models/User.php';
            $userModel = new User();

            try {
                $until = null;
                if ($suspensionDays) {
                    $until = date('Y-m-d H:i:s', strtotime("+$suspensionDays days"));
                }

                $userModel->suspendUser($userId, $until);

                $_SESSION['success'] = "User suspended successfully.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to suspend user: " . $e->getMessage();
            }
        }

        // Redirect back to reports if that's where we came from
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'reports') !== false) {
            header('Location: ' . BASE_URL . '/admin/reports');
        } elseif (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'moderate-forum') !== false) {
            // Also handle moderate-forum redirect
            header('Location: ' . BASE_URL . '/admin/moderate-forum');
        } else {
            header('Location: ' . BASE_URL . '/admin/manage-users');
        }
        exit;
    }

    public function donations()
    {
        view('Admin/donations');
    }

    public function awareness()
    {
        view('Admin/awareness');
    }

    public function monitoring()
    {
        view('Admin/monitoring');
    }

    public function settings()
    {
        view('Admin/settings');
    }

    public function profile()
    {
        view('Admin/profile');
    }

    // Report Categories Management
    public function manageReportCategories()
    {
        require_once BASE_PATH . '/app/models/Report.php';
        $reportModel = new Report();
        $categories = $reportModel->getAllCategories(true); // Include inactive

        view('Admin/customize-forum-categories', [
            'categories' => $categories,
            'mode' => 'report'
        ]);
    }

    public function createReportCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/report-categories');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] = "Category name is required.";
        } else {
            require_once BASE_PATH . '/app/models/Report.php';
            $reportModel = new Report();
            if ($reportModel->addCategory($name, $description)) {
                $_SESSION['success'] = "Category created successfully.";
            } else {
                $_SESSION['error'] = "Failed to create category.";
            }
        }

        header('Location: ' . BASE_URL . '/admin/report-categories');
        exit;
    }

    public function updateReportCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/report-categories');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (!$id || empty($name)) {
            $_SESSION['error'] = "Invalid data provided.";
        } else {
            require_once BASE_PATH . '/app/models/Report.php';
            $reportModel = new Report();
            if ($reportModel->updateCategory($id, $name, $description)) {
                $_SESSION['success'] = "Category updated successfully.";
            } else {
                $_SESSION['error'] = "Failed to update category.";
            }
        }

        header('Location: ' . BASE_URL . '/admin/report-categories');
        exit;
    }

    public function deleteReportCategory()
    {
        // This is actually a soft delete / deactivation
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/report-categories');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if ($id) {
            require_once BASE_PATH . '/app/models/Report.php';
            $reportModel = new Report();
            if ($reportModel->deleteCategory($id)) {
                $_SESSION['success'] = "Category deactivated successfully.";
            } else {
                $_SESSION['error'] = "Failed to deactivate category.";
            }
        }

        header('Location: ' . BASE_URL . '/admin/report-categories');
        exit;
    }

    public function activateReportCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/report-categories');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if ($id) {
            require_once BASE_PATH . '/app/models/Report.php';
            $reportModel = new Report();
            if ($reportModel->activateCategory($id)) {
                $_SESSION['success'] = "Category reactivated successfully.";
            } else {
                $_SESSION['error'] = "Failed to reactivate category.";
            }
        }

        header('Location: ' . BASE_URL . '/admin/report-categories');
        exit;
    }

    public function universityEvents()
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("
                SELECT e.*, u.name as university_name, u_rep.username as rep_email
                FROM university_rep_events e
                LEFT JOIN university_representatives ur ON e.university_rep_id = ur.user_id
                LEFT JOIN universities u ON ur.university_id = u.id
                LEFT JOIN users u_rep ON ur.user_id = u_rep.id
                ORDER BY e.status ASC, u.name ASC, e.created_at DESC
            ");
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Group by status, then by university
            $groupedEvents = [
                'pending' => [],
                'approved' => [],
                'rejected' => []
            ];

            foreach ($events as $event) {
                $status = $event['status'];
                $uniName = $event['university_name'] ?? 'Unknown University';
                if (!isset($groupedEvents[$status])) {
                    $groupedEvents[$status] = [];
                }
                if (!isset($groupedEvents[$status][$uniName])) {
                    $groupedEvents[$status][$uniName] = [];
                }
                $groupedEvents[$status][$uniName][] = $event;
            }

            view('Admin/university-events', [
                'groupedEvents' => $groupedEvents
            ]);
        } catch (Exception $e) {
            $_SESSION['error'] = 'Failed to load events: ' . $e->getMessage();
            view('Admin/university-events', [
                'groupedEvents' => ['pending' => [], 'approved' => [], 'closed' => []]
            ]);
        }
    }

    public function approveUniversityEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/university-events');
            exit;
        }

        $eventId = $_POST['event_id'] ?? null;

        if ($eventId) {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("UPDATE university_rep_events SET status = 'approved', updated_at = CURRENT_TIMESTAMP WHERE id = ? AND status IN ('pending', 'rejected')");
                $stmt->execute([$eventId]);
                $_SESSION['success'] = 'Event approved successfully.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Failed to approve event: ' . $e->getMessage();
            }
        }

        header('Location: ' . BASE_URL . '/admin/university-events');
        exit;
    }

    public function rejectUniversityEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/university-events');
            exit;
        }

        $eventId = $_POST['event_id'] ?? null;

        if ($eventId) {
            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("UPDATE university_rep_events SET status = 'rejected', updated_at = CURRENT_TIMESTAMP WHERE id = ? AND status = 'pending'");
                $stmt->execute([$eventId]);
                $_SESSION['success'] = 'Event rejected successfully.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Failed to reject event: ' . $e->getMessage();
            }
        }

        header('Location: ' . BASE_URL . '/admin/university-events');
        exit;
    }

    // -------------------------------------------------------
    // Forum Thread Category Management (forum_categories table)
    // NOT to be confused with report_categories
    // -------------------------------------------------------

    public function forumCategories()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT id, name, description, is_active, sort_order FROM forum_categories ORDER BY sort_order ASC, id ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        view('admin/customize-forum-categories', [
            'categories' => $categories,
            'mode' => 'forum'
        ]);
    }

    public function createForumCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if (empty($name)) {
            $_SESSION['error'] = 'Category name is required.';
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO forum_categories (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
        $_SESSION['success'] = 'Forum category created.';
        header('Location: ' . BASE_URL . '/admin/forum-categories');
        exit;
    }

    public function updateForumCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if (!$id || empty($name)) {
            $_SESSION['error'] = 'Invalid request.';
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE forum_categories SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
        $_SESSION['success'] = 'Forum category updated.';
        header('Location: ' . BASE_URL . '/admin/forum-categories');
        exit;
    }

    public function deleteForumCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $id = (int) ($_POST['id'] ?? 0);
        if (!$id) {
            $_SESSION['error'] = 'Invalid request.';
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $pdo = Database::getConnection();
        $pdo->prepare("UPDATE forum_categories SET is_active = 0 WHERE id = ?")->execute([$id]);
        $_SESSION['success'] = 'Forum category deactivated.';
        header('Location: ' . BASE_URL . '/admin/forum-categories');
        exit;
    }

    public function activateForumCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $id = (int) ($_POST['id'] ?? 0);
        if (!$id) {
            $_SESSION['error'] = 'Invalid request.';
            header('Location: ' . BASE_URL . '/admin/forum-categories');
            exit;
        }
        $pdo = Database::getConnection();
        $pdo->prepare("UPDATE forum_categories SET is_active = 1 WHERE id = ?")->execute([$id]);
        $_SESSION['success'] = 'Forum category reactivated.';
        header('Location: ' . BASE_URL . '/admin/forum-categories');
        exit;
    }

    /**
     * Get pending counselors for approval
     */
    public function getPendingCounselors()
    {
        try {
            require_once BASE_PATH . '/app/models/Counselor.php';
            $counselorModel = new Counselor();
            $pendingCounselors = $counselorModel->getPending();

            return $pendingCounselors;
        } catch (Exception $e) {
            error_log("AdminControl getPendingCounselors error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Approve a counselor
     */
    public function approveCounselor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/manage-users');
            exit;
        }

        $counselorId = $_POST['counselor_id'] ?? '';
        $adminId = $_SESSION['user_id'];

        if (empty($counselorId) || !is_numeric($counselorId)) {
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Invalid counselor ID');
            exit;
        }

        try {
            $pdo = Database::getConnection();
            $pdo->beginTransaction();

            require_once BASE_PATH . '/app/models/Counselor.php';
            $counselorModel = new Counselor();



            // Mark counselor as approved in counselors table
            $result = $counselorModel->approve($counselorId, $adminId);

            if ($result) {
                // Also activate the user account so they can log in
                $stmt = $pdo->prepare("
                    UPDATE users 
                    SET account_status = 'active', status = 'active', is_active = 1
                    WHERE id = ?
                ");
                $stmt->execute([$counselorId]);
                $pdo->commit();
                header('Location: ' . BASE_URL . '/admin/manage-users?success=Counselor approved and account activated');
            } else {
                $pdo->rollBack();
                header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to approve counselor');
            }
            exit;

        } catch (Exception $e) {
            if (isset($pdo))
                $pdo->rollBack();
            error_log("AdminControl approveCounselor error: " . $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to approve counselor: ' . urlencode($e->getMessage()));
            exit;
        }
    }

    /**
     * Reject a counselor
     */
    public function rejectCounselor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/manage-users');
            exit;
        }

        $counselorId = $_POST['counselor_id'] ?? '';
        $reason = trim($_POST['reason'] ?? '');

        if (empty($counselorId) || !is_numeric($counselorId)) {
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Invalid counselor ID');
            exit;
        }

        try {
            $pdo = Database::getConnection();

            // Mirror status and account_status deactivation
            $stmt = $pdo->prepare("UPDATE users u 
                                  JOIN counselors c ON u.id = c.user_id 
                                  SET u.status = 'inactive', u.account_status = 'inactive', c.is_active = 0 
                                  WHERE c.user_id = ?");
            $result = $stmt->execute([$counselorId]);

            if ($result) {
                header('Location: ' . BASE_URL . '/admin/manage-users?success=Counselor rejected and account deactivated');
            } else {
                header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to reject counselor');
            }
            exit;

        } catch (Exception $e) {
            error_log("AdminControl rejectCounselor error: " . $e->getMessage());
            header('Location: ' . BASE_URL . '/admin/manage-users?error=Failed to reject counselor');
            exit;
        }
    }
    /**
     * API: Get all appointments for Admin dashboard
     */
    public function getAppointments()
    {
        header('Content-Type: application/json');

        try {
            require_once BASE_PATH . '/app/models/Appointment.php';
            $appointmentModel = new Appointment();

            $appointments = $appointmentModel->getAllForAdmin();
            $stats = $appointmentModel->getAdminStats();

            echo json_encode([
                'success' => true,
                'appointments' => $appointments,
                'stats' => $stats
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to fetch appointments: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}
