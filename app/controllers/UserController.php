<?php
require_once 'models/User.php';
require_once 'views/userView.php';

class UserController {
    public function show() {
        // Example user (in real app, you'd get this from DB)
        $user = new User("Anuja Vidanage", "anuja@example.com");
        renderUser($user);
    }
}
?>
