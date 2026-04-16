<?php
/**
 * Resource Hub Sync Script
 * This script renames old categories, inserts new ones, and maps thumbnails.
 * Visit this page in your browser to sync your local database.
 */

// Error reporting to see what happens
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    echo "<div style='font-family: sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>";
    echo "<h2 style='color: #2c3e50;'>Resource Hub Sync Tool</h2>";
    echo "<p>Starting database synchronization...</p>";

    // 1. Rename Mapping (Old Name => New Name)
    $renames = array(
        'Anxiety & Stress' => 'Anxiety & Stress Management',
        'Academic Support' => 'Academic Stress Management',
        'Meditation & Mindfulness' => 'Mindfulness & Meditation'
    );

    foreach ($renames as $old => $new) {
        // Update resource_categories
        $stmtCat = $pdo->prepare("UPDATE resource_categories SET name = ? WHERE name = ?");
        $stmtCat->execute(array($new, $old));
        
        // Update resource_hub (so existing resources stay in the right category)
        $stmtHub = $pdo->prepare("UPDATE resource_hub SET category = ? WHERE category = ?");
        $stmtHub->execute(array($new, $old));
        
        if ($stmtCat->rowCount() > 0) {
            echo "<li style='color: #27ae60;'>Renamed category <b>'$old'</b> to <b>'$new'</b>.</li>";
        }
    }

    echo "<h3>Updating Thumbnails...</h3>";
    echo "<ul>";

    // 2. Thumbnail Mapping (Name => Path)
    // Matches the files generated in public/images/resource_cats/
    $thumbnails = array(
        'Mental Health Basics' => 'images/resource_cats/Mental Health Basics.png',
        'Anxiety & Stress Management' => 'images/resource_cats/Anxiety & Stress Management.png',
        'Understand Yourself' => 'images/resource_cats/Understand Yourself.png',
        'Mindfulness & Meditation' => 'images/resource_cats/Mindfulness & Meditation.png',
        'Sleep & Wellness' => 'images/resource_cats/Sleep & Wellness.png',
        'Motivation & Real Stories' => 'images/resource_cats/Motivation & Real Stories.png',
        'Academic Stress Management' => 'images/resource_cats/Academic Stress Management.png',
        'Relationships & Emotional Well-being' => 'images/resource_cats/Relationships & Emotional Well-being.png'
    );

    foreach ($thumbnails as $name => $path) {
        // Check if category exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM resource_categories WHERE name = ?");
        $stmt->execute(array($name));
        $exists = $stmt->fetchColumn() > 0;

        if (!$exists) {
            // Create it if missing
            $pdo->prepare("INSERT INTO resource_categories (name, thumbnail, is_active) VALUES (?, ?, 1)")
                ->execute(array($name, $path));
            echo "<li style='color: #2980b9;'>Created and linked category: <b>$name</b></li>";
        } else {
            // Update thumbnail if it exists
            $pdo->prepare("UPDATE resource_categories SET thumbnail = ? WHERE name = ?")
                ->execute(array($path, $name));
            echo "<li>Updated thumbnail for: <b>$name</b></li>";
        }
    }
    echo "</ul>";

    echo "<h3 style='color: #27ae60;'>Success! Sync Complete.</h3>";
    echo "<p>You can now view the Resource Hub. You may delete this file (scratch/sync_hub.php) after everyone on the team has run it.</p>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div style='color: #c0392b; font-family: sans-serif;'>";
    echo "<h3>Error Syncing Database</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
