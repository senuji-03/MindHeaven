<?php
define('BASE_PATH', __DIR__);
require_once 'config/config.php';
require_once 'core/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("DESCRIBE users");
    $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Table: users\n";
    foreach ($fields as $field) {
        printf("%-20s %-20s %-10s %-10s\n", $field['Field'], $field['Type'], $field['Null'], $field['Key']);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
