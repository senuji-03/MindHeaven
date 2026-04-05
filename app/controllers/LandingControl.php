<?php

        $counselorModel = new Counselor();
        $counselors = $counselorModel->getApproved(8); // Show up to 8 approved counselors

        $eventsByUniversity = [];
        try {
            $pdo = Database::getConnection();
            $sql = "SELECT e.*, u.name as university_name 
                    FROM university_rep_events e 
                    JOIN university_representatives ur ON e.university_rep_id = ur.user_id 
                    JOIN universities u ON ur.university_id = u.id 
                    WHERE e.status = 'approved' 
                    ORDER BY u.name ASC, e.event_date DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Group by university
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

        view('landing/index', ['counselors' => $counselors, 'eventsByUniversity' => $eventsByUniversity]);
    }
}
