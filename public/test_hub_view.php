<?php
// public/test_hub_view.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/app/models/ResourceHub.php';

try {
    $resourceHub = new ResourceHub();
    $categories = $resourceHub->getCategories();
    
    echo "<h1>Debug Resource Categories</h1>";
    echo "<p>Found " . count($categories) . " categories.</p>";
    
    if (empty($categories)) {
        echo "<p style='color:red;'>ERROR: No categories found in database where is_active=1.</p>";
        $pdo = Database::getConnection();
        $all = $pdo->query("SELECT * FROM resource_categories")->fetchAll(PDO::FETCH_ASSOC);
        echo "<h2>Raw Table Data:</h2><pre>"; print_r($all); echo "</pre>";
    } else {
        echo "<ul>";
        foreach ($categories as $cat) {
            echo "<li>" . htmlspecialchars($cat['name']) . "</li>";
        }
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>EXCEPTION: " . $e->getMessage() . "</p>";
}
