<?php

class Auth {
    
    public static function check() {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']);
    }
    
    public static function user() {
        if (self::check()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'role' => $_SESSION['role']
            ];
        }
        return null;
    }
    
    public static function requireAuth() {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
    
    public static function requireRole($requiredRole) {
        self::requireAuth();
        
        if ($_SESSION['role'] !== $requiredRole) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
    
    public static function hasRole($role) {
        return self::check() && $_SESSION['role'] === $role;
    }
    
    public static function isAdmin() {
        return self::hasRole('admin');
    }
    
    public static function isCounselor() {
        return self::hasRole('counselor');
    }
    
    public static function isUndergrad() {
        return self::hasRole('undergrad');
    }
    
    public static function isModerator() {
        return self::hasRole('moderator');
    }
    
    public static function isCallResponder() {
        return self::hasRole('call_responder');
    }
    
    public static function isDonor() {
        return self::hasRole('donor');
    }
}
