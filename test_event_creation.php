<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/autoload.php';
require_once __DIR__ . '/core/Database.php';

echo "Testing event creation directly:\n";

try {
    $db = Database::getConnection();
    $sql = "INSERT INTO events (counselor_id, title, event_date, event_time, priority, description, created_at) 
            VALUES (1, 'Test Event', '2025-10-22', '14:00:00', 'normal', 'Test event description', NOW())";
    
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();
    
    if ($result) {
        $eventId = $db->lastInsertId();
        echo "✅ Event created successfully with ID: $eventId\n";
        
        // Verify the event was created
        $sql = "SELECT * FROM events WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$eventId]);
        $event = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($event) {
            echo "✅ Event verified in database:\n";
            echo "   - Title: {$event->title}\n";
            echo "   - Date: {$event->event_date}\n";
            echo "   - Time: {$event->event_time}\n";
            echo "   - Priority: {$event->priority}\n";
            echo "   - Description: {$event->description}\n";
        } else {
            echo "❌ Event not found in database\n";
        }
    } else {
        echo "❌ Failed to create event\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
