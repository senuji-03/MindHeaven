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
}
