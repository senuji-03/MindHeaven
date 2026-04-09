<?php
require 'config/config.php';
require 'core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // 1. Add 'rescheduled' to status enum
    // First, let's get the current definition to be safe
    $stmt = $pdo->query("DESCRIBE appointments status");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $type = $row['Type']; // e.g. enum('a','b')
    
    if (strpos($type, "'rescheduled'") === false) {
        $newType = str_replace(")", ",'rescheduled')", $type);
        $pdo->exec("ALTER TABLE appointments MODIFY COLUMN status $newType NOT NULL DEFAULT 'pending'");
        echo "Status enum updated.\n";
    } else {
        echo "Status 'rescheduled' already exists.\n";
    }
    
    // 2. Add reschedule_reason column if not exists
    $stmt = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'reschedule_reason'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE appointments ADD COLUMN reschedule_reason TEXT NULL AFTER rejection_reason");
        echo "reschedule_reason column added.\n";
    } else {
        echo "reschedule_reason column already exists.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
