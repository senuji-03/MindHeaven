<?php

class DonationControl {
    
    public function index() {
        view('donation/index');
    }
    
    public function submit() {
        // Handle donation form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $message = $_POST['message'] ?? '';
            
            // Here you would typically save to database
            // For now, we'll just redirect with success message
            
            header("Location: " . BASE_URL . "/donation?success=1");
            exit;
        }
    }
}
