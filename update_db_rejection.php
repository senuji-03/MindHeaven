<?php
require_once 'config/config.php';
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if columns exist first
    $stmt = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'rejection_reason'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE appointments ADD COLUMN rejection_reason TEXT NULL AFTER status");
        echo "Added rejection_reason column.\n";
    } else {
        echo "rejection_reason column already exists.\n";
    }

    $stmt = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'hidden_by_counselor'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE appointments ADD COLUMN hidden_by_counselor TINYINT(1) DEFAULT 0 AFTER rejection_reason");
        echo "Added hidden_by_counselor column.\n";
    } else {
        echo "hidden_by_counselor column already exists.\n";
    }

    echo "Database update complete.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
