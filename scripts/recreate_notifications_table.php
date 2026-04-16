<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysql = mysql_connect('localhost', 'root', '');
if (!$mysql) die('Connection failed: ' . mysql_error());

if (!mysql_select_db('mindheaven_merged', $mysql)) die('DB select failed: ' . mysql_error());

echo "Dropping notifications table...\n";
mysql_query("DROP TABLE IF EXISTS notifications", $mysql);

echo "Recreating notifications table with full schema...\n";
$sql = "CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sender_id INT DEFAULT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50) NOT NULL,
    related_id INT DEFAULT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (user_id),
    INDEX (is_read),
    INDEX (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysql_query($sql, $mysql)) {
    echo "Notifications table created successfully!\n";
} else {
    echo "Error creating table: " . mysql_error() . "\n";
}

mysql_close($mysql);
?>
