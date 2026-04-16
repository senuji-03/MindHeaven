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
                (student_user_id, counselor_user_id, title, type, mode, date, time, notes, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
        ");
        $stmt->execute(array(
            $studentUserId,
            $counselorUserId,
            $title,
            $type,
            $mode,
            $date,
            $time,
            $notes
        ));
        return (int) $pdo->lastInsertId();
    }

    public function update(
        $id,
        $title,
        $type,
        $mode,
        $date,
        $time,
        $notes,
        $studentUserId = null
    ) {
        $pdo = Database::getConnection();

        $sql = "
            UPDATE appointments 
            SET title = ?, type = ?, mode = ?, date = ?, time = ?, notes = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ";
        $params = array($title, $type, $mode, $date, $time, $notes, $id);

        // Optional ownership check: only the booking student can edit
        if ($studentUserId !== null) {
            $sql .= " AND student_user_id = ?";
            $params[] = (int)$studentUserId;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function reschedule($id, $date, $time, $reason, $counselorUserId = null)
    {
        $pdo = Database::getConnection();

        // 1. Fetch current record to ensure we capture the CORRECT old values
        $stmt = $pdo->prepare("SELECT date, time, original_date, original_time FROM appointments WHERE id = ?");
        $stmt->execute(array($id));
        $current = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$current) {
            return false;
        }

        // 2. Determine what the 'original' values should be
        // If they are already set (from a 2nd reschedule), keep them. 
        // Otherwise, use the current (soon to be 'old') values.
        $originalDate = $current['original_date'] ? $current['original_date'] : $current['date'];
        $originalTime = $current['original_time'] ? $current['original_time'] : $current['time'];

        // 3. Perform the update
        $sql = "
            UPDATE appointments 
            SET original_date = ?,
                original_time = ?,
                date = ?, 
                time = ?, 
                reschedule_reason = ?, 
                status = 'rescheduled', 
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ";
        $params = array($originalDate, $originalTime, $date, $time, $reason, $id);

        // Optional ownership check for counselor
        if ($counselorUserId !== null) {
            $sql .= " AND counselor_user_id = ?";
            $params[] = (int)$counselorUserId;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function delete($id)
    {
        $pdo = Database::getConnection();
        error_log("Appointment model: Attempting to delete appointment with ID: " . $id);

        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute(array($id));

        $deleted = $stmt->rowCount() > 0;
        error_log("Appointment model: Delete result - " . ($deleted ? "SUCCESS" : "FAILED") . " (rows affected: " . $stmt->rowCount() . ")");

        return $deleted;
    }

    public function updateCounselorNotes($id, $notesJson)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE appointments SET counselor_notes = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        return $stmt->execute(array($notesJson, (int) $id));
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
                   COALESCE(us.full_name, u.full_name, u.username) AS student_name,
                   a.rejection_reason,
                   a.original_date,
                   a.original_time
            FROM appointments a
            LEFT JOIN users u ON a.student_user_id = u.id
            LEFT JOIN undergraduate_students us ON a.student_user_id = us.user_id
            WHERE a.counselor_user_id = :counselor_user_id
              AND (a.hidden_by_counselor = 0 OR a.hidden_by_counselor IS NULL)
              AND a.status IN ('accept', 'accepted', 'scheduled', 'confirmed')
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
     * Get in-progress appointments for a counselor.
     */
    public function getInProgressByCounselorUserId($counselorUserId)
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT a.*,
                   COALESCE(us.full_name, u.full_name, u.username) AS student_name
            FROM appointments a
            LEFT JOIN users u ON a.student_user_id = u.id
            LEFT JOIN undergraduate_students us ON a.student_user_id = us.user_id
            WHERE a.counselor_user_id = :counselor_user_id
              AND a.status = 'in_progress'
            ORDER BY a.date ASC, a.time ASC
        ";

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
              AND (a.hidden_by_counselor = 0 OR a.hidden_by_counselor IS NULL)
            ORDER BY a.date DESC, a.time DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':counselor_user_id' => (int) $counselorUserId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update the status of an appointment (pending/accepted/rejected/etc.).
     */
    public function updateStatus($id, $status, $rejectionReason = null)
    {
        $pdo = Database::getConnection();

        $sql = "UPDATE appointments SET status = ?, updated_at = CURRENT_TIMESTAMP";
        $params = array($status);

        if ($rejectionReason !== null) {
            $sql .= ", rejection_reason = ?";
            $params[] = $rejectionReason;
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    /**
     * Hide an appointment for the counselor (soft delete).
     */
    public function hideForCounselor($id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE appointments SET hidden_by_counselor = 1, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute(array((int)$id));
        return $stmt->rowCount() > 0;
    }

    /**
     * Get all previous session notes for a specific student.
     * Includes notes from all counselors the student has visited.
     */
    public function getHistoryByStudentId($studentUserId)
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT 
                a.id,
                a.date,
                a.time,
                a.title,
                a.counselor_notes,
                COALESCE(c.full_name, u.full_name, u.username) AS counselor_name
            FROM appointments a
            LEFT JOIN users u ON a.counselor_user_id = u.id
            LEFT JOIN counselors c ON a.counselor_user_id = c.user_id
            WHERE a.student_user_id = :student_user_id
              AND a.counselor_notes IS NOT NULL
              AND a.counselor_notes != ''
            ORDER BY a.date DESC, a.time DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':student_user_id' => (int) $studentUserId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        // Auto-add reschedule_reason column and modify status enum if missing
        $cols = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'reschedule_reason'")->fetchAll();
        if (empty($cols)) {
            $pdo->exec("ALTER TABLE appointments ADD COLUMN `reschedule_reason` text DEFAULT NULL AFTER `rejection_reason`");
            $pdo->exec("ALTER TABLE appointments MODIFY COLUMN status ENUM('scheduled','confirmed','in_progress','completed','cancelled','no_show','pending','accept','accepted','reject','rejected','rescheduled') NOT NULL DEFAULT 'scheduled'");
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
                a.rejection_reason,
                a.reschedule_reason,
                a.meeting_link,
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
        $stmt->execute(array(':student_user_id' => (int)$studentUserId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the total number of unique patients for a counselor.
     */
    public function getTotalPatients($counselorUserId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(DISTINCT student_user_id) as total FROM appointments WHERE counselor_user_id = ? AND status NOT IN ('reject', 'rejected')");
        $stmt->execute(array((int)$counselorUserId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    /**
     * Get the number of sessions scheduled for today for a counselor.
     */
    public function getTodaysSessionsCount($counselorUserId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM appointments WHERE counselor_user_id = ? AND date = CURDATE() AND status IN ('accept', 'accepted', 'scheduled', 'confirmed')");
        $stmt->execute(array((int)$counselorUserId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['count'] : 0;
    }

    public function getById($id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmt->execute(array((int)$id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update the meeting link (Daily.co URL) for an appointment.
     */
    public function updateMeetingLink($id, $url)
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE appointments SET meeting_link = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(array($url, (int)$id));
    }

    /**
     * Get session history for a counselor.
     * Covers: completed, cancelled, rejected (=cancelled), no_show, rescheduled.
     * Optionally filter by logical status: completed | cancelled | no_show | rescheduled
     *
     * @param int    $counselorUserId
     * @param string $statusFilter  One of the above logical values, or '' for all
     * @return array
     */
    public function getSessionHistory($counselorUserId, $statusFilter = '')
    {
        $pdo = Database::getConnection();

        $columns = "
            a.id,
            a.title,
            a.type,
            a.mode,
            a.date,
            a.time,
            a.notes,
            a.status,
            a.rejection_reason,
            a.reschedule_reason,
            a.original_date,
            a.original_time,
            a.counselor_notes,
            a.created_at,
            a.updated_at,
            a.student_user_id,
            COALESCE(us.full_name, u.full_name, u.username) AS student_name
        ";

        $joins = "
            FROM appointments a
            LEFT JOIN users u ON a.student_user_id = u.id
            LEFT JOIN undergraduate_students us ON a.student_user_id = us.user_id
        ";

        switch ($statusFilter) {
            case 'completed':
                $sql = "SELECT $columns $joins WHERE a.counselor_user_id = :cid AND a.status = 'completed' ORDER BY a.date DESC, a.time DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':cid' => (int) $counselorUserId));
                break;

            case 'cancelled':
                // Both 'cancelled' and 'rejected' are shown under Cancelled
                $sql = "SELECT $columns $joins WHERE a.counselor_user_id = :cid AND a.status IN ('cancelled','rejected') ORDER BY a.date DESC, a.time DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':cid' => (int) $counselorUserId));
                break;

            case 'no_show':
                $sql = "SELECT $columns $joins WHERE a.counselor_user_id = :cid AND a.status IN ('no_show','no-show') ORDER BY a.date DESC, a.time DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':cid' => (int) $counselorUserId));
                break;

            case 'rescheduled':
                // Rescheduled is no longer in history, but we keep the case empty 
                // or handle it if someone specifically requests it via API
                $sql = "SELECT $columns $joins WHERE 1=0"; // Return nothing
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                break;

            case 'overdue':
                $sql = "
                    SELECT $columns $joins 
                    WHERE a.counselor_user_id = :cid 
                    AND a.status IN ('scheduled', 'confirmed', 'accept', 'accepted', 'pending') 
                    AND (a.date < CURDATE() OR (a.date = CURDATE() AND a.time < CURTIME()))
                    ORDER BY a.date DESC, a.time DESC
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':cid' => (int) $counselorUserId));
                break;

            default:
                // All historical statuses PLUS Overdue (Active but Past)
                $sql = "
                    SELECT $columns $joins 
                    WHERE a.counselor_user_id = :cid 
                    AND (
                        a.status IN ('completed','cancelled','rejected','no_show','no-show')
                        OR (
                            a.status IN ('scheduled', 'confirmed', 'accept', 'accepted', 'pending') 
                            AND (a.date < CURDATE() OR (a.date = CURDATE() AND a.time < CURTIME()))
                        )
                    )
                    ORDER BY a.date DESC, a.time DESC
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':cid' => (int) $counselorUserId));
                break;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get aggregate session-history stats for a counselor.
     * 'rejected' counts as cancelled for display purposes.
     *
     * @param int $counselorUserId
     * @return array
     */
    public function getSessionHistoryStats($counselorUserId)
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT
                COUNT(*) AS total,
                SUM(YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())) AS this_month,
                SUM(status = 'completed')                                             AS completed,
                SUM(status IN ('cancelled','rejected'))                               AS cancelled,
                SUM(status IN ('no_show','no-show'))                                  AS no_show,
                SUM(status IN ('scheduled', 'confirmed', 'accept', 'accepted', 'pending') AND (date < CURDATE() OR (date = CURDATE() AND time < CURTIME()))) AS overdue
            FROM appointments
            WHERE counselor_user_id = :counselor_user_id
              AND (
                status IN ('completed', 'cancelled', 'rejected', 'no_show', 'no-show')
                OR (
                    status IN ('scheduled', 'confirmed', 'accept', 'accepted', 'pending')
                    AND (date < CURDATE() OR (date = CURDATE() AND time < CURTIME()))
                )
              )
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':counselor_user_id' => (int) $counselorUserId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return array(
                'total'       => 0,
                'this_month'  => 0,
                'completed'   => 0,
                'cancelled'   => 0,
                'no_show'     => 0,
                'overdue'     => 0
            );
        }

        return array(
            'total'       => (int) $row['total'],
            'this_month'  => (int) $row['this_month'],
            'completed'   => (int) $row['completed'],
            'cancelled'   => (int) $row['cancelled'],
            'no_show'     => (int) $row['no_show'],
            'overdue'     => (int) $row['overdue']
        );
    }
    /**
     * Get all appointments for admin view.
     * Includes student and counselor names.
     */
    public function getAllForAdmin()
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT 
                a.*,
                COALESCE(us.full_name, u1.username, 'N/A') AS student_name,
                COALESCE(c.full_name, u2.username, 'N/A') AS counselor_name
            FROM appointments a
            LEFT JOIN undergraduate_students us ON a.student_user_id = us.user_id
            LEFT JOIN users u1 ON a.student_user_id = u1.id
            LEFT JOIN counselors c ON a.counselor_user_id = c.user_id
            LEFT JOIN users u2 ON a.counselor_user_id = u2.id
            ORDER BY a.date DESC, a.time DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get global appointment statistics for admin.
     */
    public function getAdminStats()
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT
                COUNT(*) AS total,
                SUM(status IN ('completed')) AS completed,
                SUM(status IN ('scheduled', 'confirmed', 'accept', 'accepted', 'pending') AND (date > CURDATE() OR (date = CURDATE() AND time >= CURTIME()))) AS upcoming,
                SUM(status IN ('scheduled', 'confirmed', 'accept', 'accepted', 'pending') AND (date < CURDATE() OR (date = CURDATE() AND time < CURTIME()))) AS overdue,
                SUM(status IN ('cancelled', 'reject', 'rejected')) AS cancelled
            FROM appointments
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return array(
            'total'     => (int) ($row['total'] ?? 0),
            'completed' => (int) ($row['completed'] ?? 0),
            'upcoming'  => (int) ($row['upcoming'] ?? 0),
            'overdue'   => (int) ($row['overdue'] ?? 0),
            'cancelled' => (int) ($row['cancelled'] ?? 0)
        );
    }
}
