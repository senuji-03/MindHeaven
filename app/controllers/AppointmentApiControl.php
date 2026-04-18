<?php
require_once BASE_PATH . '/app/models/Event.php';

class AppointmentApiControl
{
    private $appointmentModel;
    private $timeslotModel;
    private $eventModel;
    private $notificationModel;

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
        $this->timeslotModel = new Timeslot();
        $this->eventModel = new Event();
        $this->notificationModel = new Notification();
    }

    /**
     * List appointments for the currently logged-in student
     */
    public function listForStudent()
    {
        if (empty($_SESSION['user_id'])) {
            return $this->json(array('error' => 'Not logged in'), 401);
        }

        try {
            $rows = $this->appointmentModel->getByStudentUserId((int) $_SESSION['user_id']);
            $this->json($rows);
        } catch (Exception $e) {
            error_log("AppointmentApiControl listForStudent error: " . $e->getMessage());
            $this->json(array('error' => 'Failed to fetch appointments', 'detail' => $e->getMessage()), 500);
        }
    }

    /**
     * List appointments for the currently logged-in counselor
     */
    public function listForCounselor()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            return $this->json(array('error' => 'Not logged in'), 401);
        }

        try {
            $rows = $this->appointmentModel->getByCounselorUserId((int) $_SESSION['user_id']);

            // Map database rows to the structure expected by the counselor UI
            $appointments = array_map(function ($row) {
                return array(
                    'id' => isset($row['id']) ? (int) $row['id'] : null,
                    'patientName' => isset($row['student_name']) ? $row['student_name'] : 'Unknown student',
                    'reason' => isset($row['title']) ? $row['title'] : '',
                    'requestedDate' => isset($row['date']) ? $row['date'] : '',
                    'requestedTime' => isset($row['time']) ? $row['time'] : '',
                    'notes' => isset($row['notes']) ? $row['notes'] : '',
                    'email' => '',
                    'phone' => '',
                    'duration' => '60 minutes',
                    'mediaType' => (isset($row['mode']) && $row['mode']) ? $row['mode'] : 'audio_video',
                    'sessionType' => isset($row['type']) ? $row['type'] : 'individual',
                    'status' => isset($row['status']) ? $row['status'] : 'pending',
                    'rejectionReason' => isset($row['rejection_reason']) ? $row['rejection_reason'] : '',
                    'urgency' => 'medium',
                    'bookedDate' => isset($row['created_at']) ? $row['created_at'] : '',
                    'studentUserId' => isset($row['student_user_id']) ? (int) $row['student_user_id'] : null,
                    'originalDate' => isset($row['original_date']) ? $row['original_date'] : null,
                    'originalTime' => isset($row['original_time']) ? $row['original_time'] : null,
                );
            }, $rows);

            $this->json($appointments);
        } catch (Exception $e) {
            error_log("AppointmentApiControl listForCounselor error: " . $e->getMessage());
            $this->json(array('error' => 'Failed to fetch appointments', 'detail' => $e->getMessage()), 500);
        }
    }

    public function listCounselors()
    {
        try {
            $pdo = Database::getConnection();

            // First try to get counselors from the counselors table
            try {
                $stmt = $pdo->prepare("
                    SELECT u.id, u.username, c.full_name, c.specialization, c.is_available, (u.account_status = 'active') as is_approved
                    FROM users u 
                    INNER JOIN counselors c ON u.id = c.user_id 
                    WHERE u.role = 'counselor'
                    ORDER BY c.full_name
                ");
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($rows) > 0) {
                    $this->json($rows);
                    return;
                }
            } catch (Exception $e) {
                error_log("AppointmentApiControl: Counselors table query failed: " . $e->getMessage());
            }

            // Fallback: Get counselors from users table only
            $stmt = $pdo->prepare("
                SELECT id, username, full_name, '' as specialization, 1 as is_available, 1 as is_approved
                FROM users 
                WHERE role = 'counselor'
                ORDER BY full_name, username
            ");
            $stmt->execute();
            $this->json($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            error_log("AppointmentApiControl listCounselors error: " . $e->getMessage());
            $this->json(array('error' => 'Failed to fetch counselors', 'detail' => $e->getMessage()), 500);
        }
    }

    public function create()
    {
        $data = $this->getJsonInput();
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);

        if (!$userId) {
            return $this->json(array('error' => 'Not logged in'), 401);
        }

        // Validate required fields
        $required = array('counselor_user_id', 'title', 'type', 'date', 'time');
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->json(array('error' => "'$field' is required"), 400);
            }
        }

        // Normalise time to HH:MM:SS
        $timeVal = substr(trim((string) $data['time']), 0, 5);
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $timeVal)) {
            return $this->json(array('error' => 'Invalid time format.'), 400);
        }
        $dbTime = $timeVal . ':00';

        // Validate mode
        $allowedModes = array('audio_video', 'chat');
        $mode = trim((string) (isset($data['mode']) ? $data['mode'] : 'audio_video'));
        if (!in_array($mode, $allowedModes, true)) {
            $mode = 'audio_video';
        }

        try {
            $pdo = Database::getConnection();

            // ── Auto-migrate: add `mode` column if the table doesn't have it yet ──
            $cols = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'mode'")->fetchAll();
            if (empty($cols)) {
                $pdo->exec("ALTER TABLE appointments ADD COLUMN `mode` VARCHAR(20) NOT NULL DEFAULT 'audio_video' AFTER `type`");
                error_log('AppointmentApiControl: auto-added mode column to appointments table');
            }

            // Auto-migrate: reschedule_reason column and modify status enum if missing
            $cols = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'reschedule_reason'")->fetchAll();
            if (empty($cols)) {
                $pdo->exec("ALTER TABLE appointments ADD COLUMN `reschedule_reason` text DEFAULT NULL AFTER `rejection_reason`");
                $pdo->exec("ALTER TABLE appointments MODIFY COLUMN status ENUM('scheduled','confirmed','in_progress','completed','cancelled','no_show','pending','accept','accepted','reject','rejected','rescheduled') NOT NULL DEFAULT 'scheduled'");
                error_log('AppointmentApiControl: auto-added reschedule_reason and modified status enum');
            }

            // ── Validate that the slot exists in counselor_timeslots ──
            $slotCheck = $pdo->prepare("
                SELECT id, is_booked FROM counselor_timeslots
                WHERE counselor_user_id = ? AND slot_date = ? AND start_time = ?
            ");
            $slotCheck->execute(array((int) $data['counselor_user_id'], $data['date'], $dbTime));
            $slotRow = $slotCheck->fetch(PDO::FETCH_ASSOC);

            if (!$slotRow) {
                return $this->json(array('error' => 'This time slot is not available. The counselor has not set this slot for the selected date.'), 400);
            }
            if ($slotRow['is_booked']) {
                return $this->json(array('error' => 'This time slot is already booked. Please choose another.'), 409);
            }

            $id = $this->appointmentModel->create(
                $userId,
                (int) $data['counselor_user_id'],
                trim((string) $data['title']),
                trim((string) $data['type']),
                $mode,
                $data['date'],
                $dbTime,
                trim((string) (isset($data['notes']) ? $data['notes'] : ''))
            );

            if ($id) {
                // Mark the timeslot as frozen
                $this->timeslotModel->markFrozen((int) $data['counselor_user_id'], $data['date'], $dbTime);

                // Notify Counselor
                $this->notificationModel->create(
                    (int) $data['counselor_user_id'],
                    "New appointment booked: " . trim((string) $data['title']) . " for " . $data['date'],
                    'appointment_booked',
                    $id,
                    $userId
                );

                $this->json(array('message' => 'Appointment created', 'id' => $id), 201);
            } else {
                $this->json(array('error' => 'Database insert returned no ID'), 500);
            }
        } catch (Exception $e) {
            error_log('AppointmentApiControl create error: ' . $e->getMessage());
            $this->json(array(
                'error' => 'Failed to create appointment',
                'detail' => $e->getMessage()
            ), 500);
        }
    }

    /**
     * GET /api/appointments/slots?counselor_id=X&date=YYYY-MM-DD
     * Returns counselor-defined timeslots for the given date, marking booked ones.
     */
    public function getSlots()
    {
        $counselorIdInput = isset($_GET['counselor_id']) ? $_GET['counselor_id'] : 0;
        $date = isset($_GET['date']) ? $_GET['date'] : '';

        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

        if ($counselorIdInput === 'self') {
            if (!$userId || $role !== 'counselor') {
                return $this->json(array('error' => 'Unauthorized'), 401);
            }
            $counselorId = $userId;
        } else {
            $counselorId = (int) $counselorIdInput;
        }

        if (!$counselorId || !$date) {
            return $this->json(array('error' => 'counselor_id and date are required'), 400);
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->json(array('error' => 'Invalid date format'), 400);
        }

        try {
            $pdo = Database::getConnection();

            // Fetch counselor-defined slots
            $stmt = $pdo->prepare("
                SELECT
                    id,
                    TIME_FORMAT(start_time, '%H:%i') AS start_time,
                    TIME_FORMAT(end_time,   '%H:%i') AS end_time,
                    TIME_FORMAT(start_time, '%H:%i:%s') AS start_time_full,
                    slot_type,
                    is_booked,
                    is_frozen
                FROM counselor_timeslots
                WHERE counselor_user_id = ? AND slot_date = ?
                ORDER BY start_time ASC
            ");
            $stmt->execute(array($counselorId, $date));
            $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->json(array('slots' => $slots));
        } catch (Exception $e) {
            error_log("AppointmentApiControl getSlots error: " . $e->getMessage());
            $this->json(array('slots' => array()));
        }
    }

    /**
     * PUT /api/appointments/update
     * Student can edit their own appointment's title, type, mode, date, time, notes.
     */
    public function update()
    {
        $data = $this->getJsonInput();
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);

        if (!$userId) {
            return $this->json(array('error' => 'Not logged in'), 401);
        }

        if (empty($data['id'])) {
            return $this->json(array('error' => 'Appointment ID is required'), 400);
        }

        $required = array('title', 'type', 'date', 'time');
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->json(array('error' => "'$field' is required"), 400);
            }
        }

        // Normalise time
        $timeVal = substr(trim((string) $data['time']), 0, 5);
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $timeVal)) {
            return $this->json(array('error' => 'Invalid time format.'), 400);
        }
        $dbTime = $timeVal . ':00';

        // Normalise mode
        $allowedModes = array('audio_video', 'chat');
        $mode = trim((string) (isset($data['mode']) ? $data['mode'] : 'audio_video'));
        if (!in_array($mode, $allowedModes, true)) {
            $mode = 'audio_video';
        }

        try {
            // Fetch old appointment details for timeslot logic
            $oldApp = $this->appointmentModel->getById((int) $data['id']);

            $updated = $this->appointmentModel->update(
                (int) $data['id'],
                trim((string) $data['title']),
                trim((string) $data['type']),
                $mode,
                $data['date'],
                $dbTime,
                trim((string) (isset($data['notes']) ? $data['notes'] : '')),
                $userId   // ownership check
            );

            if ($updated) {
                // If date or time changed, update timeslot statuses
                if ($oldApp && ($oldApp['date'] !== $data['date'] || $oldApp['time'] !== $dbTime)) {
                    // Free old slot
                    $this->timeslotModel->markFree(
                        (int) $oldApp['counselor_user_id'],
                        $oldApp['date'],
                        $oldApp['time']
                    );
                    // Freeze new slot
                    $this->timeslotModel->markFrozen(
                        (int) $oldApp['counselor_user_id'],
                        $data['date'],
                        $dbTime
                    );
                }
                $this->json(array('message' => 'Appointment updated'));
            } else {
                $this->json(array('error' => 'Appointment not found or no changes made'), 404);
            }
        } catch (Exception $e) {
            error_log('AppointmentApiControl update error: ' . $e->getMessage());
            $this->json(array('error' => 'Failed to update appointment', 'detail' => $e->getMessage()), 500);
        }
    }

    public function reschedule()
    {
        $data = $this->getJsonInput();
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

        if (!$userId) {
            return $this->json(array('error' => 'Not logged in'), 401);
        }

        if (empty($data['id']) || empty($data['date']) || empty($data['time']) || empty($data['reason'])) {
            return $this->json(array('error' => 'Missing required fields'), 400);
        }

        // Parse time slot
        $timeVal = substr(trim((string) $data['time']), 0, 5);
        if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $timeVal)) {
            return $this->json(array('error' => 'Invalid time format. Use HH:MM.'), 400);
        }
        $dbTime = $timeVal . ':00';

        try {
            // Fetch appointment to check current status and owner
            $appointment = $this->appointmentModel->getById((int) $data['id']);
            if (!$appointment) {
                return $this->json(array('error' => 'Appointment not found'), 404);
            }

            // Authorization
            if ($role === 'counselor' && (int) $appointment['counselor_user_id'] !== $userId) {
                return $this->json(array('error' => 'Unauthorized'), 403);
            }

            // Status Check: Can only reschedule if pending or accepted
            $status = strtolower($appointment['status']);
            if ($status !== 'pending' && $status !== 'accept' && $status !== 'accepted') {
                return $this->json(array('error' => 'Only pending or accepted appointments can be rescheduled. Current status: ' . $status), 400);
            }

            // 1. Check for overlap/max-6 for the NEW slot
            // If the slot is the same, we skip these checks
            if ($appointment['date'] !== $data['date'] || $appointment['time'] !== $dbTime) {

                // Fetch timeslots for the new date to check availability
                $slots = $this->timeslotModel->getByDate($appointment['counselor_user_id'], $data['date']);

                // Check if the specific slot already exists
                $targetSlot = null;
                foreach ($slots as $s) {
                    if ($s['start_time'] === $dbTime) {
                        $targetSlot = $s;
                        break;
                    }
                }

                if ($targetSlot) {
                    // Slot exists. Check if it's already booked or frozen (by another appointment)
                    if ($targetSlot['is_booked'] || $targetSlot['is_frozen']) {
                        return $this->json(array('error' => 'The selected timeslot is already booked or frozen by another appointment.'), 409);
                    }
                } else {
                    // Slot doesn't exist. Check max 6 limit
                    if (count($slots) >= 6) {
                        return $this->json(array('error' => 'Maximum 6 timeslots per day reached for the selected date.'), 400);
                    }

                    // Slot doesn't exist. Check overlap
                    // We need a way to check overlap without creating. 
                    // Let's use a simpler check: duration is 1 hour (fixed) or we check against existing ones.
                    // Usually, slots are 1 hour.
                    $newStart = strtotime($data['date'] . ' ' . $dbTime);
                    $newEnd = $newStart + 3600; // Assume 1 hour

                    foreach ($slots as $s) {
                        $sStart = strtotime($data['date'] . ' ' . $s['start_time']);
                        $sEnd = strtotime($data['date'] . ' ' . $s['end_time']);
                        if ($newStart < $sEnd && $newEnd > $sStart) {
                            return $this->json(array('error' => 'The selected time overlaps with an existing timeslot.'), 409);
                        }
                    }
                }

                // 2. Perform Timeslot Updates
                // Free the OLD slot
                $this->timeslotModel->markFree(
                    (int) $appointment['counselor_user_id'],
                    $appointment['date'],
                    $appointment['time']
                );

                // Initialize the NEW slot
                if (!$targetSlot) {
                    // Create a custom slot (it will be 1 hour by default if we use this method, 
                    // or we can explicitly calculate end time)
                    $endTime = date('H:i:s', $newEnd);
                    $this->timeslotModel->createCustom(
                        (int) $appointment['counselor_user_id'],
                        $data['date'],
                        $dbTime,
                        $endTime
                    );
                }

                // Mark the new slot as frozen (awaiting student acceptance)
                $this->timeslotModel->markFrozen(
                    (int) $appointment['counselor_user_id'],
                    $data['date'],
                    $dbTime
                );
            }

            // 3. Calendar Synchronization & Conflict Check
            $force = isset($data['force']) && $data['force'] === true;

            // Check for potential conflicts in the counselor's calendar
            if ($this->eventModel->checkTimeConflict($appointment['counselor_user_id'], $data['date'], $dbTime)) {
                if (!$force) {
                    return $this->json(array(
                        'status' => 'conflict',
                        'type' => 'calendar',
                        'message' => 'There is already an event in your calendar at this time. Do you want to reschedule anyway?'
                    ), 409);
                }
            }

            // Sync with calendar if it already exists for this appointment
            $this->eventModel->updateEventDateTimeByAppointmentId((int) $data['id'], $data['date'], $dbTime);

            // 4. Update Appointment
            $counselorId = ($role === 'counselor') ? $userId : null;
            $updated = $this->appointmentModel->reschedule(
                (int) $data['id'],
                $data['date'],
                $dbTime,
                $data['reason'],
                $counselorId
            );

            if ($updated) {
                // Notify Undergrad
                $this->notificationModel->create(
                    (int) $appointment['student_user_id'],
                    "Your appointment '" . $appointment['title'] . "' has been rescheduled by the counselor to " . $data['date'] . " at " . $dbTime . ".",
                    'appointment_rescheduled',
                    (int) $data['id'],
                    $userId
                );

                $this->json(array('message' => 'Appointment rescheduled and awaiting student acceptance.'));
            } else {
                $this->json(array('error' => 'Failed to update appointment record'), 500);
            }
        } catch (Exception $e) {
            error_log('AppointmentApiControl reschedule error: ' . $e->getMessage());
            $this->json(array('error' => 'Failed to reschedule appointment: ' . $e->getMessage()), 500);
        }
    }

    public function delete()
    {
        $data = $this->getJsonInput();
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);

        if (!isset($data['id'])) {
            return $this->json(array('error' => 'Appointment ID required'), 400);
        }

        try {
            // Fetch appointment details before deletion to free the timeslot
            $appointment = $this->appointmentModel->getById((int) $data['id']);
            if ($appointment) {
                $this->timeslotModel->markFree(
                    (int) $appointment['counselor_user_id'],
                    $appointment['date'],
                    $appointment['time']
                );
            }

            $result = $this->appointmentModel->delete((int) $data['id']);
            if ($result) {
                $this->json(array('message' => 'Appointment deleted'));
            } else {
                $this->json(array('error' => 'Appointment not found'), 404);
            }
        } catch (Exception $e) {
            error_log("AppointmentApiControl delete error: " . $e->getMessage());
            $this->json(array('error' => 'Failed to delete appointment'), 500);
        }
    }

    public function hide()
    {
        $data = $this->getJsonInput();
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

        if (!$userId || $role !== 'counselor') {
            return $this->json(array('error' => 'Unauthorized'), 401);
        }

        if (empty($data['id'])) {
            return $this->json(array('error' => 'Appointment ID is required'), 400);
        }

        try {
            $hidden = $this->appointmentModel->hideForCounselor((int) $data['id']);
            if ($hidden) {
                $this->json(array('message' => 'Appointment hidden for counselor'));
            } else {
                $this->json(array('error' => 'Appointment not found'), 404);
            }
        } catch (Exception $e) {
            error_log('AppointmentApiControl hide error: ' . $e->getMessage());
            $this->json(array('error' => 'Failed to hide appointment'), 500);
        }
    }

    public function updateStatus()
    {
        $data = $this->getJsonInput();

        if (!isset($data['id']) || $data['id'] === '') {
            return $this->json(array('error' => 'Appointment ID is required'), 400);
        }
        if (!isset($data['status']) || $data['status'] === '') {
            return $this->json(array('error' => 'Status is required'), 400);
        }

        $allowedStatuses = array('pending', 'accept', 'accepted', 'rejected', 'cancelled', 'scheduled', 'confirmed', 'rescheduled', 'completed', 'no_show');
        if (!in_array($data['status'], $allowedStatuses, true)) {
            return $this->json(array('error' => 'Invalid status value'), 400);
        }

        try {
            $rejectionReason = isset($data['rejectionReason']) ? $data['rejectionReason'] : null;

            // Capture status before update for notification logic
            $appointmentBefore = $this->appointmentModel->getById((int) $data['id']);
            $oldStatus = $appointmentBefore ? strtolower($appointmentBefore['status']) : null;

            $result = $this->appointmentModel->updateStatus((int) $data['id'], $data['status'], $rejectionReason);

            if ($result) {
                // Fetch appointment details to update corresponding timeslot AND notify
                $appointment = $this->appointmentModel->getById((int) $data['id']);
                if ($appointment) {
                    $status = strtolower($data['status']);

                    // Notify relevant party
                    if ($status === 'accepted' || $status === 'reject' || $status === 'rejected') {
                        if ($status === 'accepted') {
                            // If it was rescheduled, notify counselor that student accepted
                            if ($oldStatus === 'rescheduled') {
                                $this->notificationModel->create(
                                    (int) $appointment['counselor_user_id'],
                                    "Student accepted your rescheduled time for: " . $appointment['title'],
                                    'reschedule_accepted',
                                    (int) $data['id'],
                                    $appointment['student_user_id']
                                );
                            } else {
                                // Counselor accepted student's booking
                                $this->notificationModel->create(
                                    (int) $appointment['student_user_id'],
                                    "Your appointment '" . $appointment['title'] . "' has been accepted.",
                                    'appointment_accepted',
                                    (int) $data['id'],
                                    $appointment['counselor_user_id']
                                );
                            }
                        } else {
                            // Rejected
                            $this->notificationModel->create(
                                (int) $appointment['student_user_id'],
                                "Your appointment '" . $appointment['title'] . "' was rejected. Reason: " . ($rejectionReason ?: 'No reason provided'),
                                'appointment_rejected',
                                (int) $data['id'],
                                (int) $_SESSION['user_id']
                            );
                        }
                    }

                    if ($status === 'accept' || $status === 'accepted') {
                        $this->timeslotModel->markBooked(
                            (int) $appointment['counselor_user_id'],
                            $appointment['date'],
                            $appointment['time']
                        );

                        // Integrate Daily.co for audio/video appointments
                        if (
                            isset($appointment['mode']) &&
                            $appointment['mode'] === 'audio_video' &&
                            empty($appointment['meeting_link']) &&
                            defined('DAILY_API_KEY')
                        ) {
                            $dailyRoomName = 'mindheaven-session-' . $appointment['id'] . '-' . time();
                            $postData = array(
                                'name' => $dailyRoomName,
                                'properties' => array(
                                    'exp' => strtotime($appointment['date'] . ' ' . $appointment['time'] . ' +3 hours'),
                                    'enable_chat' => true
                                )
                            );

                            $ch = curl_init('https://api.daily.co/v1/rooms');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Authorization: Bearer ' . DAILY_API_KEY,
                                'Content-Type: application/json'
                            ));

                            $response = curl_exec($ch);
                            if (!curl_errno($ch)) {
                                $result = json_decode($response, true);
                                if (!empty($result['url'])) {
                                    $this->appointmentModel->updateMeetingLink((int) $appointment['id'], $result['url']);
                                    error_log("Daily.co room created successfully for appointment ID: " . $appointment['id']);
                                } else {
                                    error_log("Daily.co error: " . print_r($result, true));
                                }
                            } else {
                                error_log("Failed to connect to Daily.co API for appointment ID: " . $appointment['id']);
                            }
                            curl_close($ch);
                        }
                    } elseif ($status === 'rejected' || $status === 'cancelled' || $status === 'completed' || $status === 'no_show') {
                        // All terminal statuses free the slot
                        $this->timeslotModel->markFree(
                            (int) $appointment['counselor_user_id'],
                            $appointment['date'],
                            $appointment['time']
                        );
                    }
                }

                $this->json(array('message' => 'Appointment status updated'), 200);
            } else {
                $this->json(array('error' => 'Appointment not found or status unchanged'), 404);
            }
        } catch (Exception $e) {
            error_log("AppointmentApiControl updateStatus error: " . $e->getMessage());
            $this->json(array('error' => 'Failed to update appointment status', 'detail' => $e->getMessage()), 500);
        }
    }

    /**
     * POST /api/appointments/start-session
     * Counselor signals they are starting the session. Sets meeting_link and status to in_progress.
     */
    public function startSession()
    {
        $data = $this->getJsonInput();
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

        if (!$userId || $role !== 'counselor') {
            return $this->json(array('error' => 'Unauthorized'), 401);
        }

        if (empty($data['id']) || empty($data['meeting_link'])) {
            return $this->json(array('error' => 'Missing required fields (id, meeting_link)'), 400);
        }

        try {
            $appointment = $this->appointmentModel->getById((int) $data['id']);
            if (!$appointment) {
                return $this->json(array('error' => 'Appointment not found'), 404);
            }

            // Authorization: counselor must own this appointment
            if ((int) $appointment['counselor_user_id'] !== $userId) {
                return $this->json(array('error' => 'Unauthorized'), 403);
            }

            // Update meeting link (shared URL for chat room)
            $this->appointmentModel->updateMeetingLink((int) $data['id'], $data['meeting_link']);

            // Transition status to in_progress if it was accepted/confirmed
            $status = strtolower($appointment['status']);
            if (in_array($status, array('accept', 'accepted', 'scheduled', 'confirmed'))) {
                $this->appointmentModel->updateStatus((int) $data['id'], 'in_progress');
            }

            // Get Chat Session ID to link the notification directly to the room
            $chatModel = new Chat();
            $chatSessionId = $chatModel->findOrCreateSession((int) $appointment['counselor_user_id'], (int) $appointment['student_user_id']);

            // Notify Undergrad
            $this->notificationModel->create(
                (int) $appointment['student_user_id'],
                "Your counseling session for '" . $appointment['title'] . "' has started! Click here to join.",
                'session_started',
                (int) $chatSessionId,
                $userId
            );

            $this->json(array('success' => true, 'message' => 'Session started successfully.', 'session_id' => $chatSessionId));
        } catch (Exception $e) {
            error_log("AppointmentApiControl startSession error: " . $e->getMessage());
            $this->json(array('error' => 'Failed to start session: ' . $e->getMessage()), 500);
        }
    }

    /**
     * GET /api/counselor/session-history[?status=completed|cancelled|no_show|rescheduled]
     * Returns completed/cancelled/no_show/rescheduled sessions for the logged-in counselor.
     */
    public function getSessionHistory()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'counselor')) {
            return $this->json(array('error' => 'Unauthorized'), 401);
        }

        $counselorUserId = (int) $_SESSION['user_id'];

        // Optional single-status filter from query string
        $allowedFilters = array('completed', 'cancelled', 'no_show', 'rescheduled', 'overdue');
        $statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';

        // Normalise "no-show" -> "no_show" for consistency
        if ($statusFilter === 'no-show') {
            $statusFilter = 'no_show';
        }
        if (!in_array($statusFilter, $allowedFilters, true)) {
            $statusFilter = '';
        }

        try {
            $rows = $this->appointmentModel->getSessionHistory($counselorUserId, $statusFilter);
            $stats = $this->appointmentModel->getSessionHistoryStats($counselorUserId);

            // Map DB rows to the structure expected by the frontend
            $sessions = array_map(function ($row) {
                // Format time as h:i A
                $timeFormatted = !empty($row['time'])
                    ? date('g:i A', strtotime($row['time']))
                    : '';

                // --- Normalise display status ---
                $rawStatus = $row['status'];
                $displayStatus = $rawStatus;
                if ($rawStatus === 'no_show') {
                    $displayStatus = 'no-show';
                } elseif ($rawStatus === 'rejected') {
                    // Rejected appointments are shown as Cancelled in session history
                    $displayStatus = 'cancelled';
                }

                // --- Build notes field ---
                // Base notes
                $notes = $row['notes'] ?: '';

                // Append rejection reason (Cancelled/Rejected) into notes for display
                $rejectionReason = $row['rejection_reason'] ?: '';
                $rescheduleReason = isset($row['reschedule_reason']) ? $row['reschedule_reason'] : '';

                if ($displayStatus === 'cancelled' && !empty($rejectionReason)) {
                    $notes = ($notes ? $notes . "\n\n" : '') . 'Cancellation Reason: ' . $rejectionReason;
                } elseif ($displayStatus === 'rescheduled' && !empty($rescheduleReason)) {
                    $notes = ($notes ? $notes . "\n\n" : '') . 'Reschedule Reason: ' . $rescheduleReason;
                }

                return array(
                    'id' => $row['id'],
                    'userId' => 'U' . str_pad($row['student_user_id'], 5, '0', STR_PAD_LEFT),
                    'patientName' => $row['student_name'] ?: 'Unknown',
                    'date' => $row['date'],
                    'time' => $timeFormatted,
                    'duration' => '60 mins',
                    'status' => $displayStatus,
                    'sessionType' => ucfirst(str_replace('_', ' ', $row['type'] ?: 'individual')),
                    'notes' => $notes,
                    'counselorNotes' => $row['counselor_notes'] ?: '',
                    'reason' => $row['title'] ?: '',
                    'rejectionReason' => $rejectionReason,
                    'rescheduleReason' => $rescheduleReason,
                    'originalDate' => isset($row['original_date']) ? $row['original_date'] : null,
                    'originalTime' => isset($row['original_time']) ? $row['original_time'] : null,
                    'rawTime' => $row['time'],
                    'nextAppointment' => 'TBD',
                );
            }, $rows);

            $this->json(array(
                'success' => true,
                'sessions' => $sessions,
                'stats' => $stats,
            ));
        } catch (Exception $e) {
            error_log('AppointmentApiControl getSessionHistory error: ' . $e->getMessage());
            $this->json(array('error' => 'Failed to fetch session history', 'detail' => $e->getMessage()), 500);
        }
    }

    public function saveNotes()
    {
        $data = $this->getJsonInput();
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

        if (!$userId || $role !== 'counselor') {
            return $this->json(array('error' => 'Unauthorized'), 401);
        }

        if (empty($data['id'])) {
            return $this->json(array('error' => 'Appointment ID is required'), 400);
        }

        try {
            // Verify appointment belongs to this counselor
            $appointment = $this->appointmentModel->getById((int) $data['id']);
            if (!$appointment || (int) $appointment['counselor_user_id'] !== $userId) {
                return $this->json(array('error' => 'Appointment not found or access denied'), 403);
            }

            // Store the notes directly as text
            $notesText = isset($data['feedback_message']) ? $data['feedback_message'] : '';

            $result = $this->appointmentModel->updateCounselorNotes((int) $data['id'], $notesText);

            if ($result) {
                $this->json(array('success' => true, 'message' => 'Session notes saved successfully'));
            } else {
                $this->json(array('error' => 'Failed to save notes'), 500);
            }
        } catch (Exception $e) {
            error_log('AppointmentApiControl saveNotes error: ' . $e->getMessage());
            $this->json(array('error' => 'Failed to save session notes'), 500);
        }
    }

    public function getStudentHistory()
    {
        $userId = (int) (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

        if (!$userId || $role !== 'counselor') {
            return $this->json(array('error' => 'Unauthorized'), 401);
        }

        $studentId = isset($_GET['student_id']) ? (int) $_GET['student_id'] : 0;
        if (!$studentId) {
            return $this->json(array('error' => 'Student ID is required'), 400);
        }

        try {
            $history = $this->appointmentModel->getHistoryByStudentId($studentId);
            $this->json(array('success' => true, 'history' => $history));
        } catch (Exception $e) {
            error_log('AppointmentApiControl getStudentHistory error: ' . $e->getMessage());
            $this->json(array('error' => 'Failed to fetch student history'), 500);
        }
    }

    private function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function getJsonInput()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : array();
    }
}
