<?php

class Event {
    private $db;
    
    public function __construct() {
        try {
            $this->db = Database::getConnection();
        } catch (Exception $e) {
            // Handle database connection issues gracefully
            $this->db = null;
        }
    }
    
    /**
     * Get all events for a specific counselor
     */
    public function getEventsByCounselor($counselorId) {
        if (!$this->db) {
            return [];
        }
        $sql = "SELECT * FROM events WHERE counselor_id = :counselor_id ORDER BY event_date, event_time";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':counselor_id', $counselorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Get events for a specific date
     */
    public function getEventsByDate($counselorId, $date) {
        if (!$this->db) {
            return [];
        }
        $sql = "SELECT * FROM events WHERE counselor_id = :counselor_id AND event_date = :event_date ORDER BY event_time";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':counselor_id', $counselorId, PDO::PARAM_INT);
        $stmt->bindParam(':event_date', $date, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Get a single event by ID
     */
    public function getEventById($eventId) {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * Create a new event
     */
    public function createEvent($data) {
        if (!$this->db) {
            error_log("Event model: Database connection is null");
            return false;
        }
        
        $sql = "INSERT INTO events (counselor_id, title, event_date, event_time, priority, description, created_at) 
                VALUES (:counselor_id, :title, :event_date, :event_time, :priority, :description, NOW())";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':counselor_id', $data['counselor_id'], PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':event_date', $data['event_date'], PDO::PARAM_STR);
        $stmt->bindParam(':event_time', $data['event_time'], PDO::PARAM_STR);
        $stmt->bindParam(':priority', $data['priority'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        
        error_log("Event model: Attempting to create event with data: " . print_r($data, true));
        
        if ($stmt->execute()) {
            $eventId = $this->db->lastInsertId();
            error_log("Event model: Event created successfully with ID: " . $eventId);
            return $eventId;
        } else {
            error_log("Event model: Failed to execute query. Error: " . print_r($stmt->errorInfo(), true));
            return false;
        }
    }
    
    /**
     * Update an existing event
     */
    public function updateEvent($eventId, $data) {
        $sql = "UPDATE events SET 
                title = :title, 
                event_date = :event_date, 
                event_time = :event_time, 
                priority = :priority, 
                description = :description,
                updated_at = NOW()
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':event_date', $data['event_date'], PDO::PARAM_STR);
        $stmt->bindParam(':event_time', $data['event_time'], PDO::PARAM_STR);
        $stmt->bindParam(':priority', $data['priority'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    /**
     * Delete an event
     */
    public function deleteEvent($eventId) {
        $sql = "DELETE FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    /**
     * Get today's events for a counselor
     */
    public function getTodaysEvents($counselorId) {
        $today = date('Y-m-d');
        return $this->getEventsByDate($counselorId, $today);
    }
    
    /**
     * Get events for a specific month
     */
    public function getEventsByMonth($counselorId, $year, $month) {
        if (!$this->db) {
            error_log("Event model: Database connection is null");
            return [];
        }
        
        $sql = "SELECT * FROM events 
                WHERE counselor_id = :counselor_id 
                AND YEAR(event_date) = :year 
                AND MONTH(event_date) = :month 
                ORDER BY event_date, event_time";
        
        error_log("Event model: Executing query - Counselor ID: $counselorId, Year: $year, Month: $month");
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':counselor_id', $counselorId, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        error_log("Event model: Query returned " . count($results) . " events");
        
        return $results;
    }
    
    /**
     * Get all events (for debugging)
     */
    public function getAllEvents() {
        if (!$this->db) {
            error_log("Event model: Database connection is null");
            return [];
        }
        
        $sql = "SELECT * FROM events ORDER BY event_date, event_time";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        error_log("Event model: getAllEvents returned " . count($results) . " events");
        
        return $results;
    }
    
    /**
     * Check if event time conflicts with existing events
     */
    public function checkTimeConflict($counselorId, $eventDate, $eventTime, $excludeEventId = null) {
        if (!$this->db) {
            error_log("Event model: Database connection is null in checkTimeConflict");
            return false;
        }
        
        $sql = "SELECT COUNT(*) as conflict_count FROM events 
                WHERE counselor_id = :counselor_id 
                AND event_date = :event_date 
                AND event_time = :event_time";
        
        if ($excludeEventId) {
            $sql .= " AND id != :exclude_id";
        }
        
        error_log("Event model: Checking time conflict for counselor_id: $counselorId, date: $eventDate, time: $eventTime, exclude: $excludeEventId");
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':counselor_id', $counselorId, PDO::PARAM_INT);
        $stmt->bindParam(':event_date', $eventDate, PDO::PARAM_STR);
        $stmt->bindParam(':event_time', $eventTime, PDO::PARAM_STR);
        
        if ($excludeEventId) {
            $stmt->bindParam(':exclude_id', $excludeEventId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $hasConflict = $result->conflict_count > 0;
        
        error_log("Event model: Time conflict check result: " . ($hasConflict ? 'CONFLICT FOUND' : 'NO CONFLICT') . " (count: {$result->conflict_count})");
        
        return $hasConflict;
    }
}
