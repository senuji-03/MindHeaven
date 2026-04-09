<?php
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'app/models/Appointment.php';
require_once 'app/models/Timeslot.php';

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    die("DB connection failed: " . $e->getMessage());
}

$appointmentModel = new Appointment();
$timeslotModel = new Timeslot();

$studentId = 15; // Assuming a valid student ID
$counselorId = 13; // Assuming a valid counselor ID
$date = '2026-04-15';
$time = '10:00:00';

echo "1. Creating a test appointment...\n";
$appId = $appointmentModel->create(
    $studentId,
    $counselorId,
    'Reschedule Test',
    'individual',
    'audio_video',
    $date,
    $time,
    'Initial notes'
);
echo "   Appointment Created with ID: $appId\n";

echo "2. Marking initial timeslot as frozen...\n";
$timeslotModel->markFrozen($counselorId, $date, $time);

echo "3. Rescheduling by counselor...\n";
$newDate = '2026-04-16';
$newTime = '11:00:00';
$reason = 'Doctor has an emergency';

// Simulate the logic in AppointmentApiControl::reschedule
// Free old slot
$timeslotModel->markFree($counselorId, $date, $time);
// Create/Freeze new slot
$timeslotModel->createCustom($counselorId, $newDate, $newTime, '12:00:00');
$timeslotModel->markFrozen($counselorId, $newDate, $newTime);
// Update appointment
$rescheduled = $appointmentModel->reschedule($appId, $newDate, $newTime, $reason, $counselorId);

if ($rescheduled) {
    echo "   Appointment Rescheduled Successfully.\n";
} else {
    echo "   Failed to reschedule.\n";
}

// Verify database state
$app = $appointmentModel->getById($appId);
echo "   New Status: " . $app['status'] . "\n";
echo "   New Reason: " . $app['reschedule_reason'] . "\n";

echo "4. Student accepting reschedule...\n";
// Simulate student accepting
$appointmentModel->updateStatus($appId, 'accepted');
$timeslotModel->markBooked($counselorId, $newDate, $newTime);

$appFinal = $appointmentModel->getById($appId);
echo "   Final Status: " . $appFinal['status'] . "\n";

echo "\nVerification complete.\n";
