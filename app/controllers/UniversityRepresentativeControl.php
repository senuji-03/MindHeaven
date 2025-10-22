<?php
/**
 * University Representative Controller
 * Location: app/controllers/UniversityRepresentativeControl.php
 */

class UniversityRepresentativeControl {
    
    // Index method - redirects to dashboard
    public function index() {
        $this->dashboard();
    }
    
    // Dashboard
    public function dashboard() {
        view('UniversityRepresentative/dashboard');
    }

    // ========================================
    // EVENTS MANAGEMENT
    // ========================================

    // List all events
    public function events() {
        try {
            $pdo = Database::getConnection();
            
            // Get the university representative user ID from session
            $universityRepId = $_SESSION['user_id'] ?? null;
            if (!$universityRepId) {
                $_SESSION['error'] = 'User not authenticated';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            
            // Fetch events created by this university representative
            $sql = "SELECT * FROM university_rep_events WHERE university_rep_id = ? ORDER BY event_date DESC, start_time DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$universityRepId]);
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            view('UniversityRepresentative/events', ['events' => $events]);
            
        } catch (Exception $e) {
            error_log("University Representative Events Error: " . $e->getMessage());
            view('UniversityRepresentative/events', ['events' => [], 'error' => 'Failed to load events']);
        }
    }

    // Show create event form
    public function createEvent() {
        view('UniversityRepresentative/create-event');
    }

    // Store new event
    public function storeEvent() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/events');
            exit;
        }

        try {
            $pdo = Database::getConnection();
            
            // Get the university representative user ID from session
            $universityRepId = $_SESSION['user_id'] ?? null;
            if (!$universityRepId) {
                $_SESSION['error'] = 'User not authenticated';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            
            // Get form data
            $eventTitle = trim($_POST['event_title'] ?? '');
            $eventType = trim($_POST['event_type'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $organizedBy = trim($_POST['organized_by'] ?? '');
            $targetAudience = isset($_POST['target_audience']) ? implode(',', $_POST['target_audience']) : '';
            $openFor = trim($_POST['open_for'] ?? '');
            $eventDate = trim($_POST['event_date'] ?? '');
            $startTime = trim($_POST['start_time'] ?? '');
            $endTime = trim($_POST['end_time'] ?? '');
            $venue = trim($_POST['venue'] ?? '');
            $mode = trim($_POST['mode'] ?? '');
            $maxParticipants = trim($_POST['max_participants'] ?? '');
            $registrationDeadline = trim($_POST['registration_deadline'] ?? '');
            $contactPerson = trim($_POST['contact_person'] ?? '');
            $contactEmail = trim($_POST['contact_email'] ?? '');
            $contactPhone = trim($_POST['contact_phone'] ?? '');
            $additionalInfo = trim($_POST['additional_info'] ?? '');
            
            // Validate required fields
            $errors = [];
            if (empty($eventTitle)) $errors[] = 'Event title is required';
            if (empty($eventType)) $errors[] = 'Event type is required';
            if (empty($description)) $errors[] = 'Description is required';
            if (empty($organizedBy)) $errors[] = 'Organized by is required';
            if (empty($eventDate)) $errors[] = 'Event date is required';
            if (empty($startTime)) $errors[] = 'Start time is required';
            if (empty($endTime)) $errors[] = 'End time is required';
            if (empty($venue)) $errors[] = 'Venue is required';
            if (empty($mode)) $errors[] = 'Mode is required';
            
            if (!empty($errors)) {
                $_SESSION['error'] = implode(', ', $errors);
                header('Location: ' . BASE_URL . '/university-rep/events/create');
                exit;
            }
            
            // Insert event into university_rep_events table
            $sql = "INSERT INTO university_rep_events (
                university_rep_id, event_title, event_type, description, organized_by, 
                target_audience, open_for, event_date, start_time, end_time, 
                venue, mode, max_participants, registration_deadline, 
                contact_person, contact_email, contact_phone, additional_info
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                $universityRepId,
                $eventTitle,
                $eventType,
                $description,
                $organizedBy,
                $targetAudience,
                $openFor,
                $eventDate,
                $startTime,
                $endTime,
                $venue,
                $mode,
                $maxParticipants ?: null,
                $registrationDeadline ?: null,
                $contactPerson ?: null,
                $contactEmail ?: null,
                $contactPhone ?: null,
                $additionalInfo ?: null
            ]);
        
        $_SESSION['success'] = 'Event created successfully!';
        header('Location: ' . BASE_URL . '/university-rep/events');
        exit;
            
        } catch (Exception $e) {
            error_log("University Representative Event Creation Error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to create event. Please try again.';
            header('Location: ' . BASE_URL . '/university-rep/events/create');
            exit;
        }
    }

    // View event details
    public function viewEvent() {
        try {
            $pdo = Database::getConnection();
            
            // Get the university representative user ID from session
            $universityRepId = $_SESSION['user_id'] ?? null;
            if (!$universityRepId) {
                $_SESSION['error'] = 'User not authenticated';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            
            // Get event ID from URL parameter
            $eventId = $_GET['id'] ?? null;
            if (!$eventId) {
                $_SESSION['error'] = 'Event ID is required';
                header('Location: ' . BASE_URL . '/university-rep/events');
                exit;
            }
            
            // Fetch the event to view
            $sql = "SELECT * FROM university_rep_events WHERE id = ? AND university_rep_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$eventId, $universityRepId]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$event) {
                $_SESSION['error'] = 'Event not found or you do not have permission to view it';
                header('Location: ' . BASE_URL . '/university-rep/events');
                exit;
            }
            
            // Convert target_audience back to array for display
            if ($event['target_audience']) {
                $event['target_audience'] = explode(',', $event['target_audience']);
            } else {
                $event['target_audience'] = [];
            }
            
            view('UniversityRepresentative/view-event', ['event' => $event]);
            
        } catch (Exception $e) {
            error_log("University Representative View Event Error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to load event';
            header('Location: ' . BASE_URL . '/university-rep/events');
            exit;
        }
    }

    // Show edit event form
    public function editEvent() {
        try {
            $pdo = Database::getConnection();
            
            // Get the university representative user ID from session
            $universityRepId = $_SESSION['user_id'] ?? null;
            if (!$universityRepId) {
                $_SESSION['error'] = 'User not authenticated';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            
            // Get event ID from URL parameter
            $eventId = $_GET['id'] ?? null;
            if (!$eventId) {
                $_SESSION['error'] = 'Event ID is required';
                header('Location: ' . BASE_URL . '/university-rep/events');
                exit;
            }
            
            // Fetch the event to edit
            $sql = "SELECT * FROM university_rep_events WHERE id = ? AND university_rep_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$eventId, $universityRepId]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$event) {
                $_SESSION['error'] = 'Event not found or you do not have permission to edit it';
                header('Location: ' . BASE_URL . '/university-rep/events');
                exit;
            }
            
            // Convert target_audience back to array for form
            if ($event['target_audience']) {
                $event['target_audience'] = explode(',', $event['target_audience']);
            } else {
                $event['target_audience'] = [];
            }
            
            view('UniversityRepresentative/edit-event', ['event' => $event]);
            
        } catch (Exception $e) {
            error_log("University Representative Edit Event Error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to load event for editing';
            header('Location: ' . BASE_URL . '/university-rep/events');
            exit;
        }
    }

    // Update event
    public function updateEvent() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/events');
            exit;
        }

        try {
            $pdo = Database::getConnection();
            
            // Get the university representative user ID from session
            $universityRepId = $_SESSION['user_id'] ?? null;
            if (!$universityRepId) {
                $_SESSION['error'] = 'User not authenticated';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            
            // Get event ID
            $eventId = $_POST['event_id'] ?? null;
            if (!$eventId) {
                $_SESSION['error'] = 'Event ID is required';
                header('Location: ' . BASE_URL . '/university-rep/events');
                exit;
            }
            
            // Verify the event belongs to this user
            $checkSql = "SELECT id FROM university_rep_events WHERE id = ? AND university_rep_id = ?";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([$eventId, $universityRepId]);
            if (!$checkStmt->fetch()) {
                $_SESSION['error'] = 'Event not found or you do not have permission to edit it';
                header('Location: ' . BASE_URL . '/university-rep/events');
                exit;
            }
            
            // Get form data
            $eventTitle = trim($_POST['event_title'] ?? '');
            $eventType = trim($_POST['event_type'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $organizedBy = trim($_POST['organized_by'] ?? '');
            $targetAudience = isset($_POST['target_audience']) ? implode(',', $_POST['target_audience']) : '';
            $openFor = trim($_POST['open_for'] ?? '');
            $eventDate = trim($_POST['event_date'] ?? '');
            $startTime = trim($_POST['start_time'] ?? '');
            $endTime = trim($_POST['end_time'] ?? '');
            $venue = trim($_POST['venue'] ?? '');
            $mode = trim($_POST['mode'] ?? '');
            $maxParticipants = trim($_POST['max_participants'] ?? '');
            $registrationDeadline = trim($_POST['registration_deadline'] ?? '');
            $contactPerson = trim($_POST['contact_person'] ?? '');
            $contactEmail = trim($_POST['contact_email'] ?? '');
            $contactPhone = trim($_POST['contact_phone'] ?? '');
            $additionalInfo = trim($_POST['additional_info'] ?? '');
            
            // Validate required fields
            $errors = [];
            if (empty($eventTitle)) $errors[] = 'Event title is required';
            if (empty($eventType)) $errors[] = 'Event type is required';
            if (empty($description)) $errors[] = 'Description is required';
            if (empty($organizedBy)) $errors[] = 'Organized by is required';
            if (empty($eventDate)) $errors[] = 'Event date is required';
            if (empty($startTime)) $errors[] = 'Start time is required';
            if (empty($endTime)) $errors[] = 'End time is required';
            if (empty($venue)) $errors[] = 'Venue is required';
            if (empty($mode)) $errors[] = 'Mode is required';
            
            if (!empty($errors)) {
                $_SESSION['error'] = implode(', ', $errors);
                header('Location: ' . BASE_URL . '/university-rep/events/edit/' . $eventId);
                exit;
            }
            
            // Update event in database
            $sql = "UPDATE university_rep_events SET 
                event_title = ?, event_type = ?, description = ?, organized_by = ?, 
                target_audience = ?, open_for = ?, event_date = ?, start_time = ?, end_time = ?, 
                venue = ?, mode = ?, max_participants = ?, registration_deadline = ?, 
                contact_person = ?, contact_email = ?, contact_phone = ?, additional_info = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = ? AND university_rep_id = ?";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                $eventTitle, $eventType, $description, $organizedBy,
                $targetAudience, $openFor, $eventDate, $startTime, $endTime,
                $venue, $mode, $maxParticipants ?: null, $registrationDeadline ?: null,
                $contactPerson ?: null, $contactEmail ?: null, $contactPhone ?: null, $additionalInfo ?: null,
                $eventId, $universityRepId
            ]);
        
        $_SESSION['success'] = 'Event updated successfully!';
        header('Location: ' . BASE_URL . '/university-rep/events');
        exit;
            
        } catch (Exception $e) {
            error_log("University Representative Event Update Error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to update event. Please try again.';
            header('Location: ' . BASE_URL . '/university-rep/events/edit/' . ($_POST['event_id'] ?? ''));
            exit;
        }
    }

    // Delete event
    public function deleteEvent() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/events');
            exit;
        }

        try {
            $pdo = Database::getConnection();
            
            // Get the university representative user ID from session
            $universityRepId = $_SESSION['user_id'] ?? null;
            if (!$universityRepId) {
                $_SESSION['error'] = 'User not authenticated';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            
            // Get event ID
            $eventId = $_POST['event_id'] ?? null;
            if (!$eventId) {
                $_SESSION['error'] = 'Event ID is required';
        header('Location: ' . BASE_URL . '/university-rep/events');
        exit;
            }
            
            // Verify the event belongs to this user and delete it
            $sql = "DELETE FROM university_rep_events WHERE id = ? AND university_rep_id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$eventId, $universityRepId]);
            
            if ($stmt->rowCount() === 0) {
                $_SESSION['error'] = 'Event not found or you do not have permission to delete it';
            } else {
                $_SESSION['success'] = 'Event deleted successfully!';
            }
            
            header('Location: ' . BASE_URL . '/university-rep/events');
            exit;
            
        } catch (Exception $e) {
            error_log("University Representative Event Delete Error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to delete event. Please try again.';
            header('Location: ' . BASE_URL . '/university-rep/events');
            exit;
        }
    }

    // ========================================
    // ANNOUNCEMENTS MANAGEMENT
    // ========================================

    // List all announcements
    public function announcements() {
        view('UniversityRepresentative/announcements');
    }

    // Show create announcement form
    public function createAnnouncement() {
        view('UniversityRepresentative/create-announcement');
    }

    // Store announcement
    public function storeAnnouncement() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/announcements');
            exit;
        }

        // TODO: Add database logic here
        
        $_SESSION['success'] = 'Announcement created successfully!';
        header('Location: ' . BASE_URL . '/university-rep/announcements');
        exit;
    }

    // Delete announcement
    public function deleteAnnouncement() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/announcements');
            exit;
        }

        // TODO: Add database logic here
        
        $_SESSION['success'] = 'Announcement deleted successfully!';
        header('Location: ' . BASE_URL . '/university-rep/announcements');
        exit;
    }

    // ========================================
    // RESOURCES MANAGEMENT
    // ========================================

    // List all resources
    public function resources() {
        view('UniversityRepresentative/resources');
    }

    // Show create resource form
    public function createResource() {
        view('UniversityRepresentative/create-resource');
    }

    // Store resource
    public function storeResource() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/resources');
            exit;
        }

        // TODO: Add database logic here
        // Handle file uploads
        
        $_SESSION['success'] = 'Resource uploaded successfully!';
        header('Location: ' . BASE_URL . '/university-rep/resources');
        exit;
    }

    // Delete resource
    public function deleteResource() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/resources');
            exit;
        }

        // TODO: Add database logic here
        
        $_SESSION['success'] = 'Resource deleted successfully!';
        header('Location: ' . BASE_URL . '/university-rep/resources');
        exit;
    }

    // ========================================
    // UNIVERSITY PROFILE
    // ========================================

    public function universityProfile() {
        view('UniversityRepresentative/university-profile');
    }

    public function updateUniversityProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/university-profile');
            exit;
        }

        // TODO: Add database logic here
        
        $_SESSION['success'] = 'University profile updated successfully!';
        header('Location: ' . BASE_URL . '/university-rep/university-profile');
        exit;
    }

    // ========================================
    // ANALYTICS
    // ========================================

    public function analytics() {
        view('UniversityRepresentative/analytics');
    }

    // ========================================
    // PROFILE MANAGEMENT
    // ========================================

    public function profile() {
        view('UniversityRepresentative/profile');
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/university-rep/profile');
            exit;
        }

        // TODO: Add database logic here
        
        $_SESSION['success'] = 'Profile updated successfully!';
        header('Location: ' . BASE_URL . '/university-rep/profile');
        exit;
    }
}