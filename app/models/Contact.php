<?php

class Contact
{
    private $db;

    public function __construct()
    {
        require_once __DIR__ . '/../../core/Database.php';
        $this->db = Database::getConnection();
    }

    /**
     * Create a new contact message entry
     */
    public function create($data)
    {
        $sql = "INSERT INTO contact_messages (first_name, last_name, email, phone, subject, message, is_urgent, reference_id) 
                VALUES (:first_name, :last_name, :email, :phone, :subject, :message, :is_urgent, :reference_id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array(
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':phone' => isset($data['phone']) ? $data['phone'] : null,
            ':subject' => $data['subject'],
            ':message' => $data['message'],
            ':is_urgent' => isset($data['is_urgent']) ? $data['is_urgent'] : 0,
            ':reference_id' => $data['reference_id']
        ));
    }
}
