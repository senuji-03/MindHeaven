<?php

class CallResponderControl{
    
    public function __construct() {
        // Session is already started in index.php, no need to start again
        // Protect all call responder routes
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'call_responder') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        
        // Add security headers to prevent caching and back-button access
        Auth::setSecurityHeaders();
    }
    
    public function index() {
        view('crisis/call_dashboard');
    }

    public function dashboard() {
        view('crisis/call_dashboard');
    }

    public function success() {
        view('CallResponder/CallSuccess');
    }
}