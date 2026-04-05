<?php

/**
 * Chat Model
 * Handles all database interactions for chat sessions and messages.
 * Enforces access control so only the two parties in a session can read/write.
 */
class Chat
{

    private $pdo;

    // Max minutes a sender can edit their own message
    const EDIT_WINDOW_MINUTES = 15;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // =========================================================================
    // CHAT SESSION METHODS
    // =========================================================================

    /**
     * Find an existing session between counselor & undergrad, or create one.
     * READ + CREATE combined to fetch-or-create a private room.
     *
     * @param int $counselorUserId
     * @param int $undergradUserId
     * @return int  session id
     */
    public function findOrCreateSession(int $counselorUserId, int $undergradUserId): int
    {
        // Try to find an existing active session
        $stmt = $this->pdo->prepare("
            SELECT id FROM chat_sessions
             WHERE counselor_user_id = :c AND undergrad_user_id = :u
             LIMIT 1
        ");
        $stmt->execute([':c' => $counselorUserId, ':u' => $undergradUserId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return (int) $row['id'];
        }

        // CREATE: new session
        $stmt = $this->pdo->prepare("
            INSERT INTO chat_sessions (counselor_user_id, undergrad_user_id, status)
            VALUES (:c, :u, 'active')
        ");
        $stmt->execute([':c' => $counselorUserId, ':u' => $undergradUserId]);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Return a session row — used to verify it exists and is accessible.
     *
     * @param int $sessionId
     * @return array|false
     */
    public function getSessionById(int $sessionId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chat_sessions WHERE id = ?");
        $stmt->execute([$sessionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verify that $userId is a participant in the session.
     * Returns true if the user is either the counselor or the undergrad.
     *
     * @param int $sessionId
     * @param int $userId
     * @return bool
     */
    public function userBelongsToSession(int $sessionId, int $userId): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT id FROM chat_sessions
             WHERE id = ? AND (counselor_user_id = ? OR undergrad_user_id = ?)
             LIMIT 1
        ");
        $stmt->execute([$sessionId, $userId, $userId]);
        return $stmt->fetch() !== false;
    }

    /**
     * Get all chat sessions for a counselor (list view).
     * Joins to pull the undergrad's display name.
     *
     * @param int $counselorUserId
     * @return array
     */
    public function getSessionsForCounselor(int $counselorUserId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                cs.id,
                cs.status,
                cs.created_at,
                cs.updated_at,
                u.id            AS undergrad_user_id,
                COALESCE(us.full_name, u.username) AS other_name,
                u.username      AS other_username,
                (
                    SELECT cm.message
                      FROM chat_messages cm
                     WHERE cm.session_id = cs.id AND cm.is_deleted = 0
                     ORDER BY cm.created_at DESC
                     LIMIT 1
                ) AS last_message,
                (
                    SELECT cm.created_at
                      FROM chat_messages cm
                     WHERE cm.session_id = cs.id AND cm.is_deleted = 0
                     ORDER BY cm.created_at DESC
                     LIMIT 1
                ) AS last_message_at
              FROM chat_sessions cs
              JOIN users u ON u.id = cs.undergrad_user_id
              LEFT JOIN undergraduate_students us ON us.user_id = u.id
             WHERE cs.counselor_user_id = :cid
             ORDER BY last_message_at DESC, cs.updated_at DESC
        ");
        $stmt->execute([':cid' => $counselorUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all chat sessions for an undergrad (list view).
     * Joins to pull the counselor's display name.
     *
     * @param int $undergradUserId
     * @return array
     */
    public function getSessionsForUndergrad(int $undergradUserId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                cs.id,
                cs.status,
                cs.created_at,
                cs.updated_at,
                u.id            AS counselor_user_id,
                COALESCE(c.full_name, u.username) AS other_name,
                u.username      AS other_username,
                (
                    SELECT cm.message
                      FROM chat_messages cm
                     WHERE cm.session_id = cs.id AND cm.is_deleted = 0
                     ORDER BY cm.created_at DESC
                     LIMIT 1
                ) AS last_message,
                (
                    SELECT cm.created_at
                      FROM chat_messages cm
                     WHERE cm.session_id = cs.id AND cm.is_deleted = 0
                     ORDER BY cm.created_at DESC
                     LIMIT 1
                ) AS last_message_at
              FROM chat_sessions cs
              JOIN users u ON u.id = cs.counselor_user_id
              LEFT JOIN counselors c ON c.user_id = u.id
             WHERE cs.undergrad_user_id = :uid
             ORDER BY last_message_at DESC, cs.updated_at DESC
        ");
        $stmt->execute([':uid' => $undergradUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all undergrads this counselor has had any appointment with.
     * Used to populate the "Start new chat" dropdown for counselors.
     *
     * @param int $counselorUserId
     * @return array
     */
    public function getUndergradsByAppointments(int $counselorUserId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT
                u.id        AS user_id,
                COALESCE(us.full_name, u.username) AS full_name,
                u.username
              FROM appointments a
              JOIN users u ON u.id = a.student_user_id
              LEFT JOIN undergraduate_students us ON us.user_id = u.id
             WHERE a.counselor_user_id = :cid
             ORDER BY full_name ASC
        ");
        $stmt->execute([':cid' => $counselorUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================================================================
    // CHAT MESSAGE METHODS  (C-R-U-D)
    // =========================================================================

    /**
     * CREATE — Insert a new message into the given session.
     *
     * @param int    $sessionId
     * @param int    $senderUserId
     * @param string $message
     * @return int  New message id
     */
    public function sendMessage(int $sessionId, int $senderUserId, string $message): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO chat_messages (session_id, sender_user_id, message)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$sessionId, $senderUserId, $message]);

        // Touch the session's updated_at so the list ordering stays fresh
        $this->pdo->prepare("
            UPDATE chat_sessions SET updated_at = NOW() WHERE id = ?
        ")->execute([$sessionId]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * READ — Fetch all visible (non-deleted) messages in a session.
     * Includes sender display name and whether the message was edited.
     *
     * @param int $sessionId
     * @param int $currentUserId  Needed to mark messages as own/other
     * @return array
     */
    public function getMessages(int $sessionId, int $currentUserId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                cm.id,
                cm.session_id,
                cm.sender_user_id,
                cm.message,
                cm.is_deleted,
                cm.edited_at,
                cm.created_at,
                COALESCE(us.full_name, c.full_name, u.username) AS sender_name,
                (cm.sender_user_id = :uid) AS is_own,
                TIMESTAMPDIFF(MINUTE, cm.created_at, NOW()) AS minutes_since_sent
              FROM chat_messages cm
              JOIN users u ON u.id = cm.sender_user_id
              LEFT JOIN undergraduate_students us ON us.user_id = u.id
              LEFT JOIN counselors c ON c.user_id = u.id
             WHERE cm.session_id = :sid
               AND cm.is_deleted = 0
             ORDER BY cm.created_at ASC
        ");
        $stmt->execute([':sid' => $sessionId, ':uid' => $currentUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * UPDATE — Edit the text of an existing message.
     * Only the sender can edit, and only within the allowed edit window.
     *
     * @param int    $messageId
     * @param int    $senderUserId  Must match the message's sender
     * @param string $newMessage
     * @return bool|string  true on success, error string on failure
     */
    public function editMessage(int $messageId, int $senderUserId, string $newMessage)
    {
        // Fetch the message
        $stmt = $this->pdo->prepare("SELECT * FROM chat_messages WHERE id = ? AND is_deleted = 0");
        $stmt->execute([$messageId]);
        $msg = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$msg) {
            return 'Message not found.';
        }
        if ((int) $msg['sender_user_id'] !== $senderUserId) {
            return 'You can only edit your own messages.';
        }
        $minutesAgo = (int) $this->pdo->query(
            "SELECT TIMESTAMPDIFF(MINUTE, '{$msg['created_at']}', NOW())"
        )->fetchColumn();
        if ($minutesAgo > self::EDIT_WINDOW_MINUTES) {
            return 'Messages can only be edited within ' . self::EDIT_WINDOW_MINUTES . ' minutes of sending.';
        }

        $stmt = $this->pdo->prepare("
            UPDATE chat_messages
               SET message = ?, edited_at = NOW()
             WHERE id = ? AND sender_user_id = ?
        ");
        $stmt->execute([$newMessage, $messageId, $senderUserId]);
        return $stmt->rowCount() > 0 ? true : 'Update failed.';
    }

    /**
     * DELETE (soft) — Mark a message as deleted.
     * Only the sender can delete their own message.
     *
     * @param int $messageId
     * @param int $senderUserId  Must match the message's sender
     * @return bool|string  true on success, error string on failure
     */
    public function deleteMessage(int $messageId, int $senderUserId)
    {
        // Verify ownership
        $stmt = $this->pdo->prepare("
            SELECT id FROM chat_messages WHERE id = ? AND sender_user_id = ? AND is_deleted = 0
        ");
        $stmt->execute([$messageId, $senderUserId]);
        if (!$stmt->fetch()) {
            return 'Message not found or you are not the sender.';
        }

        $stmt = $this->pdo->prepare("
            UPDATE chat_messages SET is_deleted = 1 WHERE id = ? AND sender_user_id = ?
        ");
        $stmt->execute([$messageId, $senderUserId]);
        return $stmt->rowCount() > 0 ? true : 'Delete failed.';
    }
}
