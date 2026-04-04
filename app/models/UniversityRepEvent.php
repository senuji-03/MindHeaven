<?php

require_once __DIR__ . '/../../core/Database.php';

class UniversityRepEvent
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function createEvent($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO university_rep_events (
                university_rep_id, event_title, event_type, description, short_description, target_amount, image_path,
                organized_by, open_for, event_date, start_time, end_time, venue, mode, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
        ");

        return $stmt->execute([
            $data['university_rep_id'],
            $data['event_title'],
            $data['event_type'] ?? 'other',
            $data['description'],
            $data['short_description'] ?? null,
            $data['target_amount'] ?? null,
            $data['image_path'] ?? null,
            $data['organized_by'] ?? 'University Representative',
            $data['open_for'] ?? 'specific_university',
            $data['event_date'],
            $data['start_time'] ?? '00:00:00',
            $data['end_time'] ?? '23:59:59',
            $data['venue'] ?? 'TBD',
            $data['mode'] ?? 'online'
        ]);
    }

    public function canManageEvent($eventId, $repUserId)
    {
        // Check if the event's university_rep_id belongs to the same university as the $repUserId
        $stmt = $this->pdo->prepare("
            SELECT e.university_rep_id, r1.university_id as event_univ, r2.university_id as user_univ
            FROM university_rep_events e
            JOIN university_representatives r1 ON e.university_rep_id = r1.user_id
            JOIN university_representatives r2 ON r2.user_id = ?
            WHERE e.id = ?
        ");
        $stmt->execute([$repUserId, $eventId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['event_univ'] === $result['user_univ']) {
            return true;
        }
        return false;
    }

    public function getEventsByUniversity($universityId)
    {
        $stmt = $this->pdo->prepare("
            SELECT e.* 
            FROM university_rep_events e
            JOIN university_representatives r ON e.university_rep_id = r.user_id
            WHERE r.university_id = ?
            ORDER BY e.created_at DESC
        ");
        $stmt->execute([$universityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($eventId, $status, $repUserId)
    {
        if (!$this->canManageEvent($eventId, $repUserId)) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE university_rep_events SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $eventId]);
    }
}
