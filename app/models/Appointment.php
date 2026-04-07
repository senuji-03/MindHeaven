<?php

class Appointment
{
    public function create(
        $studentUserId,
        $counselorUserId,
        $title,
        $type,
        $mode,
        $date,
        $time,
        $notes
    ) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO appointments 
                (student_user_id, counselor_user_id, title, type, mode, date, time, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $studentUserId,
            $counselorUserId,
            $title,
            $type,
            $mode,
            $date,
            $time,
            $notes
        ]);
        return (int) $pdo->lastInsertId();
    }

    public function update(
        $id,
        $title,
        $type,
        $date,
        $time,
        $notes
    ) {
        $pdo = Database::getConnection();
        error_log("Appointment model: Attempting to update appointment with ID: " . $id);

        $stmt = $pdo->prepare("
            UPDATE appointments 
            SET title = ?, type = ?, date = ?, time = ?, notes = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        $stmt->execute([$title, $type, $date, $time, $notes, $id]);

        $updated = $stmt->rowCount() > 0;
        error_log("Appointment model: Update result - " . ($updated ? "SUCCESS" : "FAILED") . " (rows affected: " . $stmt->rowCount() . ")");

        return $updated;
    }

    public function delete($id)
    {
        $pdo = Database::getConnection();
        error_log("Appointment model: Attempting to delete appointment with ID: " . $id);

        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$id]);

        $deleted = $stmt->rowCount() > 0;
        error_log("Appointment model: Delete result - " . ($deleted ? "SUCCESS" : "FAILED") . " (rows affected: " . $stmt->rowCount() . ")");

        return $deleted;
    }

    /**
     * Get upcoming appointments for a counselor (booked by undergrads).
     * Only appointments that have been accepted by the counselor are returned.
     */
    public function getUpcomingByCounselorUserId($counselorUserId, $limit = 3)
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT a.*,
                   COALESCE(us.full_name, u.full_name, u.username) AS student_name
            FROM appointments a
            LEFT JOIN users u ON a.student_user_id = u.id
            LEFT JOIN undergraduate_students us ON a.student_user_id = us.user_id
            WHERE a.counselor_user_id = :counselor_user_id
              AND a.status IN ('accept', 'accepted')
              AND (
                a.date > CURDATE()
                OR (a.date = CURDATE() AND a.time >= CURTIME())
              )
            ORDER BY a.date ASC, a.time ASC
            LIMIT " . (int) $limit;

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':counselor_user_id' => (int) $counselorUserId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all appointments for a counselor (booked by undergrads).
     * Used by the counselor Appointment Management view.
     */
    public function getByCounselorUserId($counselorUserId)
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT 
                a.*,
                COALESCE(us.full_name, u.full_name, u.username) AS student_name
            FROM appointments a
            LEFT JOIN users u ON a.student_user_id = u.id
            LEFT JOIN undergraduate_students us ON a.student_user_id = us.user_id
            WHERE a.counselor_user_id = :counselor_user_id
            ORDER BY a.date DESC, a.time DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':counselor_user_id' => (int) $counselorUserId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update the status of an appointment (pending/accepted/rejected/etc.).
     */
    public function updateStatus($id, $status)
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            UPDATE appointments 
            SET status = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        $stmt->execute([$status, $id]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Get all appointments for a student (the logged-in undergrad).
     */
    public function getByStudentUserId($studentUserId)
    {
        $pdo = Database::getConnection();

        // Auto-add mode column if missing (same guard as AppointmentApiControl)
        $cols = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'mode'")->fetchAll();
        if (empty($cols)) {
            $pdo->exec("ALTER TABLE appointments ADD COLUMN `mode` VARCHAR(20) NOT NULL DEFAULT 'audio_video' AFTER `type`");
        }

        $sql = "
            SELECT 
                a.id,
                a.title,
                a.type,
                IFNULL(a.mode, 'audio_video')   AS mode,
                a.date,
                a.time,
                a.notes,
                IFNULL(a.status, 'pending')     AS status,
                a.counselor_user_id,
                COALESCE(c.full_name, u2.username, 'Unknown') AS counselor_name,
                c.specialization
            FROM appointments a
            LEFT JOIN counselors c  ON a.counselor_user_id = c.user_id
            LEFT JOIN users     u2 ON a.counselor_user_id  = u2.id
            WHERE a.student_user_id = :student_user_id
            ORDER BY a.date DESC, a.time DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':student_user_id' => (int)$studentUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the total number of unique patients for a counselor.
     */
    public function getTotalPatients($counselorUserId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(DISTINCT student_user_id) as total FROM appointments WHERE counselor_user_id = ? AND status NOT IN ('reject', 'rejected')");
        $stmt->execute([(int)$counselorUserId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    /**
     * Get the number of sessions scheduled for today for a counselor.
     */
    public function getTodaysSessionsCount($counselorUserId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM appointments WHERE counselor_user_id = ? AND date = CURDATE() AND status IN ('accept', 'accepted')");
        $stmt->execute([(int)$counselorUserId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['count'] : 0;
    }
}
