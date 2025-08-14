<?php
session_start();

// Clear remember me cookie if it exists
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/'); // Delete cookie
}

// Clear all session data
session_destroy();

// Start a new session to set success message
session_start();
$_SESSION['success_message'] = 'You have been successfully logged out.';

// Redirect to login page with success message
header('Location: login.php');
exit();
?>