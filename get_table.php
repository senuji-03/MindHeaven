<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$pdo = Database::getConnection();
$stmt = $pdo->query("SHOW CREATE TABLE appointments");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo $row['Create Table'];
