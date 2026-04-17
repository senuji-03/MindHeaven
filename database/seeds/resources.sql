-- Resource Hub Seed Data
-- Generated at: 2026-04-17 21:08:31

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE `resource_categories`;
INSERT INTO `resource_categories` (`id`, `name`, `description`, `is_active`, `sort_order`, `created_at`, `thumbnail`) VALUES
('1', 'Mental Health Basics', 'Understanding mental health, common conditions, and when to seek help', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Mental Health Basics.png'),
('2', 'Anxiety & Stress Management', 'Coping strategies and techniques for managing anxiety and stress', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Anxiety & Stress Management.png'),
('3', 'Understand Yourself', '', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Understand Yourself.png'),
('4', 'Mindfulness & Meditation', 'Guided practices for mindfulness and meditation', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Mindfulness & Meditation.png'),
('5', 'Sleep & Wellness', 'Tips for better sleep and overall wellness', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Sleep & Wellness.png'),
('6', 'Motivation & Real Stories', '', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Motivation & Real Stories.png'),
('7', 'Academic Stress Management', '', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Academic Stress Management.png'),
('8', 'Self-Help Tools', 'Interactive tools and exercises for mental wellness', '0', '0', '2026-04-11 21:26:04', NULL),
('9', 'Relationships & Emotional Well-being', '', '1', '0', '2026-04-11 21:26:04', 'images/resource_cats/Relationships & Emotional Well-being.png'),
('10', 'Anxiety & Stress Management', NULL, '0', '0', '2026-04-16 19:26:28', 'images/resource_cats/Anxiety & Stress Management.png');

TRUNCATE TABLE `resource_hub`;
INSERT INTO `resource_hub` (`id`, `title`, `category`, `content_type`, `content`, `file_path`, `file_name`, `file_size`, `file_type`, `youtube_url`, `summary`, `tags`, `status`, `created_by`, `created_at`, `updated_at`, `likes_count`, `likes`) VALUES
('1', 'sleep smart', 'Sleep & Wellness', 'article', '', 'uploads/resources/1775567140_sleep_smarter.jpeg', 'sleep smarter.jpeg', '205443', 'image/jpeg', NULL, 'sleep smart', '', 'published', '1', '2026-04-07 18:35:40', '2026-04-16 18:48:13', '1', '0'),
('2', 'Daily mindfulness tips', 'Mindfulness & Meditation', 'article', '', 'uploads/resources/1775567211_Daily_mindfulness_tips.jpeg', 'Daily mindfulness tips.jpeg', '70849', 'image/jpeg', NULL, 'Daily mindfulness tips', '', 'published', '1', '2026-04-07 18:36:51', '2026-04-08 18:10:38', '0', '1'),
('3', 'sleep tight', 'Sleep & Wellness', 'article', '', 'uploads/resources/1775568205_unique_sleep_hacks.jpeg', 'unique sleep hacks.jpeg', '161424', 'image/jpeg', NULL, 'sleep tight', '', 'published', '1', '2026-04-07 18:53:25', '2026-04-16 18:47:56', '1', '1'),
('4', 'sleep', 'Sleep & Wellness', 'article', '', 'uploads/resources/1775571442_powerful_hacks_to_sleep_well.jpeg', 'powerful hacks to sleep well.jpeg', '206475', 'image/jpeg', NULL, 'sleep', '', 'archived', '1', '2026-04-07 19:47:22', '2026-04-16 15:45:37', '0', '1'),
('5', 'Perfect', 'Sleep & Wellness', 'audio', '', 'uploads/resources/1775616504_Perfect-_Mr-Jat.in_.mp3', 'Perfect-(Mr-Jat.in).mp3', '4269857', 'audio/mpeg', NULL, '', '', 'published', '2', '2026-04-08 08:18:24', '2026-04-08 08:18:24', '0', '0'),
('6', 'sleep postures', 'Sleep & Wellness', 'video', '', NULL, NULL, NULL, NULL, 'https://youtu.be/dEgrgZ376ZE?si=QkcH3X7s7DRC62qA', '', '', 'published', '1', '2026-04-08 08:36:16', '2026-04-08 08:36:51', '0', '0'),
('8', 'www', 'Sleep & Wellness', 'article', '', NULL, NULL, NULL, NULL, NULL, '', '', 'draft', '2', '2026-04-16 14:04:22', '2026-04-16 14:04:22', '0', '0'),
('10', 'stress', 'Anxiety & Stress Management', 'article', '', 'uploads/resources/1776331408_download__4_.jpg', 'download (4).jpg', '93417', 'jpg', NULL, '', '', 'published', '2', '2026-04-16 14:53:28', '2026-04-17 00:13:32', '0', '0'),
('11', 'Sleep Affirmations', 'Sleep & Wellness', 'video', '', NULL, NULL, NULL, NULL, 'https://youtu.be/nZwUoyKtkMU?si=jYzr05KhduyljBfj', '', '', 'published', '2', '2026-04-16 18:43:59', '2026-04-16 18:43:59', '0', '0'),
('12', 'Fix your sleep schedule', 'Sleep & Wellness', 'article', '', 'uploads/resources/1776345417_Fix_Your_Sleep_Schedule__The_7-Day_Reset_Plan__Infographic_.jpg', 'Fix Your Sleep Schedule_ The 7-Day Reset Plan (Infographic).jpg', '78482', 'jpg', NULL, '', '', 'archived', '2', '2026-04-16 18:46:57', '2026-04-17 10:16:42', '0', '0'),
('13', 'Sleep depriviation', 'Sleep & Wellness', 'article', '', 'uploads/resources/1776345455_What_Sleep_Deprivation_Actually_Does.jpg', 'What Sleep Deprivation Actually Does.jpg', '123340', 'jpg', NULL, '', '', 'published', '2', '2026-04-16 18:47:35', '2026-04-17 10:33:10', '1', '0'),
('14', 'Study Hacks for Better Focus', 'Academic Stress Management', 'article', '', 'uploads/resources/1776350126_5_Simple_Study_Hacks_for_Better_Focus__1_.jpg', '5 Simple Study Hacks for Better Focus (1).jpg', '152621', 'jpg', NULL, '', '', 'published', '2', '2026-04-16 20:05:26', '2026-04-16 20:05:26', '0', '0'),
('15', 'How to overcome distractions while studying', 'Academic Stress Management', 'article', '', 'uploads/resources/1776350222_How_To_Overcome_Distractions_While_Studying__1_.jpg', 'How To Overcome Distractions While Studying (1).jpg', '130076', 'jpg', NULL, '', '', 'published', '2', '2026-04-16 20:07:02', '2026-04-16 20:07:02', '0', '0'),
('16', 'Pomodoro technique for effective study', 'Academic Stress Management', 'article', '', 'uploads/resources/1776350288____Pomodoro_Technique_for_Effective_Study___.jpg', '“Pomodoro Technique for Effective Study”.jpg', '148657', 'jpg', NULL, '', '', 'published', '2', '2026-04-16 20:08:08', '2026-04-16 20:08:08', '0', '0'),
('17', 'How to manage stress as a student', 'Academic Stress Management', 'video', '', NULL, NULL, NULL, NULL, 'https://youtu.be/Bk2-dKH2Ta4?si=7CpqyAghjHY1KM7v', '', '', 'published', '2', '2026-04-16 20:10:51', '2026-04-16 20:10:51', '0', '0'),
('18', 'Sleep well', 'Sleep & Wellness', 'article', '', 'uploads/resources/1776402266______20_Sleep-Boosting_Superfoods_You_Should_Try_Tonight___________1_.jpg', '🌙 20 Sleep-Boosting Superfoods You Should Try Tonight! 😴✨ (1).jpg', '89905', 'jpg', NULL, '', '', 'published', '2', '2026-04-17 10:34:26', '2026-04-17 10:34:26', '0', '0');

SET FOREIGN_KEY_CHECKS = 1;
