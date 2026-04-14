-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2026 at 06:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mindheaven_merged`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_user_id` int(10) UNSIGNED NOT NULL,
  `counselor_user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` enum('individual','group','crisis','assessment','follow_up') NOT NULL,
  `mode` varchar(20) NOT NULL DEFAULT 'audio_video',
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` enum('scheduled','confirmed','in_progress','completed','cancelled','no_show','pending','accept','accepted','reject','rejected') NOT NULL DEFAULT 'scheduled',
  `rejection_reason` text DEFAULT NULL,
  `hidden_by_counselor` tinyint(1) DEFAULT 0,
  `scheduled_at` datetime NOT NULL,
  `duration_minutes` int(10) UNSIGNED NOT NULL DEFAULT 60,
  `location` enum('in_person','video_call','phone_call') NOT NULL,
  `meeting_link` varchar(500) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `session_notes` text DEFAULT NULL,
  `counselor_notes` text DEFAULT NULL,
  `student_feedback` text DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `student_user_id`, `counselor_user_id`, `title`, `type`, `mode`, `date`, `time`, `status`, `rejection_reason`, `hidden_by_counselor`, `scheduled_at`, `duration_minutes`, `location`, `meeting_link`, `notes`, `session_notes`, `counselor_notes`, `student_feedback`, `rating`, `created_at`, `updated_at`) VALUES
(1, 6, 4, 'Test Session', '', 'audio_video', '2026-04-07', '09:00:00', 'scheduled', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'Test notes for booking.', NULL, NULL, NULL, NULL, '2026-04-07 08:44:10', '2026-04-07 08:44:10'),
(2, 2, 4, 'Appointment1', '', 'audio_video', '2026-04-29', '09:00:00', 'scheduled', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'No notes', NULL, NULL, NULL, NULL, '2026-04-07 08:48:19', '2026-04-07 08:48:19'),
(3, 6, 4, 'Mental Health Check-in', '', 'audio_video', '2026-04-08', '09:00:00', 'scheduled', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'Test booking', NULL, NULL, NULL, NULL, '2026-04-07 09:05:38', '2026-04-07 09:05:38'),
(4, 6, 4, 'Video Therapy Session', '', 'audio_video', '2026-04-09', '09:00:00', 'scheduled', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'Testing mode persistence', NULL, NULL, NULL, NULL, '2026-04-07 09:23:32', '2026-04-07 09:23:32'),
(5, 2, 4, 'Tittle1', 'individual', 'audio_video', '2026-04-29', '13:00:00', 'scheduled', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'gth', NULL, NULL, NULL, NULL, '2026-04-07 09:34:02', '2026-04-07 09:34:02'),
(7, 2, 4, 'Session2', 'individual', 'audio_video', '2026-04-30', '09:00:00', 'scheduled', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'Good to go', NULL, NULL, NULL, NULL, '2026-04-07 21:43:02', '2026-04-08 09:55:46'),
(8, 2, 4, 'Sessionnewnew', 'group', 'audio_video', '2026-04-29', '16:00:00', 'scheduled', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'hiii', NULL, NULL, NULL, NULL, '2026-04-08 09:02:04', '2026-04-08 09:22:44'),
(9, 11, 9, 'session1', 'individual', 'audio_video', '2026-04-22', '09:00:00', 'accepted', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'No notes', NULL, NULL, NULL, NULL, '2026-04-08 17:33:02', '2026-04-08 17:36:37'),
(10, 2, 4, 'Tittle1', 'individual', 'audio_video', '2026-04-12', '17:00:00', 'pending', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'No', NULL, NULL, NULL, NULL, '2026-04-12 09:30:39', '2026-04-12 09:30:39'),
(11, 2, 4, 'Tittle1', 'crisis', 'audio_video', '2026-04-12', '18:00:00', 'pending', NULL, 0, '0000-00-00 00:00:00', 60, 'in_person', NULL, 'Notes added', NULL, NULL, NULL, NULL, '2026-04-12 09:34:08', '2026-04-12 09:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `appointments_old`
--

CREATE TABLE `appointments_old` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_user_id` int(10) UNSIGNED NOT NULL,
  `counselor_user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` enum('individual','group','crisis','assessment','follow-up') NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `counselor_id` int(10) UNSIGNED NOT NULL,
  `appointment_type` enum('individual','group','crisis','follow_up') NOT NULL,
  `status` enum('scheduled','confirmed','in_progress','completed','cancelled','no_show') NOT NULL DEFAULT 'scheduled',
  `scheduled_at` datetime NOT NULL,
  `duration_minutes` int(10) UNSIGNED NOT NULL DEFAULT 60,
  `location` enum('in_person','video_call','phone_call') NOT NULL,
  `meeting_link` varchar(500) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `session_notes` text DEFAULT NULL,
  `counselor_notes` text DEFAULT NULL,
  `student_feedback` text DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `call_escalations`
--

CREATE TABLE `call_escalations` (
  `id` int(11) NOT NULL,
  `call_id` int(11) NOT NULL,
  `responder_id` int(11) NOT NULL,
  `escalation_reason` text DEFAULT NULL,
  `escalation_status` enum('pending','assigned','resolved') DEFAULT 'pending',
  `counselor_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `call_logs`
--

CREATE TABLE `call_logs` (
  `id` int(11) NOT NULL,
  `caller_id` varchar(64) DEFAULT NULL,
  `responder_id` int(11) DEFAULT NULL,
  `call_status` enum('answered','declined','missed','in_progress','ended') DEFAULT 'in_progress',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT 0,
  `recording_path` varchar(512) DEFAULT NULL,
  `escalation_flag` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `call_notes`
--

CREATE TABLE `call_notes` (
  `id` int(11) NOT NULL,
  `call_id` int(11) NOT NULL,
  `responder_id` int(11) NOT NULL,
  `note_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `call_queue`
--

CREATE TABLE `call_queue` (
  `id` int(11) NOT NULL,
  `caller_id` varchar(64) NOT NULL,
  `status` enum('waiting','accepted','declined','in_progress','ended') DEFAULT 'waiting',
  `assigned_responder_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(11) NOT NULL,
  `sender_user_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `edited_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `session_id`, `sender_user_id`, `message`, `is_deleted`, `edited_at`, `created_at`) VALUES
(1, 1, 4, 'Hiii', 0, NULL, '2026-04-08 17:24:00'),
(2, 1, 4, 'How are you?', 0, NULL, '2026-04-08 17:24:11'),
(3, 2, 9, 'Hiii', 0, NULL, '2026-04-08 17:37:31'),
(4, 2, 9, 'Sandipaaa', 0, '2026-04-08 17:37:49', '2026-04-08 17:37:35'),
(5, 2, 9, 'Sandipaa', 1, NULL, '2026-04-08 17:37:39'),
(6, 2, 11, 'How are you?', 0, NULL, '2026-04-08 17:39:55'),
(7, 2, 11, 'It\'s nice to meet youu ok?', 0, '2026-04-08 17:40:10', '2026-04-08 17:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `chat_sessions`
--

CREATE TABLE `chat_sessions` (
  `id` int(11) NOT NULL,
  `counselor_user_id` int(10) UNSIGNED NOT NULL,
  `undergrad_user_id` int(10) UNSIGNED NOT NULL,
  `appointment_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT 'Counselling Chat',
  `status` enum('active','closed','archived') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_sessions`
--

INSERT INTO `chat_sessions` (`id`, `counselor_user_id`, `undergrad_user_id`, `appointment_id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 6, NULL, 'Counselling Chat', 'active', '2026-04-08 17:23:51', '2026-04-08 17:24:11'),
(2, 9, 11, NULL, 'Counselling Chat', 'active', '2026-04-08 17:37:28', '2026-04-08 17:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `counselors`
--

CREATE TABLE `counselors` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `years_experience` int(10) UNSIGNED DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `bio` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counselors`
--

INSERT INTO `counselors` (`id`, `user_id`, `full_name`, `email`, `license_number`, `specialization`, `years_experience`, `phone_number`, `bio`, `is_active`, `hourly_rate`, `is_available`, `is_approved`, `approved_at`, `approved_by`, `created_at`, `updated_at`, `profile_picture`) VALUES
(1, 4, 'Ruchini V', 'ruchini1@gmail.com', '123', 'Clinical Psychology', 12, '0751643231', 'No', 1, NULL, 1, 1, '2026-04-07 08:27:58', 3, '2026-04-07 08:10:28', '2026-04-07 08:27:58', NULL),
(2, 9, 'Sandipaa', 'sandipa1@gmail.com', '1234', 'Marriage and Family Therapy', 4, '0715462431', 'Bio included', 1, NULL, 1, 1, '2026-04-08 14:35:04', 3, '2026-04-08 14:32:19', '2026-04-08 14:35:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `counselor_availability`
--

CREATE TABLE `counselor_availability` (
  `id` int(10) UNSIGNED NOT NULL,
  `counselor_user_id` int(10) UNSIGNED NOT NULL,
  `weekday` tinyint(4) NOT NULL COMMENT '0=Sun ... 6=Sat',
  `counselor_id` int(10) UNSIGNED NOT NULL,
  `day_of_week` tinyint(4) NOT NULL CHECK (`day_of_week` >= 0 and `day_of_week` <= 6),
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counselor_qualifications`
--

CREATE TABLE `counselor_qualifications` (
  `id` int(11) NOT NULL,
  `counselor_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `year_range` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counselor_timeslots`
--

CREATE TABLE `counselor_timeslots` (
  `id` int(10) UNSIGNED NOT NULL,
  `counselor_user_id` int(10) UNSIGNED NOT NULL,
  `slot_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_type` enum('fixed','custom') NOT NULL DEFAULT 'fixed',
  `is_booked` tinyint(1) NOT NULL DEFAULT 0,
  `is_frozen` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counselor_timeslots`
--

INSERT INTO `counselor_timeslots` (`id`, `counselor_user_id`, `slot_date`, `start_time`, `end_time`, `slot_type`, `is_booked`, `is_frozen`, `created_at`, `updated_at`) VALUES
(4, 4, '2026-04-12', '17:00:00', '18:00:00', 'fixed', 0, 1, '2026-04-12 09:29:41', '2026-04-12 09:30:39'),
(5, 4, '2026-04-12', '18:00:00', '19:00:00', 'fixed', 0, 1, '2026-04-12 09:29:41', '2026-04-12 09:34:08'),
(6, 4, '2026-04-12', '19:00:00', '20:00:00', 'fixed', 0, 0, '2026-04-12 09:29:41', '2026-04-12 09:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `crisis_calls`
--

CREATE TABLE `crisis_calls` (
  `id` int(10) UNSIGNED NOT NULL,
  `caller_id` int(10) UNSIGNED DEFAULT NULL,
  `caller_name` varchar(100) DEFAULT NULL,
  `caller_phone` varchar(20) NOT NULL,
  `crisis_type` enum('suicidal_thoughts','self_harm','panic_attack','substance_abuse','domestic_violence','other') NOT NULL,
  `severity_level` enum('low','medium','high','critical') NOT NULL,
  `description` text NOT NULL,
  `responder_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('pending','in_progress','resolved','escalated') NOT NULL DEFAULT 'pending',
  `response_notes` text DEFAULT NULL,
  `follow_up_required` tinyint(1) NOT NULL DEFAULT 0,
  `follow_up_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crisis_response_log`
--

CREATE TABLE `crisis_response_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `crisis_call_id` int(10) UNSIGNED NOT NULL,
  `responder_id` int(10) UNSIGNED NOT NULL,
  `action_taken` text NOT NULL,
  `outcome` enum('resolved','escalated','referred','ongoing') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(10) UNSIGNED NOT NULL,
  `donor_id` int(10) UNSIGNED DEFAULT NULL,
  `donor_name` varchar(150) DEFAULT NULL,
  `donor_email` varchar(150) DEFAULT NULL,
  `donor_phone` varchar(30) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `payment_method` enum('credit_card','debit_card','bank_transfer','paypal','other') NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(100) NOT NULL,
  `gateway` varchar(50) DEFAULT 'payhere',
  `gateway_payment_id` varchar(100) DEFAULT NULL,
  `gateway_status_code` varchar(20) DEFAULT NULL,
  `gateway_status_message` varchar(255) DEFAULT NULL,
  `gateway_method` varchar(50) DEFAULT NULL,
  `receipt_file_path` varchar(255) DEFAULT NULL,
  `receipt_generated_at` datetime DEFAULT NULL,
  `return_status` varchar(50) DEFAULT NULL,
  `event_id` int(10) UNSIGNED DEFAULT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `donor_message` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `counselor_user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `priority` enum('normal','urgent') NOT NULL DEFAULT 'normal',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `appointment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `counselor_user_id`, `title`, `event_date`, `event_time`, `priority`, `description`, `created_at`, `updated_at`, `appointment_id`) VALUES
(2, 9, 'Session with Undergrad student', '2026-04-22', '09:00:00', 'normal', 'Appointment Reason: session1\r\nType: audio_video call', '2026-04-08 12:22:34', '2026-04-08 12:22:34', 9),
(3, 9, 'Event_1', '2026-04-22', '17:55:00', 'urgent', 'urgentt', '2026-04-08 12:23:07', '2026-04-08 12:23:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `feedback_type` enum('complaint','suggestion','compliment','bug_report') NOT NULL,
  `counselor_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `status` enum('open','in_progress','resolved','closed') NOT NULL DEFAULT 'open',
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `response` text DEFAULT NULL,
  `responded_at` datetime DEFAULT NULL,
  `responded_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `feedback_type`, `counselor_id`, `title`, `content`, `rating`, `is_anonymous`, `priority`, `status`, `assigned_to`, `response`, `responded_at`, `responded_by`, `created_at`, `updated_at`) VALUES
(1, 11, '', 2, 'Hii', 'Feedback was given', 3, 0, 'medium', 'open', NULL, NULL, NULL, NULL, '2026-04-08 17:34:00', '2026-04-08 17:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `flag_keywords`
--

CREATE TABLE `flag_keywords` (
  `id` int(10) UNSIGNED NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `severity` enum('Low','Medium','High') DEFAULT 'Medium',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_categories`
--

CREATE TABLE `forum_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_moderation_log`
--

CREATE TABLE `forum_moderation_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `moderator_id` int(10) UNSIGNED NOT NULL,
  `action_type` enum('approve_post','reject_post','lock_thread','unlock_thread','pin_thread','unpin_thread','delete_post','warn_user') NOT NULL,
  `target_type` enum('thread','post','user') NOT NULL,
  `target_id` int(10) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `thread_id` int(10) UNSIGNED NOT NULL,
  `parent_reply_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `like_count` int(11) DEFAULT 0,
  `is_edited` tinyint(1) DEFAULT 0,
  `edited_by_role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_post_likes`
--

CREATE TABLE `forum_post_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_threads`
--

CREATE TABLE `forum_threads` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(100) NOT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `allow_transparency` tinyint(1) DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('active','closed','flagged') DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `habits`
--

CREATE TABLE `habits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('health','fitness','wellness','learning','productivity','mindfulness','social','other') NOT NULL DEFAULT 'other',
  `frequency` enum('today','daily','weekly','custom') NOT NULL DEFAULT 'today',
  `target_days` int(10) UNSIGNED DEFAULT 1 COMMENT 'Target days per week for weekly habits',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `days_of_week` varchar(13) DEFAULT NULL,
  `repeat_interval` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `color` varchar(7) DEFAULT '#10b981' COMMENT 'Hex color for habit display',
  `icon` varchar(50) DEFAULT 'star' COMMENT 'Emoji or icon for habit',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habits`
--

INSERT INTO `habits` (`id`, `user_id`, `name`, `description`, `category`, `frequency`, `target_days`, `start_date`, `end_date`, `days_of_week`, `repeat_interval`, `color`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Senuji Vidanage', 'nothing', 'learning', 'daily', 1, '2026-04-08', NULL, NULL, 1, '#b710b1', '🎯', 1, '2026-04-08 15:40:10', '2026-04-08 16:40:29'),
(2, 2, 'Running', 'Doo', 'wellness', 'daily', 1, '2026-04-08', NULL, NULL, 1, '#b7104a', '🎯', 0, '2026-04-08 16:00:20', '2026-04-08 16:43:29'),
(3, 2, 'Drink water', 'Walk', 'wellness', 'today', 1, '2026-04-08', '2026-04-08', NULL, 1, '#b75310', '🎯', 1, '2026-04-08 16:01:05', '2026-04-08 16:39:22'),
(4, 2, 'Morning', 'No description', 'productivity', 'daily', 1, '2026-04-08', '2026-04-10', NULL, 1, '#82b710', '🎯', 1, '2026-04-08 16:19:50', '2026-04-08 16:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `habit_completions`
--

CREATE TABLE `habit_completions` (
  `id` int(10) UNSIGNED NOT NULL,
  `habit_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `completion_date` date NOT NULL,
  `completion_time` time DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `mood_rating` tinyint(3) UNSIGNED DEFAULT NULL CHECK (`mood_rating` >= 1 and `mood_rating` <= 5),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habit_completions`
--

INSERT INTO `habit_completions` (`id`, `habit_id`, `user_id`, `completion_date`, `completion_time`, `notes`, `mood_rating`, `created_at`) VALUES
(3, 3, 2, '2026-04-08', '12:31:05', NULL, NULL, '2026-04-08 16:01:05'),
(4, 2, 2, '2026-04-08', '12:31:28', NULL, NULL, '2026-04-08 16:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `habit_streaks`
--

CREATE TABLE `habit_streaks` (
  `id` int(10) UNSIGNED NOT NULL,
  `habit_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `current_streak` int(10) UNSIGNED DEFAULT 0,
  `longest_streak` int(10) UNSIGNED DEFAULT 0,
  `last_completion_date` date DEFAULT NULL,
  `streak_start_date` date DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mood_records`
--

CREATE TABLE `mood_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `mood_level` tinyint(4) NOT NULL CHECK (`mood_level` >= 1 and `mood_level` <= 10),
  `mood_type` enum('happy','sad','anxious','angry','calm','excited','tired','stressed','confused','grateful','neutral') NOT NULL,
  `notes` text DEFAULT NULL,
  `triggers` text DEFAULT NULL,
  `coping_strategies` text DEFAULT NULL,
  `sleep_hours` decimal(3,1) DEFAULT NULL,
  `exercise_minutes` int(10) UNSIGNED DEFAULT NULL,
  `social_interaction` enum('none','minimal','moderate','high') DEFAULT NULL,
  `recorded_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `appointment_id` int(10) UNSIGNED DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `reporter_id` int(10) UNSIGNED NOT NULL,
  `content_owner_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `content_type` enum('thread','post','reply','user','message') NOT NULL,
  `content_id` int(10) UNSIGNED NOT NULL,
  `explanation` text DEFAULT NULL,
  `status` enum('pending','reviewed','resolved','dismissed') DEFAULT 'pending',
  `strike_given` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resource_categories`
--

CREATE TABLE `resource_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resource_comments`
--

CREATE TABLE `resource_comments` (
  `id` int(11) NOT NULL,
  `resource_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT 'Anonymous User',
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_comments`
--

INSERT INTO `resource_comments` (`id`, `resource_id`, `user_id`, `username`, `comment`, `created_at`) VALUES
(1, 4, 1, 'Anonymous User', 'great', '2026-04-08 01:25:04');

-- --------------------------------------------------------

--
-- Table structure for table `resource_hub`
--

CREATE TABLE `resource_hub` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `content_type` enum('article','video','audio') NOT NULL,
  `content` longtext DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` int(10) UNSIGNED DEFAULT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `likes_count` int(11) DEFAULT 0,
  `likes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_hub`
--

INSERT INTO `resource_hub` (`id`, `title`, `category`, `content_type`, `content`, `file_path`, `file_name`, `file_size`, `file_type`, `youtube_url`, `summary`, `tags`, `status`, `created_by`, `created_at`, `updated_at`, `likes_count`, `likes`) VALUES
(1, 'sleep smart', 'Sleep & Wellness', 'article', '', 'uploads/resources/1775567140_sleep_smarter.jpeg', 'sleep smarter.jpeg', 205443, 'image/jpeg', NULL, 'sleep smart', '', 'published', 1, '2026-04-07 18:35:40', '2026-04-07 18:35:40', 0, 0),
(2, 'Daily mindfulness tips', 'Mindfulness & Meditation', 'article', '', 'uploads/resources/1775567211_Daily_mindfulness_tips.jpeg', 'Daily mindfulness tips.jpeg', 70849, 'image/jpeg', NULL, 'Daily mindfulness tips', '', 'published', 1, '2026-04-07 18:36:51', '2026-04-08 18:10:48', 0, 2),
(3, 'sleep tight', 'Sleep & Wellness', 'article', '', 'uploads/resources/1775568205_unique_sleep_hacks.jpeg', 'unique sleep hacks.jpeg', 161424, 'image/jpeg', NULL, 'sleep tight', '', 'published', 1, '2026-04-07 18:53:25', '2026-04-07 18:53:25', 0, 0),
(4, 'sleep', 'Sleep & Wellness', 'article', '', 'uploads/resources/1775571442_powerful_hacks_to_sleep_well.jpeg', 'powerful hacks to sleep well.jpeg', 206475, 'image/jpeg', NULL, 'sleep', '', 'published', 1, '2026-04-07 19:47:22', '2026-04-08 11:58:14', 0, 1),
(5, 'Perfect', 'Sleep & Wellness', 'audio', '', 'uploads/resources/1775616504_Perfect-_Mr-Jat.in_.mp3', 'Perfect-(Mr-Jat.in).mp3', 4269857, 'audio/mpeg', NULL, '', '', 'published', 2, '2026-04-08 08:18:24', '2026-04-08 08:18:24', 0, 0),
(6, 'sleep postures', 'Sleep & Wellness', 'video', '', NULL, NULL, NULL, NULL, 'https://youtu.be/dEgrgZ376ZE?si=QkcH3X7s7DRC62qA', '', '', 'published', 1, '2026-04-08 08:36:16', '2026-04-08 08:36:51', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resource_likes`
--

CREATE TABLE `resource_likes` (
  `user_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_likes`
--

INSERT INTO `resource_likes` (`user_id`, `resource_id`, `created_at`) VALUES
(1, 4, '2026-04-08 06:28:14'),
(2, 2, '2026-04-08 12:40:48'),
(11, 2, '2026-04-08 12:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `resource_reports`
--

CREATE TABLE `resource_reports` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','reviewed','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reviewed_by` int(11) DEFAULT NULL,
  `action_taken` enum('removed','warning issued','ignored') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_reports`
--

INSERT INTO `resource_reports` (`id`, `resource_id`, `user_id`, `reason`, `description`, `status`, `created_at`, `reviewed_by`, `action_taken`) VALUES
(1, 4, 1, 'Misinformation', 'kkkkkkkkk', 'pending', '2026-04-08 02:25:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_flags`
--
-- Error reading structure for table mindheaven_merged.system_flags: #1932 - Table &#039;mindheaven_merged.system_flags&#039; doesn&#039;t exist in engine
-- Error reading data for table mindheaven_merged.system_flags: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `mindheaven_merged`.`system_flags`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('string','integer','boolean','json') NOT NULL DEFAULT 'string',
  `description` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `undergraduate_students`
--

CREATE TABLE `undergraduate_students` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other','prefer_not_to_say') DEFAULT NULL,
  `university_id` int(10) UNSIGNED NOT NULL,
  `major` varchar(100) DEFAULT NULL,
  `year_of_study` enum('freshman','sophomore','junior','senior','graduate') DEFAULT NULL,
  `preferred_language` varchar(10) DEFAULT 'en',
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `undergraduate_students`
--

INSERT INTO `undergraduate_students` (`id`, `user_id`, `full_name`, `email`, `student_id`, `phone_number`, `date_of_birth`, `gender`, `university_id`, `major`, `year_of_study`, `preferred_language`, `emergency_contact_name`, `emergency_contact_phone`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 2, 'Senuji V', '2023is030@stu.ucsc.cmb.ac.lk', '', '0793425123', '2026-04-21', 'female', 1, NULL, NULL, 'en', NULL, NULL, 1, '2026-04-07 07:32:32', '2026-04-07 07:32:32'),
(3, 6, 'Student Test', '2023is001@stu.ucsc.cmb.ac.lk', '', '0712345678', '2000-01-01', 'male', 1, NULL, NULL, 'en', NULL, NULL, 1, '2026-04-07 08:42:34', '2026-04-07 08:42:34'),
(4, 7, 'Amanda Lusena', '2023is108@stu.ucsc.cmb.ac.lk', '', '0716534213', '2026-04-02', 'female', 1, NULL, NULL, 'en', NULL, NULL, 1, '2026-04-07 11:03:03', '2026-04-07 11:03:03'),
(5, 8, 'Tester Student', '2024is999@stu.ucsc.cmb.ac.lk', '', '0712345678', '2000-01-01', '', 1, NULL, NULL, 'en', NULL, NULL, 1, '2026-04-07 21:02:31', '2026-04-07 21:02:31'),
(6, 10, 'My Undergrad', '2024is001@stu.ucsc.cmb.ac.lk', '', '0771112223', '0000-00-00', '', 1, NULL, NULL, 'en', NULL, NULL, 1, '2026-04-08 15:57:53', '2026-04-08 15:57:53'),
(7, 11, 'Undergrad student', '2023is070@stu.ucsc.cmb.ac.lk', '', '0916543212', '2026-04-02', 'female', 1, NULL, NULL, 'en', NULL, NULL, 1, '2026-04-08 17:26:54', '2026-04-08 17:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `bank_name` varchar(150) DEFAULT NULL,
  `bank_branch` varchar(150) DEFAULT NULL,
  `account_name` varchar(200) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `bank_code` varchar(50) DEFAULT NULL,
  `bank_details_notes` text DEFAULT NULL,
  `bank_details_updated_at` datetime DEFAULT NULL,
  `logo_path` varchar(500) DEFAULT NULL,
  `primary_color` varchar(7) DEFAULT NULL,
  `secondary_color` varchar(7) DEFAULT NULL,
  `timezone` varchar(50) NOT NULL DEFAULT 'UTC',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `name`, `short_name`, `domain`, `address`, `city`, `state`, `country`, `postal_code`, `phone`, `email`, `website`, `bank_name`, `bank_branch`, `account_name`, `account_number`, `bank_code`, `bank_details_notes`, `bank_details_updated_at`, `logo_path`, `primary_color`, `secondary_color`, `timezone`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'University of Colombo School of Computing', 'UCSC', 'stu.ucsc.cmb.ac.lk', NULL, 'Colombo', NULL, 'Sri Lanka', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Asia/Colombo', 1, '2026-04-07 07:31:59', '2026-04-07 07:31:59'),
(2, 'University of Colombo', 'UNIVERSITY_OF_COLOMB', 'niversity-of-olombo.local', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UTC', 1, '2026-04-08 18:14:17', '2026-04-08 18:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `university_representatives`
--

CREATE TABLE `university_representatives` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `university_id` int(10) UNSIGNED NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `university_name` varchar(200) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_representatives`
--

INSERT INTO `university_representatives` (`id`, `user_id`, `full_name`, `email`, `university_id`, `position`, `department`, `phone_number`, `university_name`, `is_primary`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 12, '', '', 2, 'head', NULL, NULL, NULL, 0, 1, '2026-04-08 18:14:17', '2026-04-08 18:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `university_rep_events`
--

CREATE TABLE `university_rep_events` (
  `id` int(10) UNSIGNED NOT NULL,
  `university_rep_id` int(10) UNSIGNED NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_type` enum('awareness_program','workshop','talk','campaign','seminar','other') NOT NULL,
  `description` text NOT NULL,
  `organized_by` varchar(255) NOT NULL,
  `target_audience` text DEFAULT NULL,
  `open_for` enum('all_universities','specific_university') NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `venue` varchar(255) NOT NULL,
  `mode` enum('on_site','online','hybrid') NOT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `registration_deadline` date DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `status` enum('draft','published','cancelled','pending','approved','closed','rejected') DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `short_description` varchar(255) DEFAULT NULL,
  `target_amount` decimal(10,2) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','undergraduate','counselor','moderator','call_responder','university_representative','donor') NOT NULL,
  `status` enum('active','inactive','suspended','warned','banned') DEFAULT 'active',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_frozen` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `strike_count` int(11) DEFAULT 0,
  `suspended_until` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `last_strike_date` datetime DEFAULT NULL,
  `account_status` varchar(50) DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `password_reset_required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `role`, `status`, `is_active`, `is_frozen`, `email_verified`, `last_login`, `strike_count`, `suspended_until`, `is_deleted`, `last_strike_date`, `account_status`, `created_at`, `updated_at`, `password_reset_required`) VALUES
(2, 'Undergraduate_Test1', NULL, '2023is030@stu.ucsc.cmb.ac.lk', '$2y$10$qaI14grOwjo3QOA7jvpCO.4/S5r1RxWhXZvpFO8nwvywNYngI4Nz6', 'undergraduate', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-07 07:32:32', '2026-04-12 09:25:27', 0),
(3, 'admin', 'System Administrator', 'admin@mindheaven.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active', 1, 0, 1, NULL, 0, NULL, 0, NULL, 'active', '2026-04-07 07:36:38', '2026-04-07 07:43:13', 0),
(4, 'Counselor_Test1', NULL, '', '$2y$10$V9EBklmQztk2N1ayGOeCwuV64L6YPnDFJGCd5glowYFzoChZhTL9e', 'counselor', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-07 08:10:28', '2026-04-07 08:10:28', 0),
(5, 'admin2', 'Admin Two', 'admin2@mindheaven.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uXkOsxVUu', 'admin', 'active', 1, 0, 1, NULL, 0, NULL, 0, NULL, 'active', '2026-04-07 08:24:33', '2026-04-07 08:24:33', 0),
(6, 'student_test', NULL, '2023is001@stu.ucsc.cmb.ac.lk', '$2y$10$9dtHdboVtjjfckw3nVBgu.HmU1HOjaEyVGx/s6R6c1hoUSsNvdf7y', 'undergraduate', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-07 08:42:34', '2026-04-12 09:25:27', 0),
(7, 'Amanda', NULL, '2023is108@stu.ucsc.cmb.ac.lk', '$2y$10$EN6vZGRnvE3LenPNly2rb.ybQCrtVHURvSC2/qtJJl44EJaz7Lmmu', 'undergraduate', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-07 11:03:03', '2026-04-12 09:25:27', 0),
(8, 'tester', NULL, '2024is999@stu.ucsc.cmb.ac.lk', '$2y$10$QHANqP7PDEytjFjTeTafTO6ebglMY9g/i.m0c6yiU9tB6oIxl5eBe', 'undergraduate', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-07 21:02:30', '2026-04-12 09:25:27', 0),
(9, 'Counselor_test2', NULL, '', '$2y$10$Mj.ljXoZyTAkcyGhXCcBIuDVjephXkBFUA13M/.hrZPAh9sTYEhWS', 'counselor', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-08 14:32:19', '2026-04-08 14:32:19', 0),
(10, 'myundergrad', NULL, '2024is001@stu.ucsc.cmb.ac.lk', '$2y$10$WNUxwNXVhX83FHOh6T1Ece1DZATaUwYsJHNBlJpXtnif.kcdxUfsG', 'undergraduate', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-08 15:57:53', '2026-04-12 09:25:27', 0),
(11, 'Undergraduate_Test2', NULL, '2023is070@stu.ucsc.cmb.ac.lk', '$2y$10$8e09V5RqB3uTYocfTtGG.ebLw3kY9I4iUuiBpkCBcGc6/LQuZ6lCG', 'undergraduate', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-08 17:26:54', '2026-04-12 09:25:27', 0),
(12, 'senujiv1@gmail.com', NULL, 'senujiv1@gmail.com', '$2y$10$t6GAolHW604L9dhXIY2mHuh5dRD2DD72Ws4TmiOPgRm4S870VAg2C', 'university_representative', 'active', 1, 0, 0, NULL, 0, NULL, 0, NULL, 'active', '2026-04-08 18:14:17', '2026-04-08 18:15:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_appt_student` (`student_user_id`),
  ADD KEY `idx_appt_counselor` (`counselor_user_id`),
  ADD KEY `idx_appt_datetime` (`date`,`time`),
  ADD KEY `idx_appointments_status` (`status`),
  ADD KEY `idx_appointments_scheduled` (`scheduled_at`);

--
-- Indexes for table `appointments_old`
--
ALTER TABLE `appointments_old`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_appointments_student` (`student_id`),
  ADD KEY `idx_appointments_counselor` (`counselor_id`),
  ADD KEY `idx_appointments_status` (`status`),
  ADD KEY `idx_appointments_scheduled` (`scheduled_at`),
  ADD KEY `idx_appointments_type` (`appointment_type`),
  ADD KEY `idx_appt_student` (`student_user_id`),
  ADD KEY `idx_appt_counselor` (`counselor_user_id`),
  ADD KEY `idx_appt_datetime` (`date`,`time`);

--
-- Indexes for table `call_escalations`
--
ALTER TABLE `call_escalations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_logs`
--
ALTER TABLE `call_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_notes`
--
ALTER TABLE `call_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_queue`
--
ALTER TABLE `call_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `sender_user_id` (`sender_user_id`);

--
-- Indexes for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_session` (`counselor_user_id`,`undergrad_user_id`),
  ADD KEY `undergrad_user_id` (`undergrad_user_id`);

--
-- Indexes for table `counselors`
--
ALTER TABLE `counselors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD KEY `license_number` (`license_number`),
  ADD KEY `fk_counselor_approver` (`approved_by`),
  ADD KEY `idx_counselor_user` (`user_id`),
  ADD KEY `idx_counselor_license` (`license_number`),
  ADD KEY `idx_counselor_available` (`is_available`),
  ADD KEY `idx_counselor_approved` (`is_approved`),
  ADD KEY `idx_counselor_email` (`email`),
  ADD KEY `idx_counselor_active` (`is_active`);

--
-- Indexes for table `counselor_availability`
--
ALTER TABLE `counselor_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_availability_counselor` (`counselor_id`),
  ADD KEY `idx_availability_day` (`day_of_week`),
  ADD KEY `idx_availability_time` (`start_time`,`end_time`),
  ADD KEY `idx_avail_counselor` (`counselor_user_id`);

--
-- Indexes for table `counselor_qualifications`
--
ALTER TABLE `counselor_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `counselor_id` (`counselor_id`);

--
-- Indexes for table `counselor_timeslots`
--
ALTER TABLE `counselor_timeslots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_counselor_date_time` (`counselor_user_id`,`slot_date`,`start_time`),
  ADD KEY `idx_counselor_date` (`counselor_user_id`,`slot_date`);

--
-- Indexes for table `crisis_calls`
--
ALTER TABLE `crisis_calls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_crisis_caller` (`caller_id`),
  ADD KEY `idx_crisis_phone` (`caller_phone`),
  ADD KEY `idx_crisis_type` (`crisis_type`),
  ADD KEY `idx_crisis_severity` (`severity_level`),
  ADD KEY `idx_crisis_status` (`status`),
  ADD KEY `idx_crisis_responder` (`responder_id`),
  ADD KEY `idx_crisis_created` (`created_at`);

--
-- Indexes for table `crisis_response_log`
--
ALTER TABLE `crisis_response_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_crisis_log_call` (`crisis_call_id`),
  ADD KEY `idx_crisis_log_responder` (`responder_id`),
  ADD KEY `idx_crisis_log_outcome` (`outcome`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `idx_donations_donor` (`donor_id`),
  ADD KEY `idx_donations_status` (`payment_status`),
  ADD KEY `idx_donations_event` (`event_id`),
  ADD KEY `idx_donations_created` (`created_at`),
  ADD KEY `idx_donations_transaction` (`transaction_id`),
  ADD KEY `idx_donations_donor_created` (`donor_id`,`created_at`),
  ADD KEY `idx_donations_event_created` (`event_id`,`created_at`),
  ADD KEY `idx_donations_status_created` (`payment_status`,`created_at`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_counselor_date` (`counselor_user_id`,`event_date`),
  ADD KEY `idx_counselor_time` (`counselor_user_id`,`event_date`,`event_time`),
  ADD KEY `idx_date` (`event_date`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feedback_responder` (`responded_by`),
  ADD KEY `idx_feedback_user` (`user_id`),
  ADD KEY `idx_feedback_type` (`feedback_type`),
  ADD KEY `idx_feedback_priority` (`priority`),
  ADD KEY `idx_feedback_status` (`status`),
  ADD KEY `idx_feedback_assigned` (`assigned_to`),
  ADD KEY `idx_feedback_counselor` (`counselor_id`);

--
-- Indexes for table `flag_keywords`
--
ALTER TABLE `flag_keywords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unique_keyword` (`keyword`);

--
-- Indexes for table `forum_categories`
--
ALTER TABLE `forum_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_categories_active` (`is_active`),
  ADD KEY `idx_categories_sort` (`sort_order`);

--
-- Indexes for table `forum_moderation_log`
--
ALTER TABLE `forum_moderation_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mod_log_moderator` (`moderator_id`),
  ADD KEY `idx_mod_log_action` (`action_type`),
  ADD KEY `idx_mod_log_target` (`target_type`,`target_id`),
  ADD KEY `idx_mod_log_created` (`created_at`);

--
-- Indexes for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parent_reply` (`parent_reply_id`),
  ADD KEY `idx_posts_thread` (`thread_id`),
  ADD KEY `idx_posts_user` (`user_id`),
  ADD KEY `idx_posts_approved` (`is_approved`),
  ADD KEY `idx_posts_created` (`created_at`);

--
-- Indexes for table `forum_post_likes`
--
ALTER TABLE `forum_post_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_threads_user` (`user_id`);

--
-- Indexes for table `habits`
--
ALTER TABLE `habits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_habits_user` (`user_id`),
  ADD KEY `idx_habits_category` (`category`),
  ADD KEY `idx_habits_active` (`is_active`),
  ADD KEY `idx_habits_created` (`created_at`);

--
-- Indexes for table `habit_completions`
--
ALTER TABLE `habit_completions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_daily_completion` (`habit_id`,`completion_date`),
  ADD KEY `idx_habit_completions_habit` (`habit_id`),
  ADD KEY `idx_habit_completions_user` (`user_id`),
  ADD KEY `idx_habit_completions_date` (`completion_date`);

--
-- Indexes for table `habit_streaks`
--
ALTER TABLE `habit_streaks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_habit_streak` (`habit_id`,`user_id`),
  ADD KEY `idx_habit_streaks_habit` (`habit_id`),
  ADD KEY `idx_habit_streaks_user` (`user_id`);

--
-- Indexes for table `mood_records`
--
ALTER TABLE `mood_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mood_user` (`user_id`),
  ADD KEY `idx_mood_level` (`mood_level`),
  ADD KEY `idx_mood_type` (`mood_type`),
  ADD KEY `idx_mood_recorded` (`recorded_at`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notif_appt` (`appointment_id`),
  ADD KEY `idx_notif_user` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_expires_at` (`expires_at`),
  ADD KEY `idx_used` (`used`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resource_categories`
--
ALTER TABLE `resource_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_resource_categories_active` (`is_active`),
  ADD KEY `idx_resource_categories_sort` (`sort_order`);

--
-- Indexes for table `resource_comments`
--
ALTER TABLE `resource_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`);

--
-- Indexes for table `resource_hub`
--
ALTER TABLE `resource_hub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_content_type` (`content_type`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_likes_count` (`likes_count`);

--
-- Indexes for table `resource_likes`
--
ALTER TABLE `resource_likes`
  ADD PRIMARY KEY (`user_id`,`resource_id`);

--
-- Indexes for table `resource_reports`
--
ALTER TABLE `resource_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `fk_setting_updater` (`updated_by`),
  ADD KEY `idx_settings_key` (`setting_key`),
  ADD KEY `idx_settings_public` (`is_public`);

--
-- Indexes for table `undergraduate_students`
--
ALTER TABLE `undergraduate_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `idx_undergrad_user` (`user_id`),
  ADD KEY `idx_undergrad_student_id` (`student_id`),
  ADD KEY `idx_undergrad_university` (`university_id`),
  ADD KEY `idx_undergrad_active` (`is_active`),
  ADD KEY `idx_undergrad_email` (`email`),
  ADD KEY `idx_undergrad_phone` (`phone_number`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_name` (`short_name`),
  ADD UNIQUE KEY `domain` (`domain`),
  ADD KEY `idx_universities_domain` (`domain`),
  ADD KEY `idx_universities_active` (`is_active`),
  ADD KEY `idx_universities_country` (`country`);

--
-- Indexes for table `university_representatives`
--
ALTER TABLE `university_representatives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD KEY `idx_reps_user` (`user_id`),
  ADD KEY `idx_reps_university` (`university_id`),
  ADD KEY `idx_reps_primary` (`is_primary`),
  ADD KEY `idx_reps_active` (`is_active`),
  ADD KEY `idx_university_rep_email` (`email`);

--
-- Indexes for table `university_rep_events`
--
ALTER TABLE `university_rep_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_university_rep_events_user` (`university_rep_id`),
  ADD KEY `idx_university_rep_events_date` (`event_date`),
  ADD KEY `idx_university_rep_events_status` (`status`),
  ADD KEY `idx_university_rep_events_type` (`event_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `idx_sessions_user` (`user_id`),
  ADD KEY `idx_sessions_token` (`session_token`),
  ADD KEY `idx_sessions_expires` (`expires_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `appointments_old`
--
ALTER TABLE `appointments_old`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_escalations`
--
ALTER TABLE `call_escalations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_logs`
--
ALTER TABLE `call_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_notes`
--
ALTER TABLE `call_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_queue`
--
ALTER TABLE `call_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `counselors`
--
ALTER TABLE `counselors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `counselor_availability`
--
ALTER TABLE `counselor_availability`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counselor_qualifications`
--
ALTER TABLE `counselor_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counselor_timeslots`
--
ALTER TABLE `counselor_timeslots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `crisis_calls`
--
ALTER TABLE `crisis_calls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crisis_response_log`
--
ALTER TABLE `crisis_response_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flag_keywords`
--
ALTER TABLE `flag_keywords`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_categories`
--
ALTER TABLE `forum_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_moderation_log`
--
ALTER TABLE `forum_moderation_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_post_likes`
--
ALTER TABLE `forum_post_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_threads`
--
ALTER TABLE `forum_threads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `habits`
--
ALTER TABLE `habits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `habit_completions`
--
ALTER TABLE `habit_completions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `habit_streaks`
--
ALTER TABLE `habit_streaks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mood_records`
--
ALTER TABLE `mood_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resource_categories`
--
ALTER TABLE `resource_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resource_comments`
--
ALTER TABLE `resource_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resource_hub`
--
ALTER TABLE `resource_hub`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resource_reports`
--
ALTER TABLE `resource_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `undergraduate_students`
--
ALTER TABLE `undergraduate_students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `university_representatives`
--
ALTER TABLE `university_representatives`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `university_rep_events`
--
ALTER TABLE `university_rep_events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments_old`
--
ALTER TABLE `appointments_old`
  ADD CONSTRAINT `fk_appointment_counselor` FOREIGN KEY (`counselor_id`) REFERENCES `counselors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appointment_student` FOREIGN KEY (`student_id`) REFERENCES `undergraduate_students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appt_counselor` FOREIGN KEY (`counselor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appt_student` FOREIGN KEY (`student_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `chat_sessions_ibfk_1` FOREIGN KEY (`counselor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_sessions_ibfk_2` FOREIGN KEY (`undergrad_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `counselors`
--
ALTER TABLE `counselors`
  ADD CONSTRAINT `fk_counselor_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_counselor_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `counselor_availability`
--
ALTER TABLE `counselor_availability`
  ADD CONSTRAINT `fk_avail_counselor` FOREIGN KEY (`counselor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_availability_counselor` FOREIGN KEY (`counselor_id`) REFERENCES `counselors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `counselor_qualifications`
--
ALTER TABLE `counselor_qualifications`
  ADD CONSTRAINT `counselor_qualifications_ibfk_1` FOREIGN KEY (`counselor_id`) REFERENCES `counselors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crisis_calls`
--
ALTER TABLE `crisis_calls`
  ADD CONSTRAINT `fk_crisis_caller` FOREIGN KEY (`caller_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_crisis_responder` FOREIGN KEY (`responder_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `crisis_response_log`
--
ALTER TABLE `crisis_response_log`
  ADD CONSTRAINT `fk_crisis_log_call` FOREIGN KEY (`crisis_call_id`) REFERENCES `crisis_calls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_crisis_log_responder` FOREIGN KEY (`responder_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `fk_donation_donor` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_donation_university_event` FOREIGN KEY (`event_id`) REFERENCES `university_rep_events` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_assigned` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_feedback_counselor` FOREIGN KEY (`counselor_id`) REFERENCES `counselors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_feedback_responder` FOREIGN KEY (`responded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forum_moderation_log`
--
ALTER TABLE `forum_moderation_log`
  ADD CONSTRAINT `fk_mod_log_moderator` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `fk_parent_reply` FOREIGN KEY (`parent_reply_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_thread` FOREIGN KEY (`thread_id`) REFERENCES `forum_threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD CONSTRAINT `fk_thread_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `habits`
--
ALTER TABLE `habits`
  ADD CONSTRAINT `fk_habits_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `habit_completions`
--
ALTER TABLE `habit_completions`
  ADD CONSTRAINT `fk_habit_completions_habit` FOREIGN KEY (`habit_id`) REFERENCES `habits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_habit_completions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `habit_streaks`
--
ALTER TABLE `habit_streaks`
  ADD CONSTRAINT `fk_habit_streaks_habit` FOREIGN KEY (`habit_id`) REFERENCES `habits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_habit_streaks_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mood_records`
--
ALTER TABLE `mood_records`
  ADD CONSTRAINT `fk_mood_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments_old` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `fk_password_reset_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resource_comments`
--
ALTER TABLE `resource_comments`
  ADD CONSTRAINT `resource_comments_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resource_hub` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD CONSTRAINT `fk_setting_updater` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `undergraduate_students`
--
ALTER TABLE `undergraduate_students`
  ADD CONSTRAINT `fk_undergrad_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`),
  ADD CONSTRAINT `fk_undergrad_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `university_representatives`
--
ALTER TABLE `university_representatives`
  ADD CONSTRAINT `fk_rep_university` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rep_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `university_rep_events`
--
ALTER TABLE `university_rep_events`
  ADD CONSTRAINT `fk_university_rep_events_user` FOREIGN KEY (`university_rep_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `fk_session_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
