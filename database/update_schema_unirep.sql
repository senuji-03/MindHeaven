-- Add password_reset_required to users
ALTER TABLE users ADD COLUMN IF NOT EXISTS password_reset_required TINYINT(1) DEFAULT 0;

-- Ensure university_representative is in the role ENUM
ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'undergraduate', 'counselor', 'moderator', 'call_responder', 'university_representative', 'university_rep', 'donor') NOT NULL;

-- Modify university_rep_events per instructions
ALTER TABLE university_rep_events
  ADD COLUMN IF NOT EXISTS short_description VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS target_amount DECIMAL(10,2) NULL,
  ADD COLUMN IF NOT EXISTS image_path VARCHAR(255) NULL,
  MODIFY COLUMN status ENUM('draft', 'published', 'cancelled', 'pending', 'approved', 'closed') DEFAULT 'pending';
