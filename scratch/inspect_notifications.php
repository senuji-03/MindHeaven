<?php
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/libraries/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("DESCRIBE notifications");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Current Notifications Table Structure:\n";
    echo str_repeat("-", 80) . "\n";
    printf("%-20s | %-15s | %-10s | %-5s | %-10s | %-10s\n", "Field", "Type", "Null", "Key", "Default", "Extra");
    echo str_repeat("-", 80) . "\n";
    foreach ($columns as $col) {
        printf("%-20s | %-15s | %-10s | %-5s | %-10s | %-10s\n", 
            $col['Field'], $col['Type'], $col['Null'], $col['Key'], $col['Default'], $col['Extra']);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
