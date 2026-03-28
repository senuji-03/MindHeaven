<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

try {
    $db = Database::getConnection();
    $stmt = $db->query('SELECT id, thread_id, content, parent_reply_id, user_id, created_at FROM forum_posts ORDER BY id DESC LIMIT 5');
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($posts);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
