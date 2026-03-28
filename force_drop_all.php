<?php
try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `mind_heaven` CHAR SET utf8mb4 COLLATE utf8mb4_general_ci;");
    $pdo->exec("USE `mind_heaven`;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");

    $tables = [
        'users',
        'undergraduate_students',
        'counselors',
        'forum_categories',
        'forum_threads',
        'forum_posts',
        'forum_post_likes',
        'forum_moderation_log',
        'mood_records',
        'appointments',
        'counselor_availability',
        'resource_categories',
        'resources',
        'feedback',
        'crisis_calls',
        'crisis_response_log',
        'donations',
        'events',
        'event_participants',
        'event_proof_uploads',
        'universities',
        'university_representatives',
        'user_sessions',
        'system_settings',
        'report_categories',
        'reports',
        'flag_keywords',
        'system_flags',
        'password_resets',
        'habits',
        'habit_completions',
        'habit_streaks'
    ];

    foreach ($tables as $t) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS `$t`;");
            echo "Dropped ghost table: $t\n";
        } catch (Exception $e) {
            echo "Failed to drop $t: " . $e->getMessage() . "\n";
        }
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "InnoDB Dictionary cleanly synced!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
