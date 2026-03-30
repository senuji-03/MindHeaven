<?php
require 'c:/xampp/htdocs/MindHeaven/config/config.php';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $stmt = $pdo->query("SHOW COLUMNS FROM university_rep_events LIKE 'status'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($result);
} catch (Exception $e) {
    echo $e->getMessage();
}
