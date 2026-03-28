USE mindheaven_db;

ALTER TABLE `forum_threads`
DROP FOREIGN KEY `fk_thread_category`,
DROP FOREIGN KEY `fk_thread_last_reply_user`;

ALTER TABLE `forum_threads`
DROP KEY `idx_threads_category`,
DROP KEY `idx_threads_pinned`,
DROP KEY `idx_threads_last_reply`;

ALTER TABLE `forum_threads`
CHANGE COLUMN `content` `description` TEXT NOT NULL,
CHANGE COLUMN `category_id` `category` VARCHAR(100) NOT NULL,
ADD COLUMN `is_anonymous` TINYINT(1) DEFAULT 0 AFTER `category`,
ADD COLUMN `allow_transparency` TINYINT(1) DEFAULT 0 AFTER `is_anonymous`,
ADD COLUMN `status` ENUM('active','closed','flagged') DEFAULT 'active' AFTER `view_count`,
DROP COLUMN `is_pinned`,
DROP COLUMN `is_locked`,
DROP COLUMN `reply_count`,
DROP COLUMN `last_reply_at`,
DROP COLUMN `last_reply_user_id`;

UPDATE `forum_threads` SET `category` = 'General';
