-- Add university_rep role to users table
-- Run this SQL command in your database

ALTER TABLE `users` 
MODIFY COLUMN `role` ENUM('admin','call_responder','counselor','donor','moderator','undergrad','university_rep') NOT NULL;
