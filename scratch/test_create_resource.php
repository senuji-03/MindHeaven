<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'c:/xampp/htdocs/MindHeaven/config/config.php';
require_once 'c:/xampp/htdocs/MindHeaven/core/Database.php';
require_once 'c:/xampp/htdocs/MindHeaven/app/models/ResourceHub.php';

echo "Database Host: " . DB_HOST . "\n";
echo "Database Name: " . DB_NAME . "\n";

try {
    $resourceHub = new ResourceHub();

    $testData = array(
        'title' => 'Test Simulation ' . time(),
        'category' => 'Sleep & Wellness',
        'content_type' => 'article',
        'content' => 'This is a test article body from simulation',
        'file_path' => 'uploads/resources/test_sim.png',
        'file_name' => 'test_sim.png',
        'file_size' => 1024,
        'file_type' => 'image/png',
        'summary' => 'Test summary',
        'tags' => 'test, simulation',
        'status' => 'published',
        'created_by' => 2
    );

    echo "Attempting to create resource via model...\n";
    $result = $resourceHub->create($testData);

    if ($result) {
        echo "SUCCESS: Record created.\n";
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM resource_hub ORDER BY id DESC LIMIT 1");
        $last = $stmt->fetch(PDO::FETCH_ASSOC);
        print_r($last);
    } else {
        echo "FAILURE: Model returned false. Check logs.\n";
    }
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
?>
