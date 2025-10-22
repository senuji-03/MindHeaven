<?php

class Appointment {
    public function create(
        int $studentUserId,
        int $counselorUserId,
        string $title,
        string $type,
        string $date,
        string $time,
        ?string $notes
    ): int {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO appointments 
                (student_user_id, counselor_user_id, title, type, date, time, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $studentUserId,
            $counselorUserId,
            $title,
            $type,
            $date,
            $time,
            $notes
        ]);
        return (int)$pdo->lastInsertId();
    }

    public function update(
        int $id,
        string $title,
        string $type,
        string $date,
        string $time,
        ?string $notes
    ): bool {
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

    public function delete(int $id): bool {
        $pdo = Database::getConnection();
        error_log("Appointment model: Attempting to delete appointment with ID: " . $id);
        
        $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        
        $deleted = $stmt->rowCount() > 0;
        error_log("Appointment model: Delete result - " . ($deleted ? "SUCCESS" : "FAILED") . " (rows affected: " . $stmt->rowCount() . ")");
        
        return $deleted;
    }
}
