<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['employee_id'])) {
    header("Location: /EmployeeAttendanceTracker/resources/views/login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];
$employee_name = $_SESSION['employee_name'] ?? 'Employee';

$stmt = $conn->prepare("SELECT date, entry_time, exit_time FROM assistance_records WHERE employee_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$records = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Attendance History</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/EmployeeAttendanceTracker/resources/assets/css/history.css">
</head>

<body>
    <div id="history_container">
        <h2>Attendance History - <?= htmlspecialchars($employee_name) ?></h2>

        <?php if (count($records) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Entry Time</th>
                        <th>Exit Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?= htmlspecialchars($record['date']) ?></td>
                            <td><?= htmlspecialchars($record['entry_time'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($record['exit_time'] ?? '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No attendance records available.</p>
        <?php endif; ?>

        <a href="/EmployeeAttendanceTracker/resources/views/dashboard.php">Back to Dashboard</a>
    </div>
</body>

</html>