-- Create university_rep_events table for University Representative events
-- This table stores events created by University Representatives

CREATE TABLE IF NOT EXISTS university_rep_events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    university_rep_id INT UNSIGNED NOT NULL,
    event_title VARCHAR(255) NOT NULL,
    event_type ENUM('awareness_program', 'workshop', 'talk', 'campaign', 'seminar', 'other') NOT NULL,
    description TEXT NOT NULL,
    organized_by VARCHAR(255) NOT NULL,
    target_audience TEXT NULL,
    open_for ENUM('all_universities', 'specific_university') NOT NULL,
    event_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    venue VARCHAR(255) NOT NULL,
    mode ENUM('on_site', 'online', 'hybrid') NOT NULL,
    max_participants INT NULL,
    registration_deadline DATE NULL,
    contact_person VARCHAR(255) NULL,
    contact_email VARCHAR(100) NULL,
    contact_phone VARCHAR(20) NULL,
    additional_info TEXT NULL,
    status ENUM('draft', 'published', 'cancelled') DEFAULT 'draft',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraint
    CONSTRAINT fk_university_rep_events_user FOREIGN KEY (university_rep_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_university_rep_events_user (university_rep_id),
    INDEX idx_university_rep_events_date (event_date),
    INDEX idx_university_rep_events_status (status),
    INDEX idx_university_rep_events_type (event_type)
);
