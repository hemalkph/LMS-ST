<?php
/**
 * Session Helper Functions
 * Provides safe session management across the application
 */

/**
 * Safely start a session if one is not already active
 * This prevents the "session already started" error
 */
function safe_session_start() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Check if user is logged in
 * @return bool
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user data from session (avoids PHP core get_current_user())
 * @return array
 */
if (!function_exists('app_current_user')) {
    function app_current_user() {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'name' => $_SESSION['user_name'] ?? 'User',
            'email' => $_SESSION['user_email'] ?? '',
            'first_name' => $_SESSION['user_first_name'] ?? '',
            'last_name' => $_SESSION['user_last_name'] ?? '',
            'mobile' => $_SESSION['user_mobile'] ?? '',
            'address' => $_SESSION['user_address'] ?? ''
        ];
    }
}

/**
 * Require user to be logged in, redirect to login if not
 */
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}
?>






