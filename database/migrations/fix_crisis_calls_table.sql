-- ============================================================
-- Migration: Fix crisis_calls table for Daily.co hotline
-- Run this once in phpMyAdmin or via mysql CLI against
-- the `mindheaven_merged` database.
-- ============================================================

USE mindheaven_merged;

-- 1. Add caller_user_id (maps to the logged-in student's users.id)
ALTER TABLE `crisis_calls`
    ADD COLUMN IF NOT EXISTS `caller_user_id` INT(10) UNSIGNED DEFAULT NULL AFTER `id`;

-- 2. Add responder_user_id (maps to the call_responder's users.id)
ALTER TABLE `crisis_calls`
    ADD COLUMN IF NOT EXISTS `responder_user_id` INT(10) UNSIGNED DEFAULT NULL AFTER `responder_id`;

-- 3. Add daily_room_url (the Daily.co room URL for the call)
ALTER TABLE `crisis_calls`
    ADD COLUMN IF NOT EXISTS `daily_room_url` VARCHAR(500) DEFAULT NULL AFTER `description`;

-- 4. Add notes (intervention notes saved by responder)
ALTER TABLE `crisis_calls`
    ADD COLUMN IF NOT EXISTS `notes` TEXT DEFAULT NULL AFTER `response_notes`;

-- 5. Extend the status enum to include 'waiting' and 'completed'
--    (original only had: pending, in_progress, resolved, escalated)
ALTER TABLE `crisis_calls`
    MODIFY COLUMN `status`
        ENUM('pending','waiting','in_progress','completed','resolved','escalated')
        NOT NULL DEFAULT 'waiting';

-- Verify
DESCRIBE crisis_calls;
