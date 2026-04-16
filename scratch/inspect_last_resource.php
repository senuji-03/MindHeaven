<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mindheaven_merged');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check table structure
    echo "--- Table Structure: resource_hub ---\n";
    $stmt = $pdo->query("DESCRIBE resource_hub");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $col) {
        echo "{$col['Field']} - {$col['Type']} - NULL: {$col['Null']}\n";
    }
    
    // Check last record
    echo "\n--- Last Record ---\n";
    $stmt = $pdo->query("SELECT * FROM resource_hub ORDER BY id DESC LIMIT 1");
    $last = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($last) {
        print_r($last);
    } else {
        echo "No records found in resource_hub.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
