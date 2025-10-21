<?php

class UGControl{

    public function __construct() {
        // Session is already started in index.php, no need to start again
        // Protect all undergrad routes
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'undergrad') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }
    public function index() {
        view('undergrad/home');
    }
    public function appointment() {
        view('undergrad/appointments');
    }
    public function contact() {
        view('undergrad/contact');
    }
    public function crisis() {
        view('undergrad/crisis');
    }
     public function mood() {
        view('undergrad/mood');
    }
     public function resources() {
        try {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();
            
            // Get all published resources
            $allResources = $resourceHub->getAll('published');
            
            // Group resources by category
            $resourcesByCategory = [];
            foreach ($allResources as $resource) {
                $category = $resource['category'];
                if (!isset($resourcesByCategory[$category])) {
                    $resourcesByCategory[$category] = [];
                }
                $resourcesByCategory[$category][] = $resource;
            }
            
            // Get resource statistics
            $stats = $resourceHub->getStats();
            
            view('undergrad/resources', [
                'resources' => $allResources,
                'resourcesByCategory' => $resourcesByCategory,
                'stats' => $stats
            ]);
        } catch (Exception $e) {
            // Fallback to static view if database fails
            view('undergrad/resources', [
                'resources' => [],
                'resourcesByCategory' => [],
                'stats' => ['total_resources' => 0, 'published' => 0]
            ]);
        }
    }

    
    
    public function categoryResources() {
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
            
            // Get all categories for navigation
            $allResources = $resourceHub->getAll('published');
            $allCategories = [];
            foreach ($allResources as $resource) {
                $cat = $resource['category'];
                if (!isset($allCategories[$cat])) {
                    $allCategories[$cat] = count(array_filter($allResources, function($r) use ($cat) {
                        return $r['category'] === $cat;
                    }));
                }
            }
            
            // Define category info
            $categoryInfo = [
                'Mental Health Basics' => ['icon' => '🧠', 'description' => 'Understanding mental health, common conditions, and when to seek help'],
                'Anxiety & Stress' => ['icon' => '😰', 'description' => 'Coping strategies and techniques for managing anxiety and stress'],
                'Depression Support' => ['icon' => '😢', 'description' => 'Resources and support for dealing with depression'],
                'Mindfulness & Meditation' => ['icon' => '🧘‍♀️', 'description' => 'Guided practices for mindfulness and meditation'],
                'Sleep & Wellness' => ['icon' => '💤', 'description' => 'Tips for better sleep and overall wellness'],
                'Relationships & Social' => ['icon' => '👥', 'description' => 'Building healthy relationships and social connections'],
                'Crisis Support' => ['icon' => '🆘', 'description' => 'Emergency resources and crisis intervention'],
                'Self-Help Tools' => ['icon' => '🛠️', 'description' => 'Interactive tools and exercises for mental wellness'],
                'Professional Development' => ['icon' => '🎓', 'description' => 'Resources for academic and career success']
            ];
            
            $currentCategoryInfo = $categoryInfo[$category] ?? ['icon' => '📚', 'description' => 'Resources for ' . $category];
            
            view('undergrad/category-resources', [
                'category' => $category,
                'categoryInfo' => $currentCategoryInfo,
                'resources' => $categoryResources,
                'allCategories' => $allCategories,
                'totalResources' => count($categoryResources)
            ]);
            
        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/ug/resources?error=category_not_found');
            exit;
        }
    }
     public function habits() {
        view('undergrad/habits');
    }
    
    public function about() {
        view('undergrad/about');
    }
    
    public function forum() {
        view('undergrad/forum');
    }
    
    public function quiz() {
        view('undergrad/quiz');
    }

    public function feedback() {
        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();
            
            // Get all feedback for display
            $allFeedback = $feedbackModel->read();
            
            // Get user's own feedback
            $userFeedback = $feedbackModel->read(array('user_id' => $_SESSION['user_id']));
            
            // Get counselors for selection
            $counselors = $feedbackModel->getCounselors();
            
            // Get feedback statistics
            $stats = $feedbackModel->getStats();
            
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

    public function createFeedback() {
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
            'rating' => isset($_POST['rating']) ? (int)$_POST['rating'] : null,
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

    public function editFeedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();
        $feedback_id = (int)$_POST['feedback_id'];
        
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
            'rating' => isset($_POST['rating']) ? (int)$_POST['rating'] : null,
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

    public function deleteFeedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/ug/feedback");
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();
        $feedback_id = (int)$_POST['feedback_id'];
        
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

    public function getFeedbackById() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array('error' => 'Invalid request'));
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/Feedback.php';
            $feedbackModel = new Feedback();
        $feedback_id = (int)$_GET['id'];
        
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


    
    public function profile() {
        // Load undergraduate student data
        $undergraduateModel = new Undergraduate();
        $student = $undergraduateModel->getByUserId($_SESSION['user_id']);
        
        if (!$student) {
            // If no student data found, redirect to complete profile
            header('Location: ' . BASE_URL . '/ug/profile/complete');
            exit;
        }
        
        view('undergrad/profile', ['student' => $student]);
    }
    
    public function completeProfile() {
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