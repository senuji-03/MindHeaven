<?php

class DonorControl{
    
    public function __construct() {
        // Session is already started in index.php, no need to start again
        // Protect all donor routes
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        
        // Add security headers to prevent caching and back-button access
        Auth::setSecurityHeaders();
    }
    
    public function DonationForm() {
        view('Donor/DonationForm');
    }
    public function DonationSuccess() {
        view('Donor/DonationSuccess');
    }
}