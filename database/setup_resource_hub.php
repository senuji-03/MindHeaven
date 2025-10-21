<?php
// Setup script for resource_hub table
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // Create the resource_hub table
    $sql = "
    CREATE TABLE IF NOT EXISTS `resource_hub` (
      `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `category` varchar(100) NOT NULL,
      `content_type` enum('article','video','audio') NOT NULL,
      `content` longtext DEFAULT NULL,
      `file_path` varchar(500) DEFAULT NULL,
      `file_name` varchar(255) DEFAULT NULL,
      `file_size` int(10) UNSIGNED DEFAULT NULL,
      `file_type` varchar(100) DEFAULT NULL,
      `summary` text DEFAULT NULL,
      `tags` varchar(500) DEFAULT NULL,
      `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
      `created_by` int(10) UNSIGNED NOT NULL,
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `idx_category` (`category`),
      KEY `idx_content_type` (`content_type`),
      KEY `idx_status` (`status`),
      KEY `idx_created_by` (`created_by`),
      KEY `idx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";
    
    $pdo->exec($sql);
    echo "✅ Table 'resource_hub' created successfully!\n";
    
    // Check if table exists and show structure
    $result = $pdo->query("DESCRIBE resource_hub");
    echo "📋 Table structure:\n";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']}: {$row['Type']}\n";
    }
    
    // Insert some test data
    $testData = [
        [
            'title' => 'Understanding Anxiety',
            'category' => 'Anxiety & Stress',
            'content_type' => 'article',
            'content' => 'Anxiety is a normal human emotion that everyone experiences at times...',
            'summary' => 'A comprehensive guide to understanding anxiety and its effects on mental health.',
            'tags' => 'anxiety, mental health, stress, coping',
            'status' => 'published',
            'created_by' => 1
        ],
        [
            'title' => 'Mindfulness Meditation Guide',
            'category' => 'Mindfulness & Meditation',
            'content_type' => 'video',
            'content' => 'This video guides you through a 10-minute mindfulness meditation session...',
            'file_path' => '/uploads/videos/sample_meditation.mp4',
            'file_name' => 'mindfulness_meditation.mp4',
            'file_size' => 15728640, // 15MB
            'file_type' => 'video/mp4',
            'summary' => 'A guided meditation video for beginners to practice mindfulness.',
            'tags' => 'meditation, mindfulness, relaxation, stress relief',
            'status' => 'published',
            'created_by' => 1
        ],
        [
            'title' => 'Sleep Hygiene Tips',
            'category' => 'Sleep & Wellness',
            'content_type' => 'audio',
            'content' => 'This audio recording provides practical tips for improving sleep quality...',
            'file_path' => '/uploads/audio/sleep_tips.mp3',
            'file_name' => 'sleep_hygiene_tips.mp3',
            'file_size' => 5242880, // 5MB
            'file_type' => 'audio/mpeg',
            'summary' => 'Audio guide with practical tips for better sleep hygiene.',
            'tags' => 'sleep, wellness, health, tips',
            'status' => 'draft',
            'created_by' => 1
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO resource_hub (
            title, category, content_type, content, file_path, file_name, 
            file_size, file_type, summary, tags, status, created_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    foreach ($testData as $data) {
        $stmt->execute([
            $data['title'],
            $data['category'],
            $data['content_type'],
            $data['content'],
            $data['file_path'] ?? null,
            $data['file_name'] ?? null,
            $data['file_size'] ?? null,
            $data['file_type'] ?? null,
            $data['summary'],
            $data['tags'],
            $data['status'],
            $data['created_by']
        ]);
    }
    
    echo "✅ Test data inserted successfully!\n";
    echo "📊 Total records: " . $pdo->query("SELECT COUNT(*) FROM resource_hub")->fetchColumn() . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
