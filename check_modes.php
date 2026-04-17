<?php
require 'config/config.php';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT DISTINCT mode FROM appointments");
    $modes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Distinct modes in database:\n";
    foreach ($modes as $m) {
        echo " - [" . bin2hex($m) . "] : " . $m . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
