-- Add license_number field to counselors table
-- Run this SQL command in your database

ALTER TABLE `counselors` 
ADD COLUMN `license_number` VARCHAR(50) NOT NULL UNIQUE AFTER `phone_number`;

-- Add index for license_number for better performance
ALTER TABLE `counselors` 
ADD INDEX `idx_counselor_license` (`license_number`);
