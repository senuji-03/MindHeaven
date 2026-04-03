<?php
require_once __DIR__ . '/core/Database.php';

try {
    $pdo = Database::getConnection();
    
    $tables = ['habits', 'habit_completions', 'habit_streaks'];
    
    foreach ($tables as $table) {
        echo "Table: $table\n";
        try {
            $stmt = $pdo->query("DESCRIBE $table");
            print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            echo "Error describing $table: " . $e->getMessage() . "\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "Connection error: " . $e->getMessage();
}
