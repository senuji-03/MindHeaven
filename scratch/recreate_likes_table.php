<?php
require_once 'c:/xampp/htdocs/MindHeaven/config/config.php';
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // First try to drop if exists
    try {
        $pdo->exec("DROP TABLE IF EXISTS resource_likes");
        echo "Dropped resource_likes successfully.\n";
    } catch (Exception $e) {
        echo "Drop failed: " . $e->getMessage() . "\n";
    }

    $sql = "CREATE TABLE `resource_likes` (
        `resource_id` int(10) unsigned NOT NULL,
        `user_id` int(10) unsigned NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`resource_id`,`user_id`),
        CONSTRAINT `fk_res_likes_resource` FOREIGN KEY (`resource_id`) REFERENCES `resource_hub` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
      
    $pdo->exec($sql);
    echo "Created resource_likes table successfully.\n";
} catch (Exception $e) {
    echo "DB ERROR: " . $e->getMessage();
}
?>
