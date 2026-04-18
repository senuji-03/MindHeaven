<?php
define('BASE_PATH', __DIR__);
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'app/models/ResourceHub.php';

// Mock session
session_start();
$_SESSION['user_id'] = 1;

try {
    $resourceHub = new ResourceHub();
    $data = array(
        'title' => 'Test Resource ' . time(),
        'category' => 'abc',
        'content_type' => 'article',
        'summary' => 'Test summary',
        'tags' => 'test, research',
        'status' => 'draft',
        'created_by' => 1,
        'content' => 'Test content body',
        'youtube_url' => null
    );
    
    echo "Attempting to create resource with data:\n";
    print_r($data);
    $result = $resourceHub->create($data);
    
    if ($result) {
        echo "Success! Resource created.\n";
    } else {
        echo "Failed! ResourceHub::create returned false.\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
