<?php
class AdminControl {
    public function index() {
        // This will load the main admin dashboard
        view('Admin/index');
    }

    public function manageUsers() {
        view('admin/manage-users');
    }

    public function resourceHub() {
        view('admin/resource-hub');
    }
}