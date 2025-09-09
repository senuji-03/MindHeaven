<?php

class ModeratorControl{
    public function edit() {
        view('Moderator/editPosts');
    }
    public function flagged() {
        view('Moderator/FlaggedUsers');
    }
    public function ModeratorDashboard() {
        view('Moderator/ModeratorDashboard');
    }
    public function warn() {
        view('Moderator/warnForm');
    }
}