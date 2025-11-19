<?php
// Test script to verify resource creation and display
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'app/models/ResourceHub.php';

echo "<h1>Resource Creation and Display Test</h1>";

try {
    $resourceHub = new ResourceHub();
    
    // Test 1: Check database connection
    echo "<h2>Test 1: Database Connection</h2>";
    $pdo = Database::getConnection();
    echo "✅ Database connection successful<br>";
    
    // Test 2: Check if resource_hub table exists
    echo "<h2>Test 2: Table Check</h2>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'resource_hub'");
    if ($stmt->rowCount() > 0) {
        echo "✅ resource_hub table exists<br>";
    } else {
        echo "❌ resource_hub table does not exist<br>";
    }
    
    // Test 3: Create a test resource
    echo "<h2>Test 3: Create Test Resource</h2>";
    $testData = [
        'title' => 'Test Resource - ' . date('Y-m-d H:i:s'),
        'category' => 'Mental Health Basics',
        'content_type' => 'article',
        'content' => 'This is a test resource created at ' . date('Y-m-d H:i:s'),
        'summary' => 'Test summary for verification',
        'tags' => 'test, verification, mental health',
        'status' => 'published',
        'created_by' => 1
    ];
    
    $result = $resourceHub->create($testData);
    if ($result) {
        echo "✅ Test resource created successfully<br>";
    } else {
        echo "❌ Failed to create test resource<br>";
    }
    
    // Test 4: Retrieve all resources
    echo "<h2>Test 4: Retrieve All Resources</h2>";
    $allResources = $resourceHub->getAll();
    echo "Total resources in database: " . count($allResources) . "<br>";
    
    // Test 5: Retrieve published resources
    echo "<h2>Test 5: Retrieve Published Resources</h2>";
    $publishedResources = $resourceHub->getAll('published');
    echo "Published resources: " . count($publishedResources) . "<br>";
    
    // Test 6: Retrieve by category
    echo "<h2>Test 6: Retrieve by Category</h2>";
    $categoryResources = $resourceHub->getByCategory('Mental Health Basics', 'published');
    echo "Mental Health Basics resources: " . count($categoryResources) . "<br>";
    
    // Display sample resources
    echo "<h2>Sample Resources:</h2>";
    if (!empty($publishedResources)) {
        echo "<ul>";
        foreach (array_slice($publishedResources, 0, 5) as $resource) {
            echo "<li><strong>" . htmlspecialchars($resource['title']) . "</strong> - " . 
                 htmlspecialchars($resource['category']) . " (" . 
                 htmlspecialchars($resource['content_type']) . ") - Status: " . 
                 htmlspecialchars($resource['status']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No published resources found.";
    }
    
    echo "<h2>Test Complete!</h2>";
    echo "<p>If you see this message, the basic functionality is working. Check the undergraduate resources page to see if resources are displayed.</p>";
    
} catch (Exception $e) {
    echo "<h2>Error:</h2>";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
?>
