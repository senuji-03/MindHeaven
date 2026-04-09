<?php

require_once BASE_PATH . '/app/models/Timeslot.php';

class TimeslotControl
{
    private $timeslotModel;

    public function __construct()
    {
        $this->timeslotModel = new Timeslot();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ─── Auth helper ──────────────────────────────────────────────────────────

    private function requireCounselor()
    {
        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'counselor') {
            $this->json(['error' => 'Unauthorized'], 401);
        }
        return (int)$_SESSION['user_id'];
    }

    // ─── Public: slots for undergrad booking form ─────────────────────────────

    /**
     * GET /api/timeslots?counselor_id=X&date=YYYY-MM-DD
     * Returns all counselor-defined slots for that date, marking booked ones.
     */
    public function getForBooking()
    {
        $counselorId = (int)($_GET['counselor_id'] ?? 0);
        $date        = trim($_GET['date'] ?? '');

        if (!$counselorId || !$date) {
            return $this->json(['error' => 'counselor_id and date are required'], 400);
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->json(['error' => 'Invalid date format'], 400);
        }

        $slots = $this->timeslotModel->getForBooking($counselorId, $date);
        $this->json(['slots' => $slots]);
    }

    // ─── Counselor: view own slots ────────────────────────────────────────────

    /**
     * GET /api/counselor/timeslots?date=YYYY-MM-DD
     */
    public function getCounselorSlots()
    {
        $userId = $this->requireCounselor();
        $date   = trim($_GET['date'] ?? '');

        if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->json(['error' => 'A valid date is required'], 400);
        }

        $slots = $this->timeslotModel->getByDate($userId, $date);

        // Also return the 4 fixed slot definitions so the UI knows which are selected
        $fixed    = Timeslot::fixedSlots();
        $savedFixed = array_filter($slots, fn($s) => $s['slot_type'] === 'fixed');
        $savedFixedStarts = array_map(fn($s) => $s['start_time'], $savedFixed);

        $fixedWithState = array_map(function($f) use ($savedFixedStarts) {
            return [
                'start'    => $f['start'],
                'end'      => $f['end'],
                'label'    => $f['label'],
                'selected' => in_array($f['start'], $savedFixedStarts),
            ];
        }, $fixed);

        $this->json([
            'slots'       => $slots,
            'fixed_defs'  => $fixedWithState,
            'total_count' => count($slots),
            'max'         => 6,
        ]);
    }

    // ─── Counselor: save fixed slots ──────────────────────────────────────────

    /**
     * POST /api/counselor/timeslots/save-fixed
     * Body: { date: "YYYY-MM-DD", selected: ["17:00:00","19:00:00"] }
     */
    public function saveFixed()
    {
        $userId = $this->requireCounselor();
        $data   = $this->getJsonInput();

        $date      = trim($data['date'] ?? '');
        $selected  = $data['selected'] ?? [];

        if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->json(['error' => 'A valid date is required'], 400);
        }
        if (!is_array($selected)) {
            return $this->json(['error' => 'selected must be an array'], 400);
        }

        // Check we won't exceed 6 total after this
        // Count existing custom + booked fixed slots
        $existingSlots = $this->timeslotModel->getByDate($userId, $date);
        $bookedFixed   = array_filter($existingSlots, fn($s) => $s['slot_type'] === 'fixed' && $s['is_booked']);
        $customCount   = count(array_filter($existingSlots, fn($s) => $s['slot_type'] === 'custom'));
        $bookedCount   = count($bookedFixed);
        $freeSlots     = 6 - $customCount - $bookedCount;

        if (count($selected) > $freeSlots) {
            return $this->json([
                'error' => "You can select at most {$freeSlots} fixed slot(s) for this day (6 total max, accounting for existing custom / booked slots)."
            ], 400);
        }

        $result = $this->timeslotModel->saveFixed($userId, $date, $selected);
        if ($result['error']) {
            return $this->json(['error' => $result['error']], 500);
        }

        $this->json([
            'message' => "Saved {$result['saved']} fixed slot(s)." . ($result['skipped'] ? " {$result['skipped']} skipped (limit reached)." : ''),
            'saved'   => $result['saved'],
        ]);
    }

    // ─── Counselor: create custom slot ────────────────────────────────────────

    /**
     * POST /api/counselor/timeslots/create-custom
     * Body: { date: "YYYY-MM-DD", start_time: "HH:MM", end_time: "HH:MM" }
     */
    public function createCustom()
    {
        $userId = $this->requireCounselor();
        $data   = $this->getJsonInput();

        $date      = trim($data['date'] ?? '');
        $startTime = trim($data['start_time'] ?? '');
        $endTime   = trim($data['end_time'] ?? '');

        if (!$date || !$startTime || !$endTime) {
            return $this->json(['error' => 'date, start_time, and end_time are required'], 400);
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $this->json(['error' => 'Invalid date format'], 400);
        }
        // Normalise to HH:MM:SS
        $startTime = $this->normaliseTime($startTime);
        $endTime   = $this->normaliseTime($endTime);
        if (!$startTime || !$endTime) {
            return $this->json(['error' => 'Invalid time format. Use HH:MM or HH:MM:SS'], 400);
        }

        $result = $this->timeslotModel->createCustom($userId, $date, $startTime, $endTime);
        if ($result['error']) {
            return $this->json(['error' => $result['error']], 400);
        }

        $this->json(['message' => 'Custom timeslot created.', 'id' => $result['id']], 201);
    }

    // ─── Counselor: update custom slot ────────────────────────────────────────

    /**
     * PUT /api/counselor/timeslots/update
     * Body: { id: N, date: "YYYY-MM-DD", start_time: "HH:MM", end_time: "HH:MM" }
     */
    public function updateCustom()
    {
        $userId = $this->requireCounselor();
        $data   = $this->getJsonInput();

        $id        = (int)($data['id'] ?? 0);
        $date      = trim($data['date'] ?? '');
        $startTime = trim($data['start_time'] ?? '');
        $endTime   = trim($data['end_time'] ?? '');

        if (!$id || !$date || !$startTime || !$endTime) {
            return $this->json(['error' => 'id, date, start_time, and end_time are required'], 400);
        }
        $startTime = $this->normaliseTime($startTime);
        $endTime   = $this->normaliseTime($endTime);
        if (!$startTime || !$endTime) {
            return $this->json(['error' => 'Invalid time format.'], 400);
        }

        $result = $this->timeslotModel->updateCustom($id, $userId, $date, $startTime, $endTime);
        if ($result['error']) {
            return $this->json(['error' => $result['error']], 400);
        }
        if (!$result['success']) {
            return $this->json(['error' => 'Timeslot not found or no changes made'], 404);
        }

        $this->json(['message' => 'Timeslot updated.']);
    }

    // ─── Counselor: delete slot ───────────────────────────────────────────────

    /**
     * DELETE /api/counselor/timeslots/delete
     * Body: { id: N }
     */
    public function deleteSlot()
    {
        $userId = $this->requireCounselor();
        $data   = $this->getJsonInput();

        $id = (int)($data['id'] ?? 0);
        if (!$id) {
            return $this->json(['error' => 'Timeslot ID is required'], 400);
        }

        $result = $this->timeslotModel->delete($id, $userId);
        if ($result['error']) {
            return $this->json(['error' => $result['error']], 409);
        }
        if (!$result['success']) {
            return $this->json(['error' => 'Timeslot not found'], 404);
        }

        $this->json(['message' => 'Timeslot deleted.']);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Normalise "HH:MM" or "HH:MM:SS" to "HH:MM:SS".
     */
    private function normaliseTime($t)
    {
        $t = trim($t);
        if (preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $t)) {
            return $t . ':00';
        }
        if (preg_match('/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', $t)) {
            return $t;
        }
        return false;
    }

    private function json($data, int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function getJsonInput(): array
    {
        $raw  = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
}
