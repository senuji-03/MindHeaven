<?php

require_once BASE_PATH . '/app/models/Event.php';

class COControl {
    private $eventModel;
    
    public function __construct() {
        $this->eventModel = new Event();
    }
    
    public function index() {
        // Redirect to dashboard when accessing /counselor
        header('Location: ' . BASE_URL . '/counselor/dashboard');
        exit;
    }
    
    public function dashboard() {
        view('/counselor/Cdashboard');
    }
    
    public function appointmentmgt() {
        view('/counselor/appointmentmgt');
    }
    
    public function calender() {
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
    
    public function sessionHistory() {
        view('/counselor/sessionHistory');
    }
    
    public function counselorProfile() {
        view('/counselor/counselor_profile');
    }
    
    /**
     * API endpoint to create a new event
     */
    public function createEvent() {
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
            'counselor_id' => $counselorId,
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
    public function updateEvent() {
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
        if (!$event || $event->counselor_id != $counselorId) {
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
    public function deleteEvent() {
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
        if (!$event || $event->counselor_id != $counselorId) {
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
    public function getEventsByDate() {
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
    public function getEventsByMonth() {
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
    public function getEventById() {
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

        if (!$event || (int)$event->counselor_id !== (int)$counselorId) {
            echo json_encode(array('success' => false, 'message' => 'Event not found or access denied'));
            return;
        }

        echo json_encode(array('success' => true, 'event' => $event));
    }
}