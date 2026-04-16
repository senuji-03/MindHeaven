-- Creates the resource_likes table to track user likes on resources.
-- This table was generated to resolve the 'table doesn't exist in engine' error.

CREATE TABLE IF NOT EXISTS `resource_likes` (
    `resource_id` int(10) unsigned NOT NULL,
    `user_id` int(10) unsigned NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`resource_id`,`user_id`),
    CONSTRAINT `fk_res_likes_resource` FOREIGN KEY (`resource_id`) REFERENCES `resource_hub` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
