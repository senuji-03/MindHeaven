-- ============================================================
-- MindHeaven — Chat System SQL Setup
-- Run these queries in phpMyAdmin (mindheaven database)
-- or via the MySQL CLI: mysql -u root mindheaven < chat_setup.sql
-- ============================================================

-- 1. Chat Sessions
--    One row per unique counselor <-> undergrad chat room.
--    Using INSERT IGNORE so re-running is safe.
CREATE TABLE IF NOT EXISTS chat_sessions (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    counselor_user_id INT NOT NULL,
    undergrad_user_id INT NOT NULL,
    appointment_id    INT          DEFAULT NULL COMMENT 'Optional link to an appointment',
    title             VARCHAR(255) DEFAULT 'Counselling Chat',
    status            ENUM('active','closed','archived') NOT NULL DEFAULT 'active',
    created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Each pair can only have ONE session row
    UNIQUE KEY uniq_pair (counselor_user_id, undergrad_user_id),

    CONSTRAINT fk_cs_counselor FOREIGN KEY (counselor_user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_cs_undergrad FOREIGN KEY (undergrad_user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2. Chat Messages
--    Individual messages within a session.
--    Soft-deleted via is_deleted flag (never hard-deleted for audit trail).
--    edited_at tracks the last edit timestamp.
CREATE TABLE IF NOT EXISTS chat_messages (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    session_id      INT NOT NULL,
    sender_user_id  INT NOT NULL,
    message         TEXT NOT NULL,
    is_deleted      TINYINT(1)   NOT NULL DEFAULT 0  COMMENT '1 = soft deleted',
    edited_at       DATETIME              DEFAULT NULL COMMENT 'Set when message is edited',
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    -- Indexes for performance on common queries
    INDEX idx_session   (session_id),
    INDEX idx_sender    (sender_user_id),
    INDEX idx_created   (created_at),

    CONSTRAINT fk_cm_session FOREIGN KEY (session_id)
        REFERENCES chat_sessions(id) ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_cm_sender FOREIGN KEY (sender_user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- CRUD Operation Summary
-- ============================================================
--
-- CREATE  -> INSERT INTO chat_messages (session_id, sender_user_id, message)
-- READ    -> SELECT … FROM chat_messages WHERE session_id = ? AND is_deleted = 0
-- UPDATE  -> UPDATE chat_messages SET message = ?, edited_at = NOW() WHERE id = ? AND sender_user_id = ?
-- DELETE  -> UPDATE chat_messages SET is_deleted = 1 WHERE id = ? AND sender_user_id = ?
--
-- Access control: every SELECT/INSERT/UPDATE checks that the
-- session's counselor_user_id OR undergrad_user_id matches the
-- logged-in PHP session user_id (enforced in Chat.php model).
-- ============================================================
