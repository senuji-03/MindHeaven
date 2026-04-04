CREATE TABLE IF NOT EXISTS `forum_threads` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `allow_transparency` tinyint(1) DEFAULT 0,
  `view_count` int(11) DEFAULT 0,
  `status` enum('active','closed','flagged') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `thread_id` INT UNSIGNED NOT NULL,
  `parent_reply_id` INT UNSIGNED DEFAULT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `like_count` int(11) DEFAULT 0,
  `is_edited` tinyint(1) DEFAULT 0,
  `edited_by_role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_posts_thread` (`thread_id`),
  KEY `idx_posts_user` (`user_id`),
  KEY `idx_posts_approved` (`is_approved`),
  KEY `idx_posts_created` (`created_at`),
  CONSTRAINT `fk_parent_reply` FOREIGN KEY (`parent_reply_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `forum_post_likes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `post_id` INT UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `flag_keywords` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `severity` enum('Low','Medium','High') DEFAULT 'Medium',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `system_flags` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content_id` INT UNSIGNED NOT NULL,
  `content_type` enum('thread','post') NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `matched_keyword` varchar(255) NOT NULL,
  `status` enum('pending','reviewed','dismissed') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `report_categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `reports` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reporter_id` INT UNSIGNED NOT NULL,
  `content_owner_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `content_type` enum('thread','post','reply','user','message') NOT NULL,
  `content_id` INT UNSIGNED NOT NULL,
  `explanation` text DEFAULT NULL,
  `status` enum('pending','reviewed','resolved','dismissed') DEFAULT 'pending',
  `strike_given` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
