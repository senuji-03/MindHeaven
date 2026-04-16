<?php
require_once 'c:/xampp/htdocs/MindHeaven/config/config.php';
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check resource_comments
    try {
        $pdo->query('SELECT 1 FROM resource_comments LIMIT 1');
        echo "resource_comments: OK\n";
    } catch (Exception $e) {
        echo "resource_comments ERROR: " . $e->getMessage() . "\n";
    }

    // Check resource_likes
    try {
        $pdo->query('SELECT 1 FROM resource_likes LIMIT 1');
        echo "resource_likes: OK\n";
    } catch (Exception $e) {
        echo "resource_likes ERROR: " . $e->getMessage() . "\n";
    }
} catch (Exception $e) {
    echo "DB ERROR: " . $e->getMessage();
}
?>
