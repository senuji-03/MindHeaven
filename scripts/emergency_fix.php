<?php
$host = 'localhost';
$db   = 'mindheaven_merged';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = array(
    PDO::ATTR_ERR_MODE            => PDO::ERR_MODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
);

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo "Connected to database.\n";
     
     // Check if column exists
     $stmt = $pdo->query("SHOW COLUMNS FROM notifications LIKE 'sender_id'");
     if (!$stmt->fetch()) {
         echo "Adding sender_id column...\n";
         $pdo->exec("ALTER TABLE notifications ADD COLUMN sender_id INT DEFAULT NULL AFTER user_id");
         echo "Column added successfully.\n";
     } else {
         echo "Column sender_id already exists.\n";
     }
} catch (PDOException $e) {
     echo "Error: " . $e->getMessage() . "\n";
}
