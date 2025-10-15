<?php

class UGControl{

    public function __construct() {
        // Session is already started in index.php, no need to start again
        // Protect all undergrad routes
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'undergrad') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }
    public function index() {
        view('undergrad/home');
    }
    public function appointment() {
        view('undergrad/appointments');
    }
    public function contact() {
        view('undergrad/contact');
    }
    public function crisis() {
        view('undergrad/crisis');
    }
     public function mood() {
        view('undergrad/mood');
    }
     public function resources() {
        view('undergrad/resources');
    }
     public function habits() {
        view('undergrad/habits');
    }
    
    public function about() {
        view('undergrad/about');
    }
    
    public function forum() {
        view('undergrad/forum');
    }
    
    public function quiz() {
        view('undergrad/quiz');
    }
}