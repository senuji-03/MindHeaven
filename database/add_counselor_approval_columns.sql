-- Add approval columns to counselors table
-- This is required for the counselor approval system

ALTER TABLE `counselors` 
ADD COLUMN `is_approved` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_active`,
ADD COLUMN `approved_at` DATETIME NULL AFTER `is_approved`,
ADD COLUMN `approved_by` INT(10) UNSIGNED NULL AFTER `approved_at`;

-- Add foreign key constraint for approved_by
ALTER TABLE `counselors`
ADD CONSTRAINT `fk_counselor_approver` 
FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL;

-- Update existing counselors to be approved (since they were created before the approval system)
UPDATE `counselors` SET `is_approved` = 1 WHERE `is_active` = 1;
