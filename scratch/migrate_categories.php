<?php
// scratch/migrate_categories.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // 1. Add thumbnail column if it doesn't exist
    $stmt = $pdo->query("SHOW COLUMNS FROM resource_categories LIKE 'thumbnail'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE resource_categories ADD COLUMN thumbnail VARCHAR(255) DEFAULT NULL");
        echo "Successfully added 'thumbnail' column to resource_categories table.\n";
    } else {
        echo "'thumbnail' column already exists.\n";
    }

    // 2. Create upload directory
    $uploadDir = __DIR__ . '/../public/uploads/categories';
    if (!file_exists($uploadDir)) {
        if (mkdir($uploadDir, 0777, true)) {
            echo "Successfully created category upload directory.\n";
            file_put_contents($uploadDir . '/index.html', '');
        } else {
            echo "Failed to create category upload directory.\n";
        }
    } else {
        echo "Category upload directory already exists.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
