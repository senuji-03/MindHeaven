<?php

class CrisisIntervention
{
    /**
     * Save intervention notes for a crisis call.
     */
    public function save($callId, $counselorId, $notes)
    {
        $pdo = Database::getConnection();

        // Check if notes already exist for this call-counselor pair
        $stmt = $pdo->prepare("SELECT id FROM crisis_intervention_notes WHERE crisis_call_id = ? AND counselor_user_id = ?");
        $stmt->execute(array((int) $callId, (int) $counselorId));
        $existing = $stmt->fetch();

        if ($existing) {
            $stmt = $pdo->prepare("UPDATE crisis_intervention_notes SET notes = ?, created_at = CURRENT_TIMESTAMP WHERE id = ?");
            return $stmt->execute(array($notes, (int) $existing['id']));
        } else {
            $stmt = $pdo->prepare("INSERT INTO crisis_intervention_notes (crisis_call_id, counselor_user_id, notes) VALUES (?, ?, ?)");
            return $stmt->execute(array((int) $callId, (int) $counselorId, $notes));
        }
    }

    /**
     * Get intervention notes by crisis call ID.
     */
    public function getByCallId($callId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT n.*, COALESCE(c.full_name, u.full_name, u.username) as counselor_name 
            FROM crisis_intervention_notes n
            LEFT JOIN users u ON n.counselor_user_id = u.id
            LEFT JOIN counselors c ON n.counselor_user_id = c.user_id
            WHERE n.crisis_call_id = ?
            ORDER BY n.created_at DESC
        ");
        $stmt->execute(array((int) $callId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
