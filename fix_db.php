<?php
require 'config/config.php';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("DROP TABLE IF EXISTS resource_likes");
    $pdo->exec("CREATE TABLE resource_likes (
        user_id INT NOT NULL,
        resource_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (user_id, resource_id)
    )");
    echo "Fixed resource_likes table structure.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
