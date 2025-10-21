-- Create feedback table that matches the Feedback model expectations
CREATE TABLE IF NOT EXISTS feedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    feedback_type ENUM('general', 'counselor', 'platform', 'feature_request') NOT NULL,
    counselor_id INT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    rating INT NULL CHECK (rating >= 1 AND rating <= 5),
    is_anonymous TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('pending', 'reviewed', 'resolved') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_feedback_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_feedback_counselor FOREIGN KEY (counselor_id) REFERENCES counselors(id) ON DELETE SET NULL,
    
    -- Indexes
    INDEX idx_feedback_user (user_id),
    INDEX idx_feedback_type (feedback_type),
    INDEX idx_feedback_counselor (counselor_id),
    INDEX idx_feedback_status (status),
    INDEX idx_feedback_created (created_at)
);
