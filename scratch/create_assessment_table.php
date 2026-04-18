<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    
    $sql = "
    CREATE TABLE IF NOT EXISTS `assessment_results` (
      `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` int(10) UNSIGNED NOT NULL,
      `anxiety_score` int(11) NOT NULL,
      `depression_score` int(11) NOT NULL,
      `stress_score` int(11) NOT NULL,
      `total_score` int(11) NOT NULL,
      `interpretation` text NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`),
      KEY `idx_assessment_user` (`user_id`),
      CONSTRAINT `fk_assessment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";
    
    $pdo->exec($sql);
    echo "Table 'assessment_results' created or already exists.\n";
} catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}
