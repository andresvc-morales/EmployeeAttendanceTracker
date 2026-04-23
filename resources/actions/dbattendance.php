<?php
// Handle attendance registration for authenticated employees.

require_once '../config/database.php';

// Function to register attendance (entry or exit) for an employee
function registerAttendance($employee_id)
{
    global $conn;

    date_default_timezone_set("America/Costa_Rica");

    $today       = date("Y-m-d");
    $currentTime = date("H:i:s");

    // Check if a record already exists for today
    $stmt = $conn->prepare("SELECT id, exit_time FROM assistance_records WHERE employee_id = ? AND date = ?");
    if (!$stmt) {
        return ['success' => false, 'message' => "Prepare failed: " . $conn->error];
    }
    $stmt->bind_param("is", $employee_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Record exists: try to register exit
        $row = $result->fetch_assoc();

        if ($row['exit_time'] !== null) {
            // Validation: exit already registered — prevent duplicate complete attendance
            return ['success' => false, 'message' => "Exit already registered today"];
        }

        // Register exit time and mark record as complete
        $stmt = $conn->prepare("
            UPDATE assistance_records
            SET exit_time = ?, entry_status = 'complete'
            WHERE id = ?
        ");
        if (!$stmt) {
            return ['success' => false, 'message' => "Prepare failed: " . $conn->error];
        }
        $stmt->bind_param("si", $currentTime, $row['id']);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => "Exit registered"];
        } else {
            return ['success' => false, 'message' => "Execute failed: " . $stmt->error];
        }

    } else {
        // No record today: register entry
        // Validation: a user cannot register exit without a prior entry (handled above by this else branch)
        $stmt = $conn->prepare("
            INSERT INTO assistance_records (employee_id, date, entry_time, entry_status)
            VALUES (?, ?, ?, 'incomplete')
        ");
        if (!$stmt) {
            return ['success' => false, 'message' => "Prepare failed: " . $conn->error];
        }
        $stmt->bind_param("iss", $employee_id, $today, $currentTime);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => "Entry registered"];
        } else {
            return ['success' => false, 'message' => "Execute failed: " . $stmt->error];
        }
    }
}
?>
