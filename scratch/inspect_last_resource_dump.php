<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mindheaven_merged');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check last record with var_dump
    echo "--- Last Record (Detailed) ---\n";
    $stmt = $pdo->query("SELECT * FROM resource_hub ORDER BY id DESC LIMIT 1");
    $last = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($last) {
        var_dump($last);
    } else {
        echo "No records found.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
