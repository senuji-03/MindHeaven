<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

$hash = '$2y$10$/r4M04L/rqS2QnEWuAH3wOoUzH27yHTgGHJIroO/QV9I9CLq.F77i'; // Responder@123
$pdo  = Database::getConnection();
$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'responder1'");
$stmt->execute([$hash]);
echo "Password updated. Rows affected: " . $stmt->rowCount() . PHP_EOL;

// Verify
$stmt2 = $pdo->query("SELECT password FROM users WHERE username='responder1'");
$row = $stmt2->fetch();
echo "Verify: " . (password_verify('Responder@123', $row['password']) ? 'OK' : 'FAIL') . PHP_EOL;
