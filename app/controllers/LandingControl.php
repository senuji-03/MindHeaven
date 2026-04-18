<?php

class LandingControl
{
    public function index()
    {
        $counselorModel = new Counselor();
        $counselors = $counselorModel->getApproved(8);

        // Fetch bulk data for display
        $counselorIds = array();
        $counselorUserIds = array();
        foreach ($counselors as $c) {
            $counselorIds[] = (int) $c['id'];
            $counselorUserIds[] = (int) $c['user_id'];
        }
        
        $qualificationsMap = $counselorModel->getQualificationsBulk($counselorIds);
        
        require_once BASE_PATH . '/app/models/Appointment.php';
        $appointmentModel = new Appointment();
        $sessionCountsMap = $appointmentModel->getCompletedSessionsCountBulk($counselorUserIds);
        
        require_once BASE_PATH . '/app/models/Feedback.php';
        $feedbackModel = new Feedback();
        $avgRatingsMap = $feedbackModel->getAvgRatingsBulk($counselorIds);

        // Fetch platform/general feedbacks for the "Student Voices" section
        $platformFeedbacks = $feedbackModel->getPublicPlatformFeedbacks(6);

        foreach ($counselors as &$counselor) {
            $counselor['qualifications'] = isset($qualificationsMap[$counselor['id']]) ? $qualificationsMap[$counselor['id']] : array();
            $counselor['completed_sessions'] = $sessionCountsMap[$counselor['user_id']] ?? 0;
            $counselor['avg_rating'] = $avgRatingsMap[$counselor['id']] ?? 0.0;
        }
        unset($counselor); // Clean up reference

        $eventsByUniversity = [];

        try {
            $pdo = Database::getConnection();
            $sql = "SELECT e.*, u.name as university_name, u.email as university_email, u.phone as university_phone, u.website as university_website
                    FROM university_rep_events e 
                    JOIN university_representatives ur ON e.university_rep_id = ur.user_id 
                    JOIN universities u ON ur.university_id = u.id 
                    WHERE e.status = 'approved' 
                    ORDER BY u.name ASC, e.event_date DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($events as $event) {
                $uniName = $event['university_name'];
                if (!isset($eventsByUniversity[$uniName])) {
                    $eventsByUniversity[$uniName] = [];
                }
                $eventsByUniversity[$uniName][] = $event;
            }
        } catch (Exception $e) {
            error_log("Landing Page Events Error: " . $e->getMessage());
        }

        view('landing/index', [
            'counselors'         => $counselors,
            'eventsByUniversity' => $eventsByUniversity,
            'platformFeedbacks'  => $platformFeedbacks,
        ]);
    }
}