-- Events table for counselor calendar system
-- This table stores all calendar events for counselors

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `counselor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `priority` enum('normal','urgent') NOT NULL DEFAULT 'normal',
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_counselor_date` (`counselor_id`, `event_date`),
  KEY `idx_counselor_time` (`counselor_id`, `event_date`, `event_time`),
  KEY `idx_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add foreign key constraint if counselors table exists
-- ALTER TABLE `events` ADD CONSTRAINT `fk_events_counselor` FOREIGN KEY (`counselor_id`) REFERENCES `counselors` (`id`) ON DELETE CASCADE;

-- Sample data for testing (optional)
INSERT INTO `events` (`counselor_id`, `title`, `event_date`, `event_time`, `priority`, `description`) VALUES
(1, 'Sarah Johnson', '2024-12-23', '10:30:00', 'normal', 'Anxiety and stress management session'),
(1, 'Michael Chen', '2024-12-23', '14:00:00', 'normal', 'Academic pressure and burnout session'),
(1, 'Team Meeting', '2024-12-23', '16:30:00', 'normal', 'Weekly counseling team sync'),
(1, 'Emily Davis', '2024-12-24', '11:00:00', 'normal', 'Social anxiety and relationship issues'),
(1, 'Holiday Planning', '2024-12-24', '15:00:00', 'urgent', 'Plan holiday schedule adjustments'),
(1, 'John Smith', '2024-12-26', '09:00:00', 'urgent', 'Depression support session'),
(1, 'Training Session', '2024-12-26', '13:00:00', 'normal', 'New therapy techniques workshop');
