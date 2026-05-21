<?php

class UGControl
{

    public function __construct()
    {
        // Session is already started in index.php, no need to start again
        // Protect all undergrad routes
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'undergraduate') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        
        // Add security headers to prevent caching and back-button access
        Auth::setSecurityHeaders();
    }
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? 0;

        // Fetch Habit Stats
        require_once BASE_PATH . '/app/models/Habit.php';
        require_once BASE_PATH . '/app/models/Notification.php';
        $habitDb = new Habit();
        $notifDb = new Notification();
        $habitStats = $habitDb->getStats($userId);

        // Daily Reminder Logic (10 AM)
        $currentHour = (int)date('H');
        if ($currentHour >= 10) {
            $pending = $habitDb->getIncompleteHabitsForToday($userId);
            if (!empty($pending)) {
                // Check if reminder was already sent today
                $today = date('Y-m-d');
                $stmtRem = Database::getConnection()->prepare("
                    SELECT COUNT(*) FROM notifications 
                    WHERE user_id = ? AND type = 'habit_reminder' 
                    AND DATE(created_at) = ?
                ");
                $stmtRem->execute([$userId, $today]);
                if ((int)$stmtRem->fetchColumn() === 0) {
                    $notifDb->create($userId, "Friendly reminder: You have ".count($pending)." habits to complete today! 🎯", 'habit_reminder');
                }
            }
        }

        $pdo = Database::getConnection();

        // Fetch Today's Current Mood
        $stmt = $pdo->prepare("SELECT mood_type, mood_level, created_at FROM mood_records WHERE user_id = ? AND DATE(created_at) = CURDATE() ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$userId]);
        $currentMood = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch Next Appointment
        $stmt = $pdo->prepare("
            SELECT a.*, COALESCE(c.full_name, u.username) as counselor_name 
            FROM appointments a 
            LEFT JOIN counselors c ON a.counselor_user_id = c.user_id 
            LEFT JOIN users u ON a.counselor_user_id = u.id
            WHERE a.student_user_id = ? 
              AND a.status IN ('scheduled', 'confirmed', 'accept', 'accepted') 
              AND (a.date > CURDATE() OR (a.date = CURDATE() AND a.time >= CURTIME())) 
            ORDER BY a.date ASC, a.time ASC LIMIT 1
        ");
        $stmt->execute([$userId]);
        $nextAppointment = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch user name
        $stmt = $pdo->prepare("SELECT COALESCE(us.full_name, u.username) as student_name FROM users u LEFT JOIN undergraduate_students us ON u.id = us.user_id WHERE u.id = ?");
        $stmt->execute([$userId]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $studentName = $userData['student_name'] ?? 'Student';

        // Fetch Analytics Chart Data (Last 7 Days)
        $habitChartData = ['labels' => [], 'data' => []];
        $moodChartData = ['labels' => [], 'data' => []];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dayLabel = date('D', strtotime($date));
            $habitChartData['labels'][] = $dayLabel;
            $moodChartData['labels'][] = $dayLabel;
            
            // Mood query
            $stmt = $pdo->prepare("SELECT AVG(mood_level) FROM mood_records WHERE user_id = ? AND DATE(created_at) = ?");
            $stmt->execute([$userId, $date]);
            $avgMood = $stmt->fetchColumn();
            $moodChartData['data'][] = $avgMood ? round((float)$avgMood, 1) : 0;
            
            // Habit query
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_completions WHERE user_id = ? AND completion_date = ?");
            $stmt->execute([$userId, $date]);
            $completedCount = $stmt->fetchColumn();
            $habitChartData['data'][] = (int)$completedCount;
        }

        view('undergrad/home', [
            'habitStats' => $habitStats,
            'currentMood' => $currentMood,
            'nextAppointment' => $nextAppointment,
            'studentName' => $studentName,
            'habitChartData' => $habitChartData,
            'moodChartData' => $moodChartData
        ]);
    }
    public function appointment()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT c.*, u.username,
                   AVG(f.rating) as avg_rating,
                   GROUP_CONCAT(DISTINCT CONCAT(cq.title, ' at ', cq.institution) SEPARATOR ' • ') as qualifications,
                   (
                       SELECT GROUP_CONCAT(CONCAT(slot_date, '|', TIME_FORMAT(start_time, '%H:%i')) ORDER BY slot_date, start_time ASC SEPARATOR ';')
                       FROM counselor_timeslots
                       WHERE counselor_user_id = u.id AND is_booked = 0 AND is_frozen = 0 
                         AND (slot_date > CURDATE() OR (slot_date = CURDATE() AND start_time >= CURTIME()))
                   ) as available_slots
            FROM counselors c
            INNER JOIN users u ON c.user_id = u.id
            LEFT JOIN feedback f ON c.id = f.counselor_id
            LEFT JOIN counselor_qualifications cq ON c.id = cq.counselor_id
            WHERE u.role = 'counselor' AND u.account_status = 'active'
            GROUP BY c.id, u.username, u.id
            ORDER BY c.full_name
        ");
        $stmt->execute();
        $counselors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        view('undergrad/appointments', ['counselors' => $counselors]);
    }
    public function contact()
    {
        view('undergrad/contact');
    }
    public function crisis()
    {
        view('undergrad/crisis');
    }
    public function mood()
    {
        view('undergrad/mood');
    }

    public function journal()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $pdo = Database::getConnection();

        // Fetch User Info (including Full Name)
        $stmt = $pdo->prepare("
            SELECT u.username, us.full_name 
            FROM users u
            LEFT JOIN undergraduate_students us ON u.id = us.user_id
            WHERE u.id = ?
        ");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch Habit Stats
        require_once BASE_PATH . '/app/models/Habit.php';
        $habitDb = new Habit();
        $habitStats = $habitDb->getStats($userId);

        // Fetch Today's Mood
        $stmtMood = $pdo->prepare("SELECT mood_type FROM mood_records WHERE user_id = ? AND DATE(created_at) = CURDATE() ORDER BY created_at DESC LIMIT 1");
        $stmtMood->execute([$userId]);
        $todayMood = $stmtMood->fetchColumn();

        // Daily Mental Health Quotes
        $quotes = [
            "Your mental health is a priority. Your happiness is essential. Your self-care is a necessity.",
            "You don't have to see the whole staircase, just take the first step.",
            "Believe in yourself and all that you are. Know that there is something inside you that is greater than any obstacle.",
            "It’s okay to not be okay as long as you are not giving up.",
            "Self-care is how you take your power back.",
            "One small crack does not mean that you are broken, it means that you were put to the test and you didn't fall apart.",
            "The only way out is through, and the only way through is together.",
            "Be patient with yourself. Self-growth is tender; it's holy ground. There's no greater investment."
        ];
        // Select a quote based on the day of the year
        $dayOfYear = (int)date('z');
        $dailyQuote = $quotes[$dayOfYear % count($quotes)];

        // Fetch Real Journal Entries
        require_once BASE_PATH . '/app/models/Journal.php';
        $journalDb = new Journal();
        $entries = $journalDb->getByUser($userId);

        view('undergrad/journal', [
            'currentUser' => $user,
            'habitStats' => $habitStats,
            'todayMood' => $todayMood,
            'dailyQuote' => $dailyQuote, // Pass quote to view
            'initialEntries' => $entries
        ]);
    }

    public function saveJournal()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        try {
            require_once BASE_PATH . '/app/models/Journal.php';
            $journalDb = new Journal();
            $userId = $_SESSION['user_id'];
            
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
            $data = [
                'user_id' => $userId,
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'mood_tag' => $_POST['mood_tag'] ?? 'neutral',
                'category_tags' => $_POST['category_tags'] ?? '',
                'gratitude' => trim($_POST['gratitude'] ?? ''),
                'highlight' => trim($_POST['highlight'] ?? '')
            ];

            if ($id) {
                $journalDb->update($id, $userId, $data);
                $response = ['status' => 'success', 'message' => 'Entry updated', 'id' => $id];
            } else {
                $newId = $journalDb->create($data);
                $response = ['status' => 'success', 'message' => 'Entry created', 'id' => $newId];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            exit;
        }
    }

    public function deleteJournal()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        try {
            require_once BASE_PATH . '/app/models/Journal.php';
            $journalDb = new Journal();
            $userId = $_SESSION['user_id'];
            $id = (int)$_POST['id'];

            if ($journalDb->delete($id, $userId)) {
                $response = ['status' => 'success', 'message' => 'Entry deleted'];
            } else {
                $response = ['status' => 'error', 'message' => 'Delete failed'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            exit;
        }
    }
    public function resources()
    {
        try {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();

            // Get all published resources
            $allResources = $resourceHub->getAll('published');

            // Group resources by category
            $resourcesByCategory = array();
            foreach ($allResources as $resource) {
                $category = $resource['category'];
                if (!isset($resourcesByCategory[$category])) {
                    $resourcesByCategory[$category] = array();
                }
                $resourcesByCategory[$category][] = $resource;
            }

            // Get resource statistics
            $stats = $resourceHub->getStats();

            // Fetch dynamic categories from the database
            $categories = $resourceHub->getCategories();

            // Add last updated timestamp for debugging
            $lastUpdated = date('Y-m-d H:i:s');

            view('undergrad/resources', array(
                'resources' => $allResources,
                'resourcesByCategory' => $resourcesByCategory,
                'categories' => $categories,
                'stats' => $stats,
                'lastUpdated' => $lastUpdated,
                'categoryBaseUrl' => BASE_URL . '/ug/category-resources'
            ));
        } catch (Exception $e) {
            // Log the error for debugging
            error_log("ResourceHub Error: " . $e->getMessage());

            // Fallback to static view if database fails
            view('undergrad/resources', array(
                'resources' => array(),
                'resourcesByCategory' => array(),
                'categories' => array(),
                'stats' => array('total_resources' => 0, 'published' => 0),
                'error' => $e->getMessage(),
                'lastUpdated' => date('Y-m-d H:i:s'),
                'categoryBaseUrl' => BASE_URL . '/ug/category-resources'
            ));
        }
    }



    public function categoryResources()
    {
        try {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();

            // Get category from URL parameter
            $category = $_GET['category'] ?? '';
            if (empty($category)) {
                header('Location: ' . BASE_URL . '/ug/resources');
                exit;
            }

            // Get all published resources for this category
            $categoryResources = $resourceHub->getByCategory($category, 'published');

            // Get user likes
            $userLikes = [];
            if (isset($_SESSION['user_id'])) {
                $userLikes = $resourceHub->getUserLikes($_SESSION['user_id']);
            }

            // Get all categories for navigation
            $allResources = $resourceHub->getAll('published');
            
            // Debug: Log resource counts
            error_log("Category: $category, Resources found: " . count($categoryResources));
            error_log("Total published resources: " . count($allResources));
            $allCategories = [];
            foreach ($allResources as $resource) {
                $cat = $resource['category'];
                if (!isset($allCategories[$cat])) {
                    $allCategories[$cat] = count(array_filter($allResources, function ($r) use ($cat) {
                        return $r['category'] === $cat;
                    }));
                }
            }

            $categoriesList = $resourceHub->getCategories();
            $categoryInfo = [];
            foreach ($categoriesList as $cat) {
                $categoryInfo[$cat['name']] = ['description' => $cat['description']];
            }
            // Use a default description if category is not found in the list
            $currentCategoryInfo = $categoryInfo[$category] ?? ['description' => 'Resources for ' . $category];
            
            // Group resources by content type for better organization
            $resourcesByType = [
                'article' => [],
                'video' => [],
                'audio' => []
            ];
            
            foreach ($categoryResources as $resource) {
                $contentType = $resource['content_type'];
                if (isset($resourcesByType[$contentType])) {
                    $resourcesByType[$contentType][] = $resource;
                }
            }
            

            view('undergrad/category-resources', [
                'category' => $category,
                'categoryInfo' => $currentCategoryInfo,
                'resources' => $categoryResources,
                'resourcesByType' => $resourcesByType,
                'allCategories' => $allCategories,
                'totalResources' => count($categoryResources),
                'userLikes' => $userLikes,
                'categoryBaseUrl' => BASE_URL . '/ug/category-resources',
                'backUrl' => BASE_URL . '/ug/resources',
                'viewUrl' => BASE_URL . '/ug/viewResource',
                'likeUrl' => BASE_URL . '/ug/likeResource'
            ]);

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/ug/resources?error=category_not_found');
            exit;
        }
    }
    public function likeResource()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['resource_id'])) {
                require_once BASE_PATH . '/app/models/ResourceHub.php';
                $resourceHub = new ResourceHub();
                $result = $resourceHub->toggleLike($input['resource_id'], $_SESSION['user_id']);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'action' => $result['action']]);
                exit;
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
        exit;
    }

    public function viewResource()
    {
        if (!isset($_GET['id'])) {
            header('Location: ' . BASE_URL . '/ug/resources');
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();
            
            $resourceId = (int)$_GET['id'];
            $resource = $resourceHub->getById($resourceId);
            
            if (!$resource) {
                header('Location: ' . BASE_URL . '/ug/resources');
                exit;
            }

            $userLikes = [];
            if (isset($_SESSION['user_id'])) {
                $userLikes = $resourceHub->getUserLikes($_SESSION['user_id']);
            }

            $comments = $resourceHub->getComments($resourceId);

            view('undergrad/resource-details', [
                'resource' => $resource,
                'userLikes' => $userLikes,
                'comments' => $comments,
                'categoryBaseUrl' => BASE_URL . '/ug/category-resources',
                'likeUrl' => BASE_URL . '/ug/likeResource',
                'addCommentUrl' => BASE_URL . '/ug/addComment',
                'reportResourceUrl' => BASE_URL . '/ug/reportResource'
            ]);
        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/ug/resources');
            exit;
        }
    }

    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resource_id'], $_POST['comment'])) {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();
            
            $resourceId = (int)$_POST['resource_id'];
            $userId = $_SESSION['user_id'];
            $comment = trim($_POST['comment']);
            
            if (!empty($comment)) {
                $resourceHub->addComment($resourceId, $userId, $comment);
            }
            
            header('Location: ' . BASE_URL . '/ug/viewResource?id=' . $resourceId);
            exit;
        }
        
        header('Location: ' . BASE_URL . '/ug/resources');
        exit;
    }

    public function editComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'], $_POST['comment'], $_POST['resource_id'])) {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();
            
            $commentId = (int)$_POST['comment_id'];
            $resourceId = (int)$_POST['resource_id'];
            $userId = $_SESSION['user_id'];
            $comment = trim($_POST['comment']);
            
            if (!empty($comment)) {
                $resourceHub->updateComment($commentId, $userId, $comment);
            }
            
            header('Location: ' . BASE_URL . '/ug/viewResource?id=' . $resourceId);
            exit;
        }
        header('Location: ' . BASE_URL . '/ug/resources');
        exit;
    }

    public function deleteComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'], $_POST['resource_id'])) {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();
            
            $commentId = (int)$_POST['comment_id'];
            $resourceId = (int)$_POST['resource_id'];
            $userId = $_SESSION['user_id'];
            
            // Allow deletion if owner
            $resourceHub->deleteComment($commentId, $userId);
            
            header('Location: ' . BASE_URL . '/ug/viewResource?id=' . $resourceId);
            exit;
        }
        header('Location: ' . BASE_URL . '/ug/resources');
        exit;
    }

    public function reportResource() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['resource_id'], $input['reason'])) {
                require_once BASE_PATH . '/app/models/ResourceHub.php';
                $resourceHub = new ResourceHub();
                $success = $resourceHub->reportResource($input['resource_id'], $_SESSION['user_id'], $input['reason'], $input['description'] ?? '');
                
                header('Content-Type: application/json');
                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Rate limit exceeded or duplicate report.']);
                }
                exit;
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
        exit;
    }

    public function habits()
    {
        view('undergrad/habits');
    }

    public function about()
    {
        view('undergrad/about');
    }

    public function forum()
    {
        // Redirect to the canonical forum page (ForumControl@index) for consistency.
        header('Location: ' . BASE_URL . '/forum');
        exit;
    }

    public function quiz()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        require_once BASE_PATH . '/app/models/Assessment.php';
        $assessmentDb = new Assessment();
        
        $history = $assessmentDb->getHistory($userId);
        
        view('undergrad/quiz', [
            'history' => $history
        ]);
    }

    public function saveQuizResult()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? 0;
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }

        require_once BASE_PATH . '/app/models/Assessment.php';
        $assessmentDb = new Assessment();
        
        $success = $assessmentDb->saveResult($userId, $data);

        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
    
    public function goals() {
        view('undergrad/goals');
    }

    public function feedback()
    {
        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();

            // Get all feedback for display (filtered by privacy rules in model)
            $allFeedback = $feedbackModel->read(array(
                'viewer_id' => $_SESSION['user_id'],
                'viewer_role' => $_SESSION['role']
            ));

            // Get user's own feedback
            $userFeedback = $feedbackModel->read(array(
                'user_id' => $_SESSION['user_id'],
                'viewer_id' => $_SESSION['user_id'],
                'viewer_role' => $_SESSION['role']
            ));

            // Get counselors for selection
            $counselors = $feedbackModel->getCounselors();

            // Get feedback statistics (filtered by privacy rules)
            $stats = $feedbackModel->getStats(array(
                'viewer_id' => $_SESSION['user_id'],
                'viewer_role' => $_SESSION['role']
            ));

            $data = array(
                'allFeedback' => $allFeedback,
                'userFeedback' => $userFeedback,
                'counselors' => $counselors,
                'stats' => $stats
            );
            view('undergrad/feedback', $data);
        } catch (Exception $e) {
            // Fallback to basic feedback view if database fails
            view('undergrad/feedback', [
                'allFeedback' => [],
                'userFeedback' => [],
                'counselors' => [],
                'stats' => ['total_feedback' => 0, 'user_feedback' => 0]
            ]);
        }
    }

    public function createFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();

            $data = array(
                'user_id' => $_SESSION['user_id'],
                'feedback_type' => $_POST['feedback_type'],
                'counselor_id' => $_POST['feedback_type'] === 'counselor' ? $_POST['counselor_id'] : null,
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'rating' => isset($_POST['rating']) ? (int) $_POST['rating'] : null,
                'is_anonymous' => isset($_POST['is_anonymous']) ? 1 : 0
            );

            // Validation
            if (empty($data['title']) || empty($data['content'])) {
                $_SESSION['error'] = "Title and content are required.";
                header("Location: " . BASE_URL . "/ug/feedback");
                exit;
            }

            if ($data['feedback_type'] === 'counselor' && empty($data['counselor_id'])) {
                $_SESSION['error'] = "Please select a counselor for counselor feedback.";
                header("Location: " . BASE_URL . "/ug/feedback");
                exit;
            }

            if ($feedbackModel->create($data)) {
                $_SESSION['success'] = "Feedback submitted successfully!";
            } else {
                $_SESSION['error'] = "Failed to submit feedback. Please try again.";
            }

            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "An error occurred while submitting feedback. Please try again.";
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }
    }

    public function editFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();
            $feedback_id = (int) $_POST['feedback_id'];

            // Check if user owns this feedback
            if (!$feedbackModel->isOwner($feedback_id, $_SESSION['user_id'])) {
                $_SESSION['error'] = "You can only edit your own feedback.";
                header("Location: " . BASE_URL . "/ug/feedback");
                exit;
            }

            $data = array(
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'rating' => isset($_POST['rating']) ? (int) $_POST['rating'] : null,
                'is_anonymous' => isset($_POST['is_anonymous']) ? 1 : 0
            );

            // Validation
            if (empty($data['title']) || empty($data['content'])) {
                $_SESSION['error'] = "Title and content are required.";
                header("Location: " . BASE_URL . "/ug/feedback");
                exit;
            }

            if ($feedbackModel->update($feedback_id, $data)) {
                $_SESSION['success'] = "Feedback updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update feedback. Please try again.";
            }

            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "An error occurred while updating feedback. Please try again.";
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }
    }

    public function deleteFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();
            $feedback_id = (int) $_POST['feedback_id'];

            // Check if user owns this feedback
            if (!$feedbackModel->isOwner($feedback_id, $_SESSION['user_id'])) {
                $_SESSION['error'] = "You can only delete your own feedback.";
                header("Location: " . BASE_URL . "/ug/feedback");
                exit;
            }

            if ($feedbackModel->delete($feedback_id, $_SESSION['user_id'])) {
                $_SESSION['success'] = "Feedback deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete feedback. Please try again.";
            }

            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "An error occurred while deleting feedback. Please try again.";
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }
    }

    public function getFeedbackById()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array('error' => 'Invalid request'));
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();
            $feedback_id = (int) $_GET['id'];

            // Check if user owns this feedback
            if (!$feedbackModel->isOwner($feedback_id, $_SESSION['user_id'])) {
                http_response_code(403);
                echo json_encode(array('error' => 'Access denied'));
                exit;
            }

            $feedback = $feedbackModel->readById($feedback_id);

            if ($feedback) {
                echo json_encode(array('success' => true, 'feedback' => $feedback));
            } else {
                http_response_code(404);
                echo json_encode(array('error' => 'Feedback not found'));
            }
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array('error' => 'An error occurred while retrieving feedback'));
            exit;
        }
    }



    public function profile()
    {
        // Load undergraduate student data
        $undergraduateModel = new Undergraduate();
        $student = $undergraduateModel->getByUserId($_SESSION['user_id']);

        if (!$student) {
            // If no student data found, redirect to complete profile
            header('Location: ' . BASE_URL . '/ug/profile/complete');
            exit;
        }

        // Fetch donation history
        require_once BASE_PATH . '/app/models/Donation.php';
        $donations = Donation::getDonationsByDonor($_SESSION['user_id']);

        view('undergrad/profile', [
            'student' => $student,
            'donations' => $donations
        ]);
    }

    public function editProfile()
    {
        $undergraduateModel = new Undergraduate();
        $student = $undergraduateModel->getByUserId($_SESSION['user_id']);

        if (!$student) {
            header('Location: ' . BASE_URL . '/ug/profile/complete');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $fullName = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phoneNumber = trim($_POST['phone_number'] ?? '');

            if (empty($fullName)) {
                $errors[] = 'Full name is required';
            }

            if (empty($email)) {
                $errors[] = 'Email address is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }

            if (empty($phoneNumber)) {
                $errors[] = 'Phone number is required';
            }

            if (empty($errors) && $undergraduateModel->emailExists($email, $_SESSION['user_id'])) {
                $errors[] = 'Email address already exists. Please use a different email.';
            }

            if (empty($errors)) {
                try {
                    $undergradData = [
                        'full_name' => $fullName,
                        'email' => $email,
                        'phone_number' => $phoneNumber,
                        'date_of_birth' => $_POST['date_of_birth'] ?? null,
                        'gender' => $_POST['gender'] ?? null,
                        'preferred_language' => trim($_POST['preferred_language'] ?? 'en')
                    ];

                    $undergraduateModel->update($_SESSION['user_id'], $undergradData);

                    header('Location: ' . BASE_URL . '/ug/profile');
                    exit;

                } catch (Exception $e) {
                    $errors[] = 'Failed to update profile. Please try again.';
                }
            }

            if (!empty($errors)) {
                view('undergrad/edit-profile', ['errors' => $errors, 'form_data' => $_POST]);
                return;
            }
        }

        // Pass existing student data as form_data initially
        $form_data = [
            'full_name' => $student['full_name'],
            'email' => $student['email'],
            'phone_number' => $student['phone_number'],
            'date_of_birth' => $student['date_of_birth'],
            'gender' => $student['gender'],
            'preferred_language' => $student['preferred_language']
        ];

        view('undergrad/edit-profile', ['form_data' => $form_data]);
    }

    public function completeProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle profile completion form submission
            $undergraduateModel = new Undergraduate();
            $errors = [];

            // Validate required fields
            $fullName = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phoneNumber = trim($_POST['phone_number'] ?? '');

            if (empty($fullName)) {
                $errors[] = 'Full name is required';
            }

            if (empty($email)) {
                $errors[] = 'Email address is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }

            if (empty($phoneNumber)) {
                $errors[] = 'Phone number is required';
            }

            // Check if email already exists
            if (empty($errors) && $undergraduateModel->emailExists($email)) {
                $errors[] = 'Email address already exists. Please use a different email.';
            }

            if (empty($errors)) {
                try {
                    $undergradData = [
                        'full_name' => $fullName,
                        'email' => $email,
                        'phone_number' => $phoneNumber,
                        'date_of_birth' => $_POST['date_of_birth'] ?? null,
                        'gender' => $_POST['gender'] ?? null,
                        'preferred_language' => trim($_POST['preferred_language'] ?? 'en')
                    ];

                    $undergraduateModel->create($_SESSION['user_id'], $undergradData);

                    // Redirect to profile page
                    header('Location: ' . BASE_URL . '/ug/profile');
                    exit;

                } catch (Exception $e) {
                    $errors[] = 'Failed to save profile. Please try again.';
                }
            }

            if (!empty($errors)) {
                view('undergrad/complete-profile', ['errors' => $errors, 'form_data' => $_POST]);
                return;
            }
        }

        // Show form to complete profile if student data doesn't exist
        $undergraduateModel = new Undergraduate();
        $student = $undergraduateModel->getByUserId($_SESSION['user_id']);

        if ($student) {
            // Profile already exists, redirect to profile
            header('Location: ' . BASE_URL . '/ug/profile');
            exit;
        }

        view('undergrad/complete-profile');
    }
}