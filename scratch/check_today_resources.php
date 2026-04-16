<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mindheaven_merged');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "--- All Resources Created Today ---\n";
    $stmt = $pdo->query("SELECT id, title, category, content_type, status, created_at, file_path FROM resource_hub WHERE DATE(created_at) = CURDATE() ORDER BY id DESC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows as $row) {
        print_r($row);
        echo "-------------------\n";
    }
    
    if (empty($rows)) {
        echo "No resources found for today.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
