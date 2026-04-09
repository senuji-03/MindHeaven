<?php

class Timeslot
{
    /**
     * The 4 fixed hourly slots (5 PM–9 PM).
     */
    public static function fixedSlots()
    {
        return array(
            array('start' => '17:00:00', 'end' => '18:00:00', 'label' => '5:00 PM – 6:00 PM'),
            array('start' => '18:00:00', 'end' => '19:00:00', 'label' => '6:00 PM – 7:00 PM'),
            array('start' => '19:00:00', 'end' => '20:00:00', 'label' => '7:00 PM – 8:00 PM'),
            array('start' => '20:00:00', 'end' => '21:00:00', 'label' => '8:00 PM – 9:00 PM'),
        );
    }

    /**
     * Get all timeslots for a counselor on a given date.
     */
    public function getByDate($counselorUserId, $date)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT id, counselor_user_id, slot_date,
                   TIME_FORMAT(start_time, '%H:%i:%s') AS start_time,
                   TIME_FORMAT(end_time,   '%H:%i:%s') AS end_time,
                   slot_type, is_booked, is_frozen, created_at
            FROM counselor_timeslots
            WHERE counselor_user_id = ? AND slot_date = ?
            ORDER BY start_time ASC
        ");
        $stmt->execute(array((int)$counselorUserId, $date));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count how many timeslots a counselor has for a given date.
     */
    public function countByDate($counselorUserId, $date)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM counselor_timeslots
            WHERE counselor_user_id = ? AND slot_date = ?
        ");
        $stmt->execute(array((int)$counselorUserId, $date));
        return (int)$stmt->fetchColumn();
    }

    /**
     * Save fixed slot selections for a counselor on a given date.
     * Replaces all existing NOT-booked fixed slots for that day.
     *
     * @param int    $counselorUserId
     * @param string $date            YYYY-MM-DD
     * @param array  $startTimes      e.g. array('17:00:00', '19:00:00')
     * @return array array('saved'=>int, 'skipped'=>int, 'error'=>string|null)
     */
    public function saveFixed($counselorUserId, $date, array $startTimes)
    {
        $pdo = Database::getConnection();
        $pdo->beginTransaction();
        try {
            // Delete existing un-booked fixed slots for this day
            $del = $pdo->prepare("
                DELETE FROM counselor_timeslots
                WHERE counselor_user_id = ? AND slot_date = ? AND slot_type = 'fixed' AND is_booked = 0
            ");
            $del->execute(array((int)$counselorUserId, $date));

            // Count current booked + custom slots
            $cntStmt = $pdo->prepare("
                SELECT COUNT(*) FROM counselor_timeslots
                WHERE counselor_user_id = ? AND slot_date = ?
            ");
            $cntStmt->execute(array((int)$counselorUserId, $date));
            $existing = (int)$cntStmt->fetchColumn();

            $fixedMap = array();
            foreach (self::fixedSlots() as $fs) {
                $fixedMap[$fs['start']] = $fs['end'];
            }

            $saved   = 0;
            $skipped = 0;
            $ins = $pdo->prepare("
                INSERT IGNORE INTO counselor_timeslots
                    (counselor_user_id, slot_date, start_time, end_time, slot_type)
                VALUES (?, ?, ?, ?, 'fixed')
            ");

            foreach ($startTimes as $start) {
                if (!isset($fixedMap[$start])) continue;
                if ($existing + $saved >= 6) { $skipped++; continue; }
                $ins->execute(array((int)$counselorUserId, $date, $start, $fixedMap[$start]));
                $saved++;
            }

            $pdo->commit();
            return array('saved' => $saved, 'skipped' => $skipped, 'error' => null);
        } catch (Exception $e) {
            $pdo->rollBack();
            return array('saved' => 0, 'skipped' => 0, 'error' => $e->getMessage());
        }
    }

    /**
     * Create a custom timeslot. Enforces ≥ 45 min and max-6 per day.
     *
     * @return array array('id'=>int|null, 'error'=>string|null)
     */
    public function createCustom($counselorUserId, $date, $startTime, $endTime)
    {
        // Validate duration ≥ 45 min
        $start = strtotime($date . ' ' . $startTime);
        $end   = strtotime($date . ' ' . $endTime);
        if ($end <= $start) {
            return array('id' => null, 'error' => 'End time must be after start time.');
        }
        $minutes = ($end - $start) / 60;
        if ($minutes < 45) {
            return array('id' => null, 'error' => 'Custom slots must be at least 45 minutes long.');
        }

        $pdo = Database::getConnection();

        // Check max 6 slots
        $cnt = $this->countByDate($counselorUserId, $date);
        if ($cnt >= 6) {
            return array('id' => null, 'error' => 'Maximum 6 timeslots per day already reached.');
        }

        // Check for overlap with existing slots
        $overlapStmt = $pdo->prepare("
            SELECT COUNT(*) FROM counselor_timeslots
            WHERE counselor_user_id = ? AND slot_date = ?
              AND start_time < ? AND end_time > ?
        ");
        $overlapStmt->execute(array((int)$counselorUserId, $date, $endTime, $startTime));
        if ((int)$overlapStmt->fetchColumn() > 0) {
            return array('id' => null, 'error' => 'This timeslot overlaps with an existing slot.');
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO counselor_timeslots
                    (counselor_user_id, slot_date, start_time, end_time, slot_type)
                VALUES (?, ?, ?, ?, 'custom')
            ");
            $stmt->execute(array((int)$counselorUserId, $date, $startTime, $endTime));
            return array('id' => (int)$pdo->lastInsertId(), 'error' => null);
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                return array('id' => null, 'error' => 'A slot already exists at this start time.');
            }
            return array('id' => null, 'error' => $e->getMessage());
        }
    }

    /**
     * Update a custom timeslot (only if not booked and belongs to counselor).
     *
     * @return array array('success'=>bool, 'error'=>string|null)
     */
    public function updateCustom($id, $counselorUserId, $date, $startTime, $endTime)
    {
        // Validate duration ≥ 45 min
        $start = strtotime($date . ' ' . $startTime);
        $end   = strtotime($date . ' ' . $endTime);
        if ($end <= $start) {
            return array('success' => false, 'error' => 'End time must be after start time.');
        }
        $minutes = ($end - $start) / 60;
        if ($minutes < 45) {
            return array('success' => false, 'error' => 'Custom slots must be at least 45 minutes long.');
        }

        $pdo = Database::getConnection();

        // Verify ownership + not booked/frozen + is custom
        $check = $pdo->prepare("
            SELECT id, is_booked, is_frozen, slot_type FROM counselor_timeslots
            WHERE id = ? AND counselor_user_id = ?
        ");
        $check->execute(array((int)$id, (int)$counselorUserId));
        $row = $check->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return array('success' => false, 'error' => 'Timeslot not found.');
        }
        if ($row['is_booked'] || $row['is_frozen']) {
            return array('success' => false, 'error' => 'Cannot edit a booked or frozen timeslot.');
        }
        if ($row['slot_type'] !== 'custom') {
            return array('success' => false, 'error' => 'Only custom slots can be edited this way.');
        }

        // Check overlap (excluding self)
        $overlapStmt = $pdo->prepare("
            SELECT COUNT(*) FROM counselor_timeslots
            WHERE counselor_user_id = ? AND slot_date = ?
              AND id != ?
              AND start_time < ? AND end_time > ?
        ");
        $overlapStmt->execute(array((int)$counselorUserId, $date, (int)$id, $endTime, $startTime));
        if ((int)$overlapStmt->fetchColumn() > 0) {
            return array('success' => false, 'error' => 'This timeslot overlaps with an existing slot.');
        }

        $stmt = $pdo->prepare("
            UPDATE counselor_timeslots
            SET start_time = ?, end_time = ?, slot_date = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ? AND counselor_user_id = ?
        ");
        $stmt->execute(array($startTime, $endTime, $date, (int)$id, (int)$counselorUserId));
        return array('success' => $stmt->rowCount() > 0, 'error' => null);
    }

    /**
     * Delete a timeslot. Blocked if already booked.
     *
     * @return array array('success'=>bool, 'error'=>string|null)
     */
    public function delete($id, $counselorUserId)
    {
        $pdo = Database::getConnection();
        $check = $pdo->prepare("
            SELECT id, is_booked, is_frozen FROM counselor_timeslots
            WHERE id = ? AND counselor_user_id = ?
        ");
        $check->execute(array((int)$id, (int)$counselorUserId));
        $row = $check->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return array('success' => false, 'error' => 'Timeslot not found.');
        }
        if ($row['is_booked'] || $row['is_frozen']) {
            return array('success' => false, 'error' => 'Cannot delete a booked or frozen timeslot. The appointment must be cancelled first.');
        }

        $stmt = $pdo->prepare("DELETE FROM counselor_timeslots WHERE id = ? AND counselor_user_id = ?");
        $stmt->execute(array((int)$id, (int)$counselorUserId));
        return array('success' => $stmt->rowCount() > 0, 'error' => null);
    }

    /**
     * Mark a timeslot as booked (called when an appointment is accepted).
     * Sets both is_booked and is_frozen to 1.
     */
    public function markBooked($counselorUserId, $date, $startTime)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE counselor_timeslots
            SET is_booked = 1, is_frozen = 1, updated_at = CURRENT_TIMESTAMP
            WHERE counselor_user_id = ? AND slot_date = ? AND start_time = ?
        ");
        $stmt->execute(array((int)$counselorUserId, $date, $startTime));
        return $stmt->rowCount() > 0;
    }

    /**
     * Mark a timeslot as frozen (called when an appointment is created).
     * Sets is_frozen = 1, is_booked remains 0.
     */
    public function markFrozen($counselorUserId, $date, $startTime)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE counselor_timeslots
            SET is_frozen = 1, updated_at = CURRENT_TIMESTAMP
            WHERE counselor_user_id = ? AND slot_date = ? AND start_time = ?
        ");
        $stmt->execute(array((int)$counselorUserId, $date, $startTime));
        return $stmt->rowCount() > 0;
    }

    /**
     * Mark a timeslot as free again (called when an appointment is cancelled/rejected).
     * Resets both is_booked and is_frozen to 0.
     */
    public function markFree($counselorUserId, $date, $startTime)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE counselor_timeslots
            SET is_booked = 0, is_frozen = 0, updated_at = CURRENT_TIMESTAMP
            WHERE counselor_user_id = ? AND slot_date = ? AND start_time = ?
        ");
        $stmt->execute(array((int)$counselorUserId, $date, $startTime));
        return $stmt->rowCount() > 0;
    }

    /**
     * Get all timeslots for a counselor+date for the undergrad booking form.
     * Returns start_time, end_time, is_booked for each slot.
     */
    public function getForBooking($counselorUserId, $date)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT
                id,
                TIME_FORMAT(start_time, '%H:%i') AS start_time,
                TIME_FORMAT(end_time,   '%H:%i') AS end_time,
                TIME_FORMAT(start_time, '%H:%i:%s') AS start_time_full,
                slot_type,
                is_booked,
                is_frozen
            FROM counselor_timeslots
            WHERE counselor_user_id = ? AND slot_date = ?
            ORDER BY start_time ASC
        ");
        $stmt->execute(array((int)$counselorUserId, $date));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if a specific start_time is a valid, unbooked slot for a counselor+date.
     */
    public function isValidSlot($counselorUserId, $date, $startTime)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT id, is_booked, is_frozen, end_time
            FROM counselor_timeslots
            WHERE counselor_user_id = ? AND slot_date = ?
              AND start_time = ?
        ");
        $stmt->execute(array((int)$counselorUserId, $date, $startTime));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
