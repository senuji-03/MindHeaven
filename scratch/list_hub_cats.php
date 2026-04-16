<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT DISTINCT category FROM resource_hub");
    $cats = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Categories in resource_hub:\n";
    foreach ($cats as $c) {
        echo "- $c\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
