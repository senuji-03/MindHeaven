<?php
require_once 'app/config/config.php';
require_once 'app/libraries/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("DESCRIBE counselors");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo $column['Field'] . " - " . $column['Type'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
