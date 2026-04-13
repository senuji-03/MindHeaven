<?php

class CallResponderControl {

    public function index() {
        // Session already started by index.php
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['call_responder', 'admin'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require BASE_PATH . '/app/views/CallResponder/CallPage.php';
    }

}