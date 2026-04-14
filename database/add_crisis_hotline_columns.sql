-- ============================================================
-- MindHeaven: Crisis Hotline columns migration
-- Run this once against mindheaven_merged database
-- ============================================================

-- Add daily_room_url to crisis_calls (if not present)
ALTER TABLE `crisis_calls`
    ADD COLUMN IF NOT EXISTS `caller_user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS `daily_room_url` VARCHAR(500) NULL DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS `responder_user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS `notes` TEXT NULL DEFAULT NULL;

-- Change status enum to match what the app expects
ALTER TABLE `crisis_calls`
    MODIFY COLUMN `status` ENUM('waiting','in_progress','completed','escalated') NOT NULL DEFAULT 'waiting';

-- Add indexes
ALTER TABLE `crisis_calls`
    ADD INDEX IF NOT EXISTS `idx_crisis_status` (`status`),
    ADD INDEX IF NOT EXISTS `idx_crisis_created` (`created_at`);
