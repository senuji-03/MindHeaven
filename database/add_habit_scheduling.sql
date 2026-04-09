-- ============================================================
-- MindHeaven: Add scheduling columns to habits table
-- Run this once in phpMyAdmin or via MySQL CLI
-- ============================================================

-- 1. Add new scheduling columns
ALTER TABLE `habits`
  ADD COLUMN `start_date`       date          DEFAULT NULL          AFTER `target_days`,
  ADD COLUMN `end_date`         date          DEFAULT NULL          AFTER `start_date`,
  ADD COLUMN `days_of_week`     varchar(13)   DEFAULT NULL          AFTER `end_date`,
  ADD COLUMN `repeat_interval`  int(10) UNSIGNED NOT NULL DEFAULT 1 AFTER `days_of_week`;

-- 2. Extend the frequency enum to include 'today'
ALTER TABLE `habits`
  MODIFY COLUMN `frequency`
    enum('today','daily','weekly','custom') NOT NULL DEFAULT 'today';

-- 3. Back-fill existing habits: treat as 'daily' with no end date
--    so they keep showing up on all days as before
UPDATE `habits`
SET `frequency` = 'daily',
    `start_date` = DATE(`created_at`)
WHERE `start_date` IS NULL;
