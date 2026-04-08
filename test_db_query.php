<?php
require 'config/config.php';
require 'core/Database.php';
require 'app/models/ResourceHub.php';

try {
    $r = new ResourceHub();
    $res = $r->getByCategory('Sleep & Wellness', 'published');
    print_r($res);
    echo "\nSuccess 1\n";
} catch (Exception $e) {
    echo "getByCategory Error: " . $e->getMessage() . "\n";
}

try {
    $res2 = $r->getUserLikes(1);
    print_r($res2);
    echo "\nSuccess 2\n";
} catch (Exception $e) {
    echo "getUserLikes Error: " . $e->getMessage() . "\n";
}
