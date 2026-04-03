<?php

require_once BASE_PATH . '/app/models/Counselor.php';

class LandingControl {
    
    public function index() {
        $counselorModel = new Counselor();
        $counselors = $counselorModel->getApproved(8); // Show up to 8 approved counselors
        view('landing/index', ['counselors' => $counselors]);
    }
}
