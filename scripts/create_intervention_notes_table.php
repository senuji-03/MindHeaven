<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();

    // Create the crisis_intervention_notes table
    $sql = "CREATE TABLE IF NOT EXISTS crisis_intervention_notes (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        crisis_call_id INT(10) UNSIGNED NOT NULL,
        counselor_user_id INT(10) UNSIGNED NOT NULL,
        notes TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (crisis_call_id),
        INDEX (counselor_user_id),
        FOREIGN KEY (crisis_call_id) REFERENCES crisis_calls(id) ON DELETE CASCADE,
        FOREIGN KEY (counselor_user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo "Successfully created 'crisis_intervention_notes' table.\n";

} catch (Exception $e) {
    die("Error creating table: " . $e->getMessage() . "\n");
}
