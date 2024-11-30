<?php
// Start session only if it's not already started.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in.
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
?>

