<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // Check columns
    $stmt = $pdo->query("SHOW COLUMNS FROM notifications");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Columns in 'notifications' table:\n";
    $hasSenderId = false;
    foreach ($columns as $col) {
        echo "- " . $col['Field'] . "\n";
        if ($col['Field'] === 'sender_id') {
            $hasSenderId = true;
        }
    }
    
    if (!$hasSenderId) {
        echo "\nFixing: Adding 'sender_id' column...\n";
        $pdo->exec("ALTER TABLE notifications ADD COLUMN sender_id INT DEFAULT NULL AFTER user_id");
        echo "Column 'sender_id' added successfully.\n";
    } else {
        echo "\n'sender_id' column already exists.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
