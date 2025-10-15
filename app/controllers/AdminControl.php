<?php
class AdminControl {
    public function index() {
        // This will load the main admin dashboard
        view('Admin/index');
    }

    public function manageUsers() {
        view('Admin/manage-users');
    }

    public function resourceHub() {
        view('Admin/resource-hub');
    }

    public function moderateForum() {
        view('Admin/moderate-forum');
    }

    public function counselors() {
        view('Admin/counselors');
    }

    public function appointments() {
        view('Admin/appointments');
    }

    public function approveCounselors() {
        view('Admin/approve-counselors');
    }

    public function reports() {
        view('Admin/reports');
    }

    public function donations() {
        view('Admin/donations');
    }

    public function awareness() {
        view('Admin/awareness');
    }

    public function monitoring() {
        view('Admin/monitoring');
    }

    public function settings() {
        view('Admin/settings');
    }

    public function profile() {
        view('Admin/profile');
    }
}