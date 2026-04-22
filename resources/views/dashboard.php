<?php
session_start();
require_once '../config/database.php';
require_once '../actions/dbattendance.php';

if (!isset($_SESSION['employee_id'])) {
    header("Location: /EmployeeAttendanceTracker/resources/views/login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];
$employee_name = $_SESSION['employee_name'] ?? 'Employee';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = registerAttendance($employee_id);
    $message = $result['message'];
}

date_default_timezone_set("America/Costa_Rica");
$today = date("Y-m-d");

$stmt = $conn->prepare("SELECT entry_time, exit_time FROM assistance_records WHERE employee_id = ? AND date = ?");
$stmt->bind_param("is", $employee_id, $today);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();

$hasEntry = $record && $record['entry_time'] !== null;
$hasExit = $record && $record['exit_time'] !== null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/EmployeeAttendanceTracker/resources/assets/css/dashboard.css">
</head>

<body>
    <div id="dashboard_card">
        <h2>Welcome, <?= htmlspecialchars($employee_name) ?></h2>
        <p class="date"><?= date("l, F j Y") ?></p>

        <div class="row">
            <span>Entry</span>
            <strong><?= $hasEntry ? $record['entry_time'] : '—' ?></strong>
        </div>
        <div class="row">
            <span>Exit</span>
            <strong><?= $hasExit ? $record['exit_time'] : '—' ?></strong>
        </div>

        <form method="POST">
            <button type="submit" <?= $hasExit ? 'disabled' : '' ?>>
                <?= $hasExit ? 'Completed' : ($hasEntry ? 'Mark Exit' : 'Mark Entry') ?>
            </button>
        </form>

        <p id="message"><?= htmlspecialchars($message) ?></p>
        <a href="/EmployeeAttendanceTracker/resources/views/history.php">View History</a>
        <a href="/EmployeeAttendanceTracker/resources/views/logout.php">Logout</a>
    </div>
</body>

</html>