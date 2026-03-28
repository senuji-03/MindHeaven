<?php
require 'c:/xampp/htdocs/MindHeaven/core/Database.php';
require 'c:/xampp/htdocs/MindHeaven/config/config.php';
try {
    $db = Database::getConnection();
    $stmt = $db->query("DESCRIBE users");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo $e->getMessage();
}
