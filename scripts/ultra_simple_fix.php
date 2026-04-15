<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysql = mysql_connect('localhost', 'root', '');
if (!$mysql) {
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('mindheaven_merged', $mysql);
if (!$db_selected) {
    die ('Can\'t use db : ' . mysql_error());
}

$result = mysql_query("SHOW COLUMNS FROM notifications LIKE 'sender_id'");
if (mysql_num_rows($result) == 0) {
    echo "Adding sender_id column...\n";
    $alter = mysql_query("ALTER TABLE notifications ADD COLUMN sender_id INT DEFAULT NULL AFTER user_id");
    if ($alter) {
        echo "Column added successfully.\n";
    } else {
        echo "Error adding column: " . mysql_error();
    }
} else {
    echo "Column sender_id already exists.\n";
}

mysql_close($mysql);
?>
