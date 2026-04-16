<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mindheaven_merged');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check table structure with full details
    echo "--- Full Table Structure: resource_hub ---\n";
    $stmt = $pdo->query("SHOW FULL COLUMNS FROM resource_hub");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo str_pad("Field", 20) . str_pad("Type", 20) . str_pad("Null", 10) . str_pad("Default", 20) . "Extra\n";
    echo str_repeat("-", 80) . "\n";
    foreach ($cols as $col) {
        echo str_pad($col['Field'], 20) . 
             str_pad($col['Type'], 20) . 
             str_pad($col['Null'], 10) . 
             str_pad($col['Default'], 20) . 
             $col['Extra'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
