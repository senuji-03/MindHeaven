-- Create habits table
CREATE TABLE IF NOT EXISTS habits (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    category ENUM('health', 'fitness', 'wellness', 'learning', 'productivity', 'mindfulness', 'social', 'other') NOT NULL DEFAULT 'other',
    frequency ENUM('daily', 'weekly', 'custom') NOT NULL DEFAULT 'daily',
    target_days INT UNSIGNED DEFAULT 1 COMMENT 'Target days per week for weekly habits',
    color VARCHAR(7) DEFAULT '#10b981' COMMENT 'Hex color for habit display',
    icon VARCHAR(50) DEFAULT '🎯' COMMENT 'Emoji or icon for habit',
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraint
    CONSTRAINT fk_habits_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Indexes
    INDEX idx_habits_user (user_id),
    INDEX idx_habits_category (category),
    INDEX idx_habits_active (is_active),
    INDEX idx_habits_created (created_at)
);

-- Create habit_completions table
CREATE TABLE IF NOT EXISTS habit_completions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    habit_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    completion_date DATE NOT NULL,
    completion_time TIME NULL,
    notes TEXT NULL,
    mood_rating TINYINT UNSIGNED NULL CHECK (mood_rating >= 1 AND mood_rating <= 5),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_habit_completions_habit FOREIGN KEY (habit_id) REFERENCES habits(id) ON DELETE CASCADE,
    CONSTRAINT fk_habit_completions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Unique constraint to prevent duplicate completions on same day
    UNIQUE KEY unique_daily_completion (habit_id, completion_date),
    
    -- Indexes
    INDEX idx_habit_completions_habit (habit_id),
    INDEX idx_habit_completions_user (user_id),
    INDEX idx_habit_completions_date (completion_date)
);

-- Create habit_streaks table
CREATE TABLE IF NOT EXISTS habit_streaks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    habit_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    current_streak INT UNSIGNED DEFAULT 0,
    longest_streak INT UNSIGNED DEFAULT 0,
    last_completion_date DATE NULL,
    streak_start_date DATE NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    CONSTRAINT fk_habit_streaks_habit FOREIGN KEY (habit_id) REFERENCES habits(id) ON DELETE CASCADE,
    CONSTRAINT fk_habit_streaks_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Unique constraint per habit per user
    UNIQUE KEY unique_habit_streak (habit_id, user_id),
    
    -- Indexes
    INDEX idx_habit_streaks_habit (habit_id),
    INDEX idx_habit_streaks_user (user_id)
);
