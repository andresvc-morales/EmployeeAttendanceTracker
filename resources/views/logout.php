<?php
// Logout script to end the user's session and redirect to the login page

session_start();
session_destroy(); // Clear all session data

header("Location: /EmployeeAttendanceTracker/resources/views/login.php");
exit();
?>