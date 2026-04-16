<?php
// scripts/sync_notifications_v2.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    
    echo "Running ALTER command to synchronize notifications table...\n";
    
    $sql = "ALTER TABLE notifications 
            MODIFY COLUMN sender_id INT(10) UNSIGNED DEFAULT NULL,
            MODIFY COLUMN type VARCHAR(50) DEFAULT NULL,
            MODIFY COLUMN related_id INT(10) UNSIGNED DEFAULT NULL";
    
    $pdo->exec($sql);
    
    echo "Success: Notifications table has been synchronized with teammate requirements.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
