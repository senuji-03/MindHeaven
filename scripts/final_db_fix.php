<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysql = mysql_connect('localhost', 'root', '');
mysql_select_db('mindheaven_merged', $mysql);

$columns_to_check = array(
    'sender_id' => "ALTER TABLE notifications ADD COLUMN sender_id INT DEFAULT NULL AFTER user_id",
    'related_id' => "ALTER TABLE notifications ADD COLUMN related_id INT DEFAULT NULL AFTER type"
);

foreach ($columns_to_check as $col => $sql) {
    $result = mysql_query("SHOW COLUMNS FROM notifications LIKE '$col'");
    if (mysql_num_rows($result) == 0) {
        echo "Adding $col column...\n";
        if (mysql_query($sql)) {
            echo "Column $col added successfully.\n";
        } else {
            echo "Error adding column $col: " . mysql_error() . "\n";
        }
    } else {
        echo "Column $col already exists.\n";
    }
}

mysql_close($mysql);
?>
