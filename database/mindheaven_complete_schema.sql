-- =====================================================
-- MindHeaven Mental Health Platform - Complete Database Schema
-- =====================================================
-- This schema supports a comprehensive mental health platform
-- for university students with multiple user roles and features

-- =====================================================
-- 1. USER MANAGEMENT TABLES
-- =====================================================

-- Main Users Table - Central authentication and basic info
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'undergraduate', 'counselor', 'moderator', 'call_responder', 'donor', 'university_rep') NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    last_login DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes
    INDEX idx_users_role (role),
    INDEX idx_users_active (is_active),
    INDEX idx_users_verified (is_verified)
);

-- Undergraduate Students Table - Extended profile for students
CREATE TABLE IF NOT EXISTS undergraduate_students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(20) NOT NULL UNIQUE,
    phone_number VARCHAR(20) NOT NULL,
    date_of_birth DATE NULL,
    gender ENUM('male', 'female', 'other', 'prefer_not_to_say') NULL,
    university_id INT UNSIGNED NOT NULL,
    major VARCHAR(100) NULL,
    year_of_study ENUM('freshman', 'sophomore', 'junior', 'senior', 'graduate') NULL,
    preferred_language VARCHAR(10) DEFAULT 'en',
    emergency_contact_name VARCHAR(100) NULL,
    emergency_contact_phone VARCHAR(20) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_undergrad_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_undergrad_university FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE RESTRICT,
    
    -- Indexes
    INDEX idx_undergrad_user (user_id),
    INDEX idx_undergrad_student_id (student_id),
    INDEX idx_undergrad_university (university_id),
    INDEX idx_undergrad_active (is_active)
);

-- Counselors Table - Professional mental health providers
CREATE TABLE IF NOT EXISTS counselors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    license_number VARCHAR(50) NOT NULL UNIQUE,
    specialization VARCHAR(100) NULL,
    years_experience INT UNSIGNED NULL,
    phone_number VARCHAR(20) NOT NULL,
    bio TEXT NULL,
    hourly_rate DECIMAL(10,2) NULL,
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    is_approved TINYINT(1) NOT NULL DEFAULT 0,
    approved_at DATETIME NULL,
    approved_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_counselor_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_counselor_approver FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_counselor_user (user_id),
    INDEX idx_counselor_license (license_number),
    INDEX idx_counselor_available (is_available),
    INDEX idx_counselor_approved (is_approved)
);

-- =====================================================
-- 2. FORUM TABLES
-- =====================================================

-- Forum Categories
CREATE TABLE IF NOT EXISTS forum_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_categories_active (is_active),
    INDEX idx_categories_sort (sort_order)
);

-- Forum Threads
CREATE TABLE IF NOT EXISTS forum_threads (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    is_pinned TINYINT(1) NOT NULL DEFAULT 0,
    is_locked TINYINT(1) NOT NULL DEFAULT 0,
    view_count INT UNSIGNED NOT NULL DEFAULT 0,
    reply_count INT UNSIGNED NOT NULL DEFAULT 0,
    last_reply_at DATETIME NULL,
    last_reply_user_id INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_thread_category FOREIGN KEY (category_id) REFERENCES forum_categories(id) ON DELETE CASCADE,
    CONSTRAINT fk_thread_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_thread_last_reply_user FOREIGN KEY (last_reply_user_id) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_threads_category (category_id),
    INDEX idx_threads_user (user_id),
    INDEX idx_threads_pinned (is_pinned),
    INDEX idx_threads_last_reply (last_reply_at)
);

-- Forum Posts (replies to threads)
CREATE TABLE IF NOT EXISTS forum_posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    thread_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    content TEXT NOT NULL,
    is_approved TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_post_thread FOREIGN KEY (thread_id) REFERENCES forum_threads(id) ON DELETE CASCADE,
    CONSTRAINT fk_post_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_posts_thread (thread_id),
    INDEX idx_posts_user (user_id),
    INDEX idx_posts_approved (is_approved),
    INDEX idx_posts_created (created_at)
);

-- Forum Moderation Log
CREATE TABLE IF NOT EXISTS forum_moderation_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    moderator_id INT UNSIGNED NOT NULL,
    action_type ENUM('approve_post', 'reject_post', 'lock_thread', 'unlock_thread', 'pin_thread', 'unpin_thread', 'delete_post', 'warn_user') NOT NULL,
    target_type ENUM('thread', 'post', 'user') NOT NULL,
    target_id INT UNSIGNED NOT NULL,
    reason TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_mod_log_moderator FOREIGN KEY (moderator_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_mod_log_moderator (moderator_id),
    INDEX idx_mod_log_action (action_type),
    INDEX idx_mod_log_target (target_type, target_id),
    INDEX idx_mod_log_created (created_at)
);

-- =====================================================
-- 3. MOOD TRACKING TABLES
-- =====================================================

-- Mood Records
CREATE TABLE IF NOT EXISTS mood_records (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    mood_level TINYINT NOT NULL CHECK (mood_level >= 1 AND mood_level <= 10),
    mood_type ENUM('happy', 'sad', 'anxious', 'angry', 'calm', 'excited', 'tired', 'stressed', 'confused', 'grateful') NOT NULL,
    notes TEXT NULL,
    triggers TEXT NULL,
    coping_strategies TEXT NULL,
    sleep_hours DECIMAL(3,1) NULL,
    exercise_minutes INT UNSIGNED NULL,
    social_interaction ENUM('none', 'minimal', 'moderate', 'high') NULL,
    recorded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_mood_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_mood_user (user_id),
    INDEX idx_mood_level (mood_level),
    INDEX idx_mood_type (mood_type),
    INDEX idx_mood_recorded (recorded_at)
);

-- =====================================================
-- 4. BOOKING & APPOINTMENT TABLES
-- =====================================================

-- Appointment Bookings
CREATE TABLE IF NOT EXISTS appointments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED NOT NULL,
    counselor_id INT UNSIGNED NOT NULL,
    appointment_type ENUM('individual', 'group', 'crisis', 'follow_up') NOT NULL,
    status ENUM('scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show') NOT NULL DEFAULT 'scheduled',
    scheduled_at DATETIME NOT NULL,
    duration_minutes INT UNSIGNED NOT NULL DEFAULT 60,
    location ENUM('in_person', 'video_call', 'phone_call') NOT NULL,
    meeting_link VARCHAR(500) NULL,
    notes TEXT NULL,
    counselor_notes TEXT NULL,
    student_feedback TEXT NULL,
    rating TINYINT UNSIGNED NULL CHECK (rating >= 1 AND rating <= 5),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_appointment_student FOREIGN KEY (student_id) REFERENCES undergraduate_students(id) ON DELETE CASCADE,
    CONSTRAINT fk_appointment_counselor FOREIGN KEY (counselor_id) REFERENCES counselors(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_appointments_student (student_id),
    INDEX idx_appointments_counselor (counselor_id),
    INDEX idx_appointments_status (status),
    INDEX idx_appointments_scheduled (scheduled_at),
    INDEX idx_appointments_type (appointment_type)
);

-- Counselor Availability
CREATE TABLE IF NOT EXISTS counselor_availability (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    counselor_id INT UNSIGNED NOT NULL,
    day_of_week TINYINT NOT NULL CHECK (day_of_week >= 0 AND day_of_week <= 6), -- 0=Sunday, 6=Saturday
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_availability_counselor FOREIGN KEY (counselor_id) REFERENCES counselors(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_availability_counselor (counselor_id),
    INDEX idx_availability_day (day_of_week),
    INDEX idx_availability_time (start_time, end_time)
);

-- =====================================================
-- 5. RESOURCE MANAGEMENT TABLES
-- =====================================================

-- Resource Categories
CREATE TABLE IF NOT EXISTS resource_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_resource_categories_active (is_active),
    INDEX idx_resource_categories_sort (sort_order)
);

-- Resources
CREATE TABLE IF NOT EXISTS resources (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    uploaded_by INT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size INT UNSIGNED NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    is_public TINYINT(1) NOT NULL DEFAULT 1,
    download_count INT UNSIGNED NOT NULL DEFAULT 0,
    view_count INT UNSIGNED NOT NULL DEFAULT 0,
    is_approved TINYINT(1) NOT NULL DEFAULT 0,
    approved_at DATETIME NULL,
    approved_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_resource_category FOREIGN KEY (category_id) REFERENCES resource_categories(id) ON DELETE CASCADE,
    CONSTRAINT fk_resource_uploader FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_resource_approver FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_resources_category (category_id),
    INDEX idx_resources_uploader (uploaded_by),
    INDEX idx_resources_public (is_public),
    INDEX idx_resources_approved (is_approved),
    INDEX idx_resources_type (file_type)
);

-- =====================================================
-- 6. FEEDBACK & CRISIS TABLES
-- =====================================================

-- Feedback/Complaints
CREATE TABLE IF NOT EXISTS feedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    feedback_type ENUM('complaint', 'suggestion', 'compliment', 'bug_report') NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    priority ENUM('low', 'medium', 'high', 'urgent') NOT NULL DEFAULT 'medium',
    status ENUM('open', 'in_progress', 'resolved', 'closed') NOT NULL DEFAULT 'open',
    assigned_to INT UNSIGNED NULL,
    response TEXT NULL,
    responded_at DATETIME NULL,
    responded_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_feedback_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_feedback_assigned FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_feedback_responder FOREIGN KEY (responded_by) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_feedback_user (user_id),
    INDEX idx_feedback_type (feedback_type),
    INDEX idx_feedback_priority (priority),
    INDEX idx_feedback_status (status),
    INDEX idx_feedback_assigned (assigned_to)
);

-- Crisis Calls
CREATE TABLE IF NOT EXISTS crisis_calls (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    caller_id INT UNSIGNED NULL,
    caller_name VARCHAR(100) NULL,
    caller_phone VARCHAR(20) NOT NULL,
    crisis_type ENUM('suicidal_thoughts', 'self_harm', 'panic_attack', 'substance_abuse', 'domestic_violence', 'other') NOT NULL,
    severity_level ENUM('low', 'medium', 'high', 'critical') NOT NULL,
    description TEXT NOT NULL,
    responder_id INT UNSIGNED NULL,
    status ENUM('pending', 'in_progress', 'resolved', 'escalated') NOT NULL DEFAULT 'pending',
    response_notes TEXT NULL,
    follow_up_required TINYINT(1) NOT NULL DEFAULT 0,
    follow_up_date DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_crisis_caller FOREIGN KEY (caller_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_crisis_responder FOREIGN KEY (responder_id) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_crisis_caller (caller_id),
    INDEX idx_crisis_phone (caller_phone),
    INDEX idx_crisis_type (crisis_type),
    INDEX idx_crisis_severity (severity_level),
    INDEX idx_crisis_status (status),
    INDEX idx_crisis_responder (responder_id),
    INDEX idx_crisis_created (created_at)
);

-- Crisis Response Log
CREATE TABLE IF NOT EXISTS crisis_response_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    crisis_call_id INT UNSIGNED NOT NULL,
    responder_id INT UNSIGNED NOT NULL,
    action_taken TEXT NOT NULL,
    outcome ENUM('resolved', 'escalated', 'referred', 'ongoing') NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_crisis_log_call FOREIGN KEY (crisis_call_id) REFERENCES crisis_calls(id) ON DELETE CASCADE,
    CONSTRAINT fk_crisis_log_responder FOREIGN KEY (responder_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_crisis_log_call (crisis_call_id),
    INDEX idx_crisis_log_responder (responder_id),
    INDEX idx_crisis_log_outcome (outcome)
);

-- =====================================================
-- 7. DONATION TABLES
-- =====================================================

-- Donations
CREATE TABLE IF NOT EXISTS donations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    donor_id INT UNSIGNED NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) NOT NULL DEFAULT 'USD',
    payment_method ENUM('credit_card', 'debit_card', 'bank_transfer', 'paypal', 'other') NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
    transaction_id VARCHAR(100) NULL UNIQUE,
    event_id INT UNSIGNED NULL,
    is_anonymous TINYINT(1) NOT NULL DEFAULT 0,
    donor_message TEXT NULL,
    admin_notes TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_donation_donor FOREIGN KEY (donor_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_donation_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_donations_donor (donor_id),
    INDEX idx_donations_status (payment_status),
    INDEX idx_donations_event (event_id),
    INDEX idx_donations_created (created_at),
    INDEX idx_donations_transaction (transaction_id)
);

-- =====================================================
-- 8. EVENT TABLES
-- =====================================================

-- Events
CREATE TABLE IF NOT EXISTS events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    event_type ENUM('workshop', 'seminar', 'support_group', 'fundraiser', 'awareness_campaign', 'other') NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    location VARCHAR(200) NULL,
    max_participants INT UNSIGNED NULL,
    current_participants INT UNSIGNED NOT NULL DEFAULT 0,
    registration_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    is_public TINYINT(1) NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    organizer_id INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_event_organizer FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_events_organizer (organizer_id),
    INDEX idx_events_type (event_type),
    INDEX idx_events_dates (start_date, end_date),
    INDEX idx_events_public (is_public),
    INDEX idx_events_active (is_active)
);

-- Event Participants
CREATE TABLE IF NOT EXISTS event_participants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    attendance_status ENUM('registered', 'attended', 'no_show', 'cancelled') NOT NULL DEFAULT 'registered',
    attendance_notes TEXT NULL,
    
    -- Foreign key constraints
    CONSTRAINT fk_participant_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    CONSTRAINT fk_participant_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Unique constraint to prevent duplicate registrations
    UNIQUE KEY unique_event_user (event_id, user_id),
    
    -- Indexes
    INDEX idx_participants_event (event_id),
    INDEX idx_participants_user (user_id),
    INDEX idx_participants_status (attendance_status)
);

-- Event Proof Uploads
CREATE TABLE IF NOT EXISTS event_proof_uploads (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT UNSIGNED NOT NULL,
    uploaded_by INT UNSIGNED NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size INT UNSIGNED NOT NULL,
    description TEXT NULL,
    is_approved TINYINT(1) NOT NULL DEFAULT 0,
    approved_at DATETIME NULL,
    approved_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_proof_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    CONSTRAINT fk_proof_uploader FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_proof_approver FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_proof_event (event_id),
    INDEX idx_proof_uploader (uploaded_by),
    INDEX idx_proof_approved (is_approved)
);

-- =====================================================
-- 9. UNIVERSITY TABLES
-- =====================================================

-- Universities
CREATE TABLE IF NOT EXISTS universities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    short_name VARCHAR(20) NOT NULL UNIQUE,
    domain VARCHAR(100) NOT NULL UNIQUE,
    address TEXT NULL,
    city VARCHAR(100) NULL,
    state VARCHAR(100) NULL,
    country VARCHAR(100) NULL,
    postal_code VARCHAR(20) NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(100) NULL,
    website VARCHAR(200) NULL,
    logo_path VARCHAR(500) NULL,
    primary_color VARCHAR(7) NULL,
    secondary_color VARCHAR(7) NULL,
    timezone VARCHAR(50) NOT NULL DEFAULT 'UTC',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes
    INDEX idx_universities_domain (domain),
    INDEX idx_universities_active (is_active),
    INDEX idx_universities_country (country)
);

-- University Representatives
CREATE TABLE IF NOT EXISTS university_representatives (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    university_id INT UNSIGNED NOT NULL,
    position VARCHAR(100) NOT NULL,
    department VARCHAR(100) NULL,
    phone_number VARCHAR(20) NULL,
    is_primary TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_rep_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_rep_university FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_reps_user (user_id),
    INDEX idx_reps_university (university_id),
    INDEX idx_reps_primary (is_primary),
    INDEX idx_reps_active (is_active)
);

-- =====================================================
-- 10. ADDITIONAL SUPPORTING TABLES
-- =====================================================

-- User Sessions (for tracking active sessions)
CREATE TABLE IF NOT EXISTS user_sessions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NULL,
    expires_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_session_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_sessions_user (user_id),
    INDEX idx_sessions_token (session_token),
    INDEX idx_sessions_expires (expires_at)
);

-- System Settings
CREATE TABLE IF NOT EXISTS system_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    setting_type ENUM('string', 'integer', 'boolean', 'json') NOT NULL DEFAULT 'string',
    description TEXT NULL,
    is_public TINYINT(1) NOT NULL DEFAULT 0,
    updated_by INT UNSIGNED NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_setting_updater FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_settings_key (setting_key),
    INDEX idx_settings_public (is_public)
);

-- =====================================================
-- 11. SAMPLE DATA INSERTIONS
-- =====================================================

-- Insert sample university
INSERT INTO universities (name, short_name, domain, city, state, country, timezone) VALUES
('Sample University', 'SU', 'sample.edu', 'Sample City', 'Sample State', 'United States', 'America/New_York');

-- Insert sample forum categories
INSERT INTO forum_categories (name, description, sort_order) VALUES
('General Discussion', 'General mental health discussions and support', 1),
('Anxiety & Stress', 'Support for anxiety and stress management', 2),
('Depression Support', 'Community support for depression', 3),
('Academic Stress', 'Managing academic pressures and workload', 4),
('Relationships', 'Support for relationship and social issues', 5),
('Crisis Support', 'Immediate support and crisis resources', 6);

-- Insert sample resource categories
INSERT INTO resource_categories (name, description, sort_order) VALUES
('Self-Help Guides', 'Self-help resources and guides', 1),
('Crisis Resources', 'Emergency and crisis support materials', 2),
('Academic Support', 'Resources for academic stress management', 3),
('Meditation & Mindfulness', 'Meditation and mindfulness resources', 4),
('Professional Resources', 'Resources for mental health professionals', 5);

-- Insert sample system settings
INSERT INTO system_settings (setting_key, setting_value, setting_type, description, is_public) VALUES
('site_name', 'MindHeaven', 'string', 'Name of the mental health platform', 1),
('crisis_hotline', '1-800-273-8255', 'string', 'National crisis hotline number', 1),
('max_file_upload_size', '10485760', 'integer', 'Maximum file upload size in bytes (10MB)', 0),
('session_timeout', '3600', 'integer', 'Session timeout in seconds (1 hour)', 0),
('enable_registration', 'true', 'boolean', 'Whether new user registration is enabled', 1);

-- =====================================================
-- 12. TRIGGERS FOR AUTOMATIC UPDATES
-- =====================================================

-- Trigger to update thread reply count and last reply info
DELIMITER //
CREATE TRIGGER update_thread_stats_after_post_insert
AFTER INSERT ON forum_posts
FOR EACH ROW
BEGIN
    UPDATE forum_threads 
    SET reply_count = reply_count + 1,
        last_reply_at = NEW.created_at,
        last_reply_user_id = NEW.user_id
    WHERE id = NEW.thread_id;
END//

-- Trigger to update event participant count
CREATE TRIGGER update_event_participant_count_after_insert
AFTER INSERT ON event_participants
FOR EACH ROW
BEGIN
    UPDATE events 
    SET current_participants = current_participants + 1
    WHERE id = NEW.event_id;
END//

-- Trigger to update event participant count after deletion
CREATE TRIGGER update_event_participant_count_after_delete
AFTER DELETE ON event_participants
FOR EACH ROW
BEGIN
    UPDATE events 
    SET current_participants = current_participants - 1
    WHERE id = OLD.event_id;
END//

DELIMITER ;

-- =====================================================
-- END OF SCHEMA
-- =====================================================

