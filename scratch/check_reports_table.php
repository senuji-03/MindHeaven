<?php
require_once 'c:/xampp/htdocs/MindHeaven/config/config.php';
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check resource_reports
    $pdo->query('SELECT 1 FROM resource_reports LIMIT 1');
    echo "resource_reports: OK\n";
    
} catch (Exception $e) {
    echo "DB ERROR: " . $e->getMessage();
}
?>
