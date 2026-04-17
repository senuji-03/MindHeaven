<?php
define('BASE_PATH', __DIR__);
require_once 'config/config.php';
require_once 'core/Database.php';

try {
    $pdo = Database::getConnection();
    $db = $pdo->query("SELECT DATABASE()")->fetchColumn();
    echo "Connected to database: $db\n";
    
    $stmt = $pdo->query("SELECT title, category, status FROM resource_hub");
    $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Resources in DB:\n";
    print_r($resources);
    
    $stmt = $pdo->query("SELECT * FROM resources");
    $otherResources = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Alternative resources table:\n";
    print_r($otherResources);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
