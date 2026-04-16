<?php
// scratch/test_hub_data.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/ResourceHub.php';

try {
    $rh = new ResourceHub();
    $cats = $rh->getCategories();
    
    echo "--- Category Data ---\n";
    if (empty($cats)) {
        echo "NO CATEGORIES RETURNED FROM MODEL!\n";
        
        // Debug the table directly
        $pdo = Database::getConnection();
        $res = $pdo->query("SELECT * FROM resource_categories")->fetchAll(PDO::FETCH_ASSOC);
        echo "Raw table content (" . count($res) . " rows):\n";
        print_r($res);
        
        $desc = $pdo->query("DESCRIBE resource_categories")->fetchAll(PDO::FETCH_ASSOC);
        echo "Table structure:\n";
        print_r($desc);
    } else {
        echo "Found " . count($cats) . " active categories:\n";
        foreach ($cats as $c) {
            echo "- " . $c['name'] . " (Image: " . ($c['thumbnail'] ? $c['thumbnail'] : 'None') . ")\n";
        }
    }

} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
