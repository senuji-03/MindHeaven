<?php
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'app/models/Event.php';
require_once 'app/models/Appointment.php';

// Mock session
session_start();
$_SESSION['user_id'] = 1;

$eventModel = new Event();
$appointmentModel = new Appointment();

echo "1. Creating test appointment...\n";
$appointmentId = $appointmentModel->create(2, 1, 'Test Session', 'standard', 'audio_video', '2026-05-01', '10:00:00', 'Original note');
echo "   ID: $appointmentId\n";

echo "2. Saving to calendar...\n";
$eventModel->createEvent(array(
    'counselor_user_id' => 1,
    'title' => 'Session with Test',
    'event_date' => '2026-05-01',
    'event_time' => '10:00:00',
    'priority' => 'normal',
    'description' => 'Original',
    'appointment_id' => $appointmentId
));

echo "3. Creating a conflicting event at 11:00...\n";
$eventModel->createEvent(array(
    'counselor_user_id' => 1,
    'title' => 'Conflicting Lunch',
    'event_date' => '2026-05-01',
    'event_time' => '11:00:00',
    'priority' => 'high',
    'description' => 'Eat fast',
    'appointment_id' => null
));

echo "4. Simulating Reschedule (No Force) to 11:00...\n";
// We'll simulate the controller logic manually
$newDate = '2026-05-01';
$newTime = '11:00:00';
$force = false;

$conflict = $eventModel->checkTimeConflict(1, $newDate, $newTime);
if ($conflict && !$force) {
    echo "   [SUCCESS] Conflict detected as expected!\n";
} else {
    echo "   [FAILURE] Conflict NOT detected.\n";
}

echo "5. Simulating Reschedule (With Force) to 11:00...\n";
$force = true;
if (!$conflict || $force) {
    $updated = $eventModel->updateEventDateTimeByAppointmentId($appointmentId, $newDate, $newTime);
    if ($updated) {
        echo "   [SUCCESS] Calendar updated with force!\n";
    } else {
        echo "   [FAILURE] Calendar update failed.\n";
    }
}

echo "6. Verifying final calendar state...\n";
$rescheduledEvent = null;
$events = $eventModel->getEventsByCounselor(1);
foreach ($events as $e) {
    if ($e->appointment_id == $appointmentId) {
        $rescheduledEvent = $e;
        break;
    }
}

if ($rescheduledEvent && $rescheduledEvent->event_time == '11:00:00') {
    echo "   Final Time: " . $rescheduledEvent->event_time . " [CORRECT]\n";
} else {
    echo "   Final State incorrect.\n";
}

echo "\nCleaning up...\n";
// (Optional cleanup)
?>
