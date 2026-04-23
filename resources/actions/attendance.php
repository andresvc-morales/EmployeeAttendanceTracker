<?php
// Handle attendance registration for authenticated employees.

session_start();

// Only allow authenticated employees
if (!isset($_SESSION['employee_id'])) {
    header("Location: /EmployeeAttendanceTracker/resources/views/login.php");
    exit();
}

require_once __DIR__ . '/../actions/dbattendance.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_SESSION['employee_id'];
    $result = registerAttendance($employee_id);
    $_SESSION['attendance_message'] = $result['message'];
    $_SESSION['attendance_success'] = $result['success'];
}

header("Location: /EmployeeAttendanceTracker/resources/views/dashboard.php");
exit();
?>
