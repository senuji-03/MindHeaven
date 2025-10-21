-- SQL Table for Undergraduate Students
-- This table stores essential information for undergraduate students beyond the basic users table
-- Privacy-focused: Only essential contact information is stored

CREATE TABLE IF NOT EXISTS undergraduate_students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20) NOT NULL,
    date_of_birth DATE NULL,
    gender ENUM('male', 'female', 'other', 'prefer_not_to_say') NULL,
    preferred_language VARCHAR(10) DEFAULT 'en',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraint
    CONSTRAINT fk_undergrad_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes for better performance
    INDEX idx_undergrad_user (user_id),
    INDEX idx_undergrad_email (email),
    INDEX idx_undergrad_phone (phone_number),
    INDEX idx_undergrad_active (is_active)
);

-- Insert sample data (optional)
-- INSERT INTO undergraduate_students (user_id, full_name, email, phone_number, date_of_birth, gender) 
-- VALUES (2, 'John Doe', 'john.doe@university.edu', '+1234567890', '2000-05-15', 'male');
