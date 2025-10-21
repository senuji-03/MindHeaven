<?php
// Simple script to create resource_hub table
// Run this in phpMyAdmin or via command line

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

-- Insert test data
INSERT INTO `resource_hub` (`title`, `category`, `content_type`, `content`, `file_path`, `file_name`, `file_size`, `file_type`, `summary`, `tags`, `status`, `created_by`) VALUES
('Understanding Anxiety', 'Anxiety & Stress', 'article', 'Anxiety is a normal human emotion that everyone experiences at times. This comprehensive guide covers the basics of anxiety, its symptoms, and effective coping strategies.', NULL, NULL, NULL, NULL, 'A comprehensive guide to understanding anxiety and its effects on mental health.', 'anxiety, mental health, stress, coping', 'published', 1),
('Mindfulness Meditation Guide', 'Mindfulness & Meditation', 'video', 'This video guides you through a 10-minute mindfulness meditation session designed for beginners.', '/uploads/videos/sample_meditation.mp4', 'mindfulness_meditation.mp4', 15728640, 'video/mp4', 'A guided meditation video for beginners to practice mindfulness.', 'meditation, mindfulness, relaxation, stress relief', 'published', 1),
('Sleep Hygiene Tips', 'Sleep & Wellness', 'audio', 'This audio recording provides practical tips for improving sleep quality and establishing healthy sleep routines.', '/uploads/audio/sleep_tips.mp3', 'sleep_hygiene_tips.mp3', 5242880, 'audio/mpeg', 'Audio guide with practical tips for better sleep hygiene.', 'sleep, wellness, health, tips', 'draft', 1);
";

echo "SQL to create resource_hub table and insert test data:\n\n";
echo $sql;
echo "\n\nCopy and paste this SQL into phpMyAdmin to create the table and test data.\n";
?>
