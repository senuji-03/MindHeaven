<?php
require 'config/config.php';
require 'core/Database.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("DESCRIBE resource_likes");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
