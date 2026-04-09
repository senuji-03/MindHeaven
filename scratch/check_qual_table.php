<?php
require_once 'config/config.php';
require_once 'core/Database.php';

try {
    $pdo = Database::getConnection();
    echo "Checking counselor_qualifications table...\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'counselor_qualifications'");
    if ($stmt->rowCount() > 0) {
        $cols = $pdo->query("DESCRIBE counselor_qualifications")->fetchAll(PDO::FETCH_ASSOC);
        print_r($cols);
    } else {
        echo "Table counselor_qualifications DOES NOT EXIST.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
