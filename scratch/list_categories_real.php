<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT name FROM resource_categories");
    $cats = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Current categories in resource_categories:\n";
    foreach ($cats as $c) {
        echo "- $c\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
