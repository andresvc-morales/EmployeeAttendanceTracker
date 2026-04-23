<?php
// Dashboard page for authenticated employees to register attendance and view today's status.

session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['employee_id'])) {
    header("Location: /EmployeeAttendanceTracker/resources/views/login.php");
    exit();
}

require_once '../config/database.php';
require_once '../actions/dbattendance.php';

$employee_id = $_SESSION['employee_id'];
$employee_name = $_SESSION['employee_name'] ?? 'Employee';

// Read flash message set after an attendance registration
$message = $_SESSION['attendance_message'] ?? '';
$msg_success = $_SESSION['attendance_success'] ?? null;
unset($_SESSION['attendance_message'], $_SESSION['attendance_success']);

// Handle direct POST (form submits to this page)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = registerAttendance($employee_id);
    $message = $result['message'];
    $msg_success = $result['success'];
}

date_default_timezone_set("America/Costa_Rica");
$today = date("Y-m-d");

// Fetch today's attendance record for this employee
$stmt = $conn->prepare("SELECT entry_time, exit_time FROM assistance_records WHERE employee_id = ? AND date = ?");
$stmt->bind_param("is", $employee_id, $today);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();

$hasEntry = $record && $record['entry_time'] !== null;
$hasExit = $record && $record['exit_time'] !== null;

// Determine daily status label and color
if ($hasExit) {
    $statusLabel = "Attendance complete";
    $statusColor = "#059669"; // green
} elseif ($hasEntry) {
    $statusLabel = "Exit pending";
    $statusColor = "#d97706"; // amber
} else {
    $statusLabel = "No entry registered yet";
    $statusColor = "#6b7280"; // gray
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/EmployeeAttendanceTracker/resources/assets/css/dashboard.css">
    <style>
        #status_label {
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            margin: 0;
        }

        #message.success {
            color: #059669;
        }
    </style>
</head>

<body>
    <div id="dashboard_card">
        <h2>Welcome, <?= htmlspecialchars($employee_name) ?></h2>
        <p class="date"><?= date("l, F j Y") ?></p>

        <!-- Today's recorded times -->
        <div class="row">
            <span>Entry</span>
            <strong><?= $hasEntry ? htmlspecialchars($record['entry_time']) : '—' ?></strong>
        </div>
        <div class="row">
            <span>Exit</span>
            <strong><?= $hasExit ? htmlspecialchars($record['exit_time']) : '—' ?></strong>
        </div>

        <!-- Daily status indicator -->
        <p id="status_label" style="color: <?= $statusColor ?>;"><?= $statusLabel ?></p>

        <!-- Action button: changes label based on current state -->
        <form method="POST" action="/EmployeeAttendanceTracker/resources/views/dashboard.php">
            <button type="submit" <?= $hasExit ? 'disabled' : '' ?>>
                <?= $hasExit ? 'Completed' : ($hasEntry ? 'Mark Exit' : 'Mark Entry') ?>
            </button>
        </form>

        <!-- Result message from last action -->
        <p id="message" class="<?= $msg_success ? 'success' : '' ?>">
            <?= htmlspecialchars($message) ?>
        </p>

        <!-- Navigation -->
        <a href="/EmployeeAttendanceTracker/resources/views/history.php">View My History</a>
        <a href="/EmployeeAttendanceTracker/resources/views/logout.php">Logout</a>
    </div>
</body>

</html>