<?php
session_start();
session_destroy();
header("Location: /EmployeeAttendanceTracker/resources/views/login.php");
exit();
?>