<?php
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/app/config/config.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SHOW COLUMNS FROM crisis_calls");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($columns);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
