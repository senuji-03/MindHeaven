<?php
require_once 'config/config.php';
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'counselor_notes'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE appointments ADD COLUMN counselor_notes TEXT NULL AFTER rejection_reason");
        echo "Added counselor_notes column.\n";
    } else {
        echo "counselor_notes column already exists.\n";
    }

    echo "Database update complete.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
