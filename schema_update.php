<?php
require 'c:/xampp/htdocs/MindHeaven/config/config.php';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->exec("ALTER TABLE university_rep_events MODIFY COLUMN status enum('draft','published','cancelled','pending','approved','closed','rejected') DEFAULT 'pending'");
    echo "Success";
} catch (Exception $e) {
    echo $e->getMessage();
}
