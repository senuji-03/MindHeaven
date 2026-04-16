<?php

require_once BASE_PATH . '/app/models/Event.php';
require_once BASE_PATH . '/app/models/Feedback.php';
require_once BASE_PATH . '/app/models/Counselor.php';
require_once BASE_PATH . '/app/models/Appointment.php';

class COControl
{
    private $eventModel;

    public function __construct()
    {
        $this->eventModel = new Event();
    }

    public function index()
    {
        // Redirect to dashboard when accessing /counselor
        header('Location: ' . BASE_URL . '/counselor/dashboard');
        exit;
    }
    
    public function dashboard() {
        $counselorFeedback = array();
        $upcomingAppointments = array();
        $stats = array(
            'totalPatients' => 0,
            'todaysSessions' => 0,
            'avgRating' => 0.0
        );
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION['user_id'])) {
            $counselorModel = new Counselor();
            $counselor = $counselorModel->getByUserId($_SESSION['user_id']);
            if ($counselor && !empty($counselor['id'])) {
                $feedbackModel = new Feedback();
                $counselorFeedback = $feedbackModel->getCounselorFeedback((int) $counselor['id'], 10);
                
                $feedbackStats = $feedbackModel->getStats(array('counselor_id' => $counselor['id']));
                if ($feedbackStats && isset($feedbackStats['avg_rating'])) {
                    $stats['avgRating'] = round((float)$feedbackStats['avg_rating'], 1);
                }
            }

            // Upcoming appointments booked by undergrads (appointments table)
            $appointmentModel = new Appointment();
            $inProgressAppointments = $appointmentModel->getInProgressByCounselorUserId((int)$_SESSION['user_id']);
            $upcomingAppointments = $appointmentModel->getUpcomingByCounselorUserId((int)$_SESSION['user_id'], 10);
            
            $stats['totalPatients'] = $appointmentModel->getTotalPatients((int)$_SESSION['user_id']);
            $stats['todaysSessions'] = $appointmentModel->getTodaysSessionsCount((int)$_SESSION['user_id']);
            
            // Fetch escalated crisis calls
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT c.*, COALESCE(u.full_name, u.username, 'Anonymous') AS caller_name 
                                 FROM crisis_calls c 
                                 LEFT JOIN users u ON c.caller_user_id = u.id 
                                 WHERE c.status = 'escalated' 
                                 ORDER BY c.created_at DESC LIMIT 5");
            $escalatedCalls = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        view('/counselor/Cdashboard', array(
            'counselorFeedback' => $counselorFeedback,
            'inProgressAppointments' => $inProgressAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'escalatedCalls' => isset($escalatedCalls) ? $escalatedCalls : array(),
            'stats' => $stats
        ));

    }

    /**
     * List all counselor feedback (from undergraduates) for the logged-in counselor.
     */
    public function feedbackList() {
        $counselorFeedback = array();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $counselorModel = new Counselor();
        $counselor = $counselorModel->getByUserId($_SESSION['user_id']);
        if (!$counselor || empty($counselor['id'])) {
            view('/counselor/feedback_list', array('counselorFeedback' => array()));
            return;
        }
        $feedbackModel = new Feedback();
        $counselorFeedback = $feedbackModel->getCounselorFeedback((int) $counselor['id'], 100);
        view('/counselor/feedback_list', array('counselorFeedback' => $counselorFeedback));
    }

    public function appointmentmgt()
    {
        view('/counselor/appointmentmgt');
    }

    public function timeslots()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'counselor') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        view('/counselor/timeslots');
    }

    public function forum()
    {
        // Redirect to the canonical forum page (ForumControl@index) for consistency.
        header('Location: ' . BASE_URL . '/forum');
        exit;
    }

    public function calender()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Get counselor ID from session with better error handling
        $counselorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if (!$counselorId) {
            error_log("COControl calender: No user_id in session. Session data: " . json_encode($_SESSION));
            // Redirect to login if no session
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        error_log("COControl calender: Using counselor_id: $counselorId");

        // Get today's events
        $todaysEvents = $this->eventModel->getTodaysEvents($counselorId);

        // Get current month events
        $currentDate = new DateTime();
        $monthEvents = $this->eventModel->getEventsByMonth(
            $counselorId,
            $currentDate->format('Y'),
            $currentDate->format('m')
        );

        // Convert events to JavaScript format for calendar display
        $eventsForJS = array();
        foreach ($monthEvents as $event) {
            $eventsForJS[$event->event_date][] = array(
                'id' => $event->id,
                'title' => $event->title,
                'time' => $event->event_time,
                'priority' => $event->priority,
                'description' => $event->description
            );
        }

        $data = array(
            'todaysEvents' => $todaysEvents,
            'monthEvents' => $monthEvents,
            'eventsForJS' => json_encode($eventsForJS),
            'counselorId' => $counselorId
        );

        view('/counselor/calender', $data);
    }

    public function sessionHistory()
    {
        view('/counselor/sessionHistory');
    }
    
    public function counselorProfile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $counselorModel = new Counselor();
        $counselor = $counselorModel->getByUserId($_SESSION['user_id']);
        
        $qualifications = array();
        if ($counselor && !empty($counselor['id'])) {
            $qualifications = $counselorModel->getQualifications($counselor['id']);
        }

        // Fetch donation history
        require_once BASE_PATH . '/app/models/Donation.php';
        $donations = Donation::getDonationsByDonor($_SESSION['user_id']);

        view('/counselor/counselor_profile', array(
            'counselor' => $counselor,
            'qualifications' => $qualifications,
            'donations' => $donations
        ));
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            echo json_encode(array('success' => false, 'message' => 'Not logged in'));
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $data = $_POST;
        }

        $counselorModel = new Counselor();
        $success = $counselorModel->update($_SESSION['user_id'], $data);

        if ($success) {
            echo json_encode(array('success' => true, 'message' => 'Profile updated successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update profile or no changes made'));
        }
    }

    public function syncQualifications() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            echo json_encode(array('success' => false, 'message' => 'Not logged in'));
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['qualifications'])) {
            echo json_encode(array('success' => false, 'message' => 'No qualifications data provided'));
            return;
        }

        $counselorModel = new Counselor();
        $counselor = $counselorModel->getByUserId($_SESSION['user_id']);
        
        if (!$counselor || empty($counselor['id'])) {
            echo json_encode(array('success' => false, 'message' => 'Counselor not found'));
            return;
        }

        $success = $counselorModel->syncQualifications($counselor['id'], $data['qualifications']);

        if ($success) {
            echo json_encode(array('success' => true, 'message' => 'Qualifications sync successful'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to sync qualifications'));
        }
    }

    public function uploadProfilePhoto() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            echo json_encode(array('success' => false, 'message' => 'Not logged in'));
            return;
        }

        if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(array('success' => false, 'message' => 'No valid file uploaded'));
            return;
        }

        $file = $_FILES['profile_picture'];
        
        // Basic validation
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(array('success' => false, 'message' => 'Invalid file format. Please upload JPG, PNG, GIF or WEBP.'));
            return;
        }
        
        // Max size: 5MB
        if ($file['size'] > 5 * 1024 * 1024) {
             echo json_encode(array('success' => false, 'message' => 'File size exceeds 5MB limit.'));
             return;
        }
        
        $uploadDirBase = BASE_PATH . '/public/uploads/counselor_profiles/';
        if (!is_dir($uploadDirBase)) {
            mkdir($uploadDirBase, 0777, true);
        }
        
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = 'counselor_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
        $targetFile = $uploadDirBase . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Success, update db
            $publicUrl = BASE_URL . '/uploads/counselor_profiles/' . $fileName;
            
            $counselorModel = new Counselor();
            $success = $counselorModel->update($_SESSION['user_id'], array('profile_picture' => $publicUrl));
            
            if ($success) {
                 echo json_encode(array('success' => true, 'message' => 'Profile picture uploaded.', 'url' => $publicUrl));
            } else {
                 echo json_encode(array('success' => false, 'message' => 'Database update failed.'));
            }
        } else {
             echo json_encode(array('success' => false, 'message' => 'Failed to move uploaded file.'));
        }
    }

    /**
     * API endpoint to create a new event
     */
    public function createEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        $counselorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

        // Debug logging
        error_log("CreateEvent called with counselor_id: " . $counselorId);
        error_log("POST data: " . print_r($_POST, true));

        $data = array(
            'counselor_user_id' => $counselorId,
            'title' => isset($_POST['title']) ? $_POST['title'] : '',
            'event_date' => isset($_POST['event_date']) ? $_POST['event_date'] : '',
            'event_time' => isset($_POST['event_time']) ? $_POST['event_time'] : '',
            'priority' => isset($_POST['priority']) ? $_POST['priority'] : 'normal',
            'description' => isset($_POST['description']) ? $_POST['description'] : '',
            'appointment_id' => isset($_POST['appointment_id']) ? $_POST['appointment_id'] : null
        );

        // Validate required fields
        if (empty($data['title']) || empty($data['event_date']) || empty($data['event_time'])) {
            echo json_encode(array('success' => false, 'message' => 'Title, date, and time are required'));
            return;
        }

        // Check for time conflicts
        error_log("COControl: Checking time conflict for counselor_id: {$counselorId}, date: {$data['event_date']}, time: {$data['event_time']}");
        if ($this->eventModel->checkTimeConflict($counselorId, $data['event_date'], $data['event_time'])) {
            error_log("COControl: Time conflict detected - returning error");
            echo json_encode(array('success' => false, 'message' => 'Time conflict: Another event exists at this time'));
            return;
        }
        error_log("COControl: No time conflict - proceeding with event creation");

        $eventId = $this->eventModel->createEvent($data);

        if ($eventId) {
            echo json_encode(array('success' => true, 'message' => 'Event created successfully', 'event_id' => $eventId));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to create event'));
        }
    }

    /**
     * API endpoint to update an existing event
     */
    public function updateEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        $eventId = isset($_POST['event_id']) ? $_POST['event_id'] : '';
        if (empty($eventId)) {
            echo json_encode(array('success' => false, 'message' => 'Event ID is required'));
            return;
        }

        $counselorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

        // Verify event belongs to counselor
        $event = $this->eventModel->getEventById($eventId);
        if (!$event || $event->counselor_user_id != $counselorId) {
            echo json_encode(array('success' => false, 'message' => 'Event not found or access denied'));
            return;
        }

        $data = array(
            'title' => isset($_POST['title']) ? $_POST['title'] : '',
            'event_date' => isset($_POST['event_date']) ? $_POST['event_date'] : '',
            'event_time' => isset($_POST['event_time']) ? $_POST['event_time'] : '',
            'priority' => isset($_POST['priority']) ? $_POST['priority'] : 'normal',
            'description' => isset($_POST['description']) ? $_POST['description'] : ''
        );

        // Validate required fields
        if (empty($data['title']) || empty($data['event_date']) || empty($data['event_time'])) {
            echo json_encode(array('success' => false, 'message' => 'Title, date, and time are required'));
            return;
        }

        // Check for time conflicts (excluding current event)
        if ($this->eventModel->checkTimeConflict($counselorId, $data['event_date'], $data['event_time'], $eventId)) {
            echo json_encode(array('success' => false, 'message' => 'Time conflict: Another event exists at this time'));
            return;
        }

        $success = $this->eventModel->updateEvent($eventId, $data);

        if ($success) {
            echo json_encode(array('success' => true, 'message' => 'Event updated successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update event'));
        }
    }

    /**
     * API endpoint to delete an event
     */
    public function deleteEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        $eventId = isset($_POST['event_id']) ? $_POST['event_id'] : '';
        if (empty($eventId)) {
            echo json_encode(array('success' => false, 'message' => 'Event ID is required'));
            return;
        }

        $counselorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

        // Verify event belongs to counselor
        $event = $this->eventModel->getEventById($eventId);
        if (!$event || $event->counselor_user_id != $counselorId) {
            echo json_encode(array('success' => false, 'message' => 'Event not found or access denied'));
            return;
        }

        $success = $this->eventModel->deleteEvent($eventId);

        if ($success) {
            echo json_encode(array('success' => true, 'message' => 'Event deleted successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to delete event'));
        }
    }

    /**
     * API endpoint to get events for a specific date
     */
    public function getEventsByDate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $counselorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $date = isset($_GET['date']) ? $_GET['date'] : '';

        if (!$counselorId) {
            error_log("getEventsByDate: No user_id in session. Session data: " . json_encode($_SESSION));
            echo json_encode(array('success' => false, 'message' => 'Not logged in'));
            return;
        }

        if (empty($date)) {
            echo json_encode(array('success' => false, 'message' => 'Date is required'));
            return;
        }

        error_log("getEventsByDate called - Counselor ID: $counselorId, Date: $date");

        $events = $this->eventModel->getEventsByDate($counselorId, $date);
        echo json_encode(array('success' => true, 'events' => $events));
    }

    /**
     * API endpoint to get events for a specific month
     */
    public function getEventsByMonth()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $counselorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
        $month = isset($_GET['month']) ? $_GET['month'] : date('m');

        if (!$counselorId) {
            error_log("getEventsByMonth: No user_id in session. Session data: " . json_encode($_SESSION));
            echo json_encode(array('success' => false, 'message' => 'Not logged in'));
            return;
        }

        error_log("getEventsByMonth called - Counselor ID: $counselorId, Year: $year, Month: $month");

        $events = $this->eventModel->getEventsByMonth($counselorId, $year, $month);

        error_log("Events retrieved: " . count($events) . " events");
        error_log("Raw events data: " . json_encode($events));

        // Convert to JavaScript format
        $eventsForJS = array();
        foreach ($events as $event) {
            $eventsForJS[$event->event_date][] = array(
                'id' => $event->id,
                'title' => $event->title,
                'time' => $event->event_time,
                'priority' => $event->priority,
                'description' => $event->description
            );
        }

        error_log("Events for JS: " . json_encode($eventsForJS));

        // Debug: Check if there are any events in the database at all
        $allEvents = $this->eventModel->getAllEvents();
        error_log("Total events in database: " . count($allEvents));
        if (count($allEvents) > 0) {
            error_log("Sample event data: " . json_encode($allEvents[0]));
        }

        echo json_encode(array('success' => true, 'events' => $eventsForJS));
    }

    /**
     * API endpoint to get a single event by ID
     */
    public function getEventById()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
            return;
        }

        $eventId = isset($_GET['id']) ? $_GET['id'] : '';
        if (empty($eventId)) {
            echo json_encode(array('success' => false, 'message' => 'Event ID is required'));
            return;
        }

        $counselorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
        $event = $this->eventModel->getEventById($eventId);

        if (!$event || (int) $event->counselor_id !== (int) $counselorId) {
            echo json_encode(array('success' => false, 'message' => 'Event not found or access denied'));
            return;
        }

        echo json_encode(array('success' => true, 'event' => $event));
    }


    public function Cresource_hub() {
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

            view('/counselor/Cresource_hub', [
                'resources' => $allResources,
                'resourcesByCategory' => $resourcesByCategory,
                'stats' => $stats
            ]);
        } catch (Exception $e) {
            error_log("Counselor ResourceHub Error: " . $e->getMessage());
            view('/counselor/Cresource_hub', [
                'resources' => [],
                'resourcesByCategory' => [],
                'stats' => ['total_resources' => 0, 'published' => 0]
            ]);
        }
    }

    public function CcategoryResources()
    {
        try {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();

            $category = $_GET['category'] ?? '';
            if (empty($category)) {
                header('Location: ' . BASE_URL . '/counselor/Cresource_hub');
                exit;
            }

            $categoryResources = $resourceHub->getByCategory($category, 'published');
            $userLikes = [];
            if (isset($_SESSION['user_id'])) {
                $userLikes = $resourceHub->getUserLikes($_SESSION['user_id']);
            }

            $allResources = $resourceHub->getAll('published');
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
            $currentCategoryInfo = $categoryInfo[$category] ?? ['description' => 'Resources for ' . $category];

            view('/counselor/Ccategory_resources', [
                'category' => $category,
                'categoryInfo' => $currentCategoryInfo,
                'resources' => $categoryResources,
                'allCategories' => $allCategories,
                'totalResources' => count($categoryResources),
                'userLikes' => $userLikes
            ]);

        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/counselor/Cresource_hub?error=category_not_found');
            exit;
        }
    }

    public function CviewResource()
    {
        if (!isset($_GET['id'])) {
            header('Location: ' . BASE_URL . '/counselor/Cresource_hub');
            exit;
        }

        try {
            require_once BASE_PATH . '/app/models/ResourceHub.php';
            $resourceHub = new ResourceHub();
            
            $resourceId = (int)$_GET['id'];
            $resource = $resourceHub->getById($resourceId);
            
            if (!$resource) {
                header('Location: ' . BASE_URL . '/counselor/Cresource_hub');
                exit;
            }

            $userLikes = [];
            if (isset($_SESSION['user_id'])) {
                $userLikes = $resourceHub->getUserLikes($_SESSION['user_id']);
            }

            $comments = $resourceHub->getComments($resourceId);

            view('/counselor/Cresource_details', [
                'resource' => $resource,
                'userLikes' => $userLikes,
                'comments' => $comments
            ]);
        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/counselor/Cresource_hub');
            exit;
        }
    }

    public function ClikeResource()
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

    public function CaddComment()
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
            
            header('Location: ' . BASE_URL . '/counselor/viewResource?id=' . $resourceId);
            exit;
        }
        
        header('Location: ' . BASE_URL . '/counselor/Cresource_hub');
        exit;
    }

    public function CreportResource() {
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
    
}