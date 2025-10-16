<?php

class COControl {
    public function index() {
        // Redirect to dashboard when accessing /counselor
        header('Location: ' . BASE_URL . '/counselor/dashboard');
        exit;
    }
    
    public function dashboard() {
        view('/counselor/Cdashboard');
    }
    public function appointmentmgt() {
        view('/counselor/appointmentmgt');
    }
    public function calender() {
        view('/counselor/calender');
    }
    public function sessionHistory() {
        view('/counselor/sessionHistory');
    }
}