<?php
// scratch/fix_categories.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // 1. Get unique categories from resource_hub
    $stmt = $pdo->query("SELECT DISTINCT category FROM resource_hub WHERE category IS NOT NULL AND category != ''");
    $cats = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Found " . count($cats) . " unique categories in resource_hub.\n";
    
    foreach ($cats as $c) {
        // 2. Insert into resource_categories if not exists
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM resource_categories WHERE name = ?");
        $stmtCheck->execute(array($c));
        if ($stmtCheck->fetchColumn() == 0) {
            $stmtInsert = $pdo->prepare("INSERT INTO resource_categories (name, is_active) VALUES (?, 1)");
            $stmtInsert->execute(array($c));
            echo "Inserted missing category: $c\n";
        } else {
            // Ensure it's active
            $pdo->prepare("UPDATE resource_categories SET is_active = 1 WHERE name = ?")->execute(array($c));
            echo "Category exists, ensured active: $c\n";
        }
    }
    
    echo "Migration complete.\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
