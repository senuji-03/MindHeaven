<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query('SHOW CREATE TABLE users');
    print_r($stmt->fetch());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
