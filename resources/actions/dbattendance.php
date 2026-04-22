<?php
require_once '../config/database.php';

function registerAttendance($employee_id)
{
    global $conn;

    date_default_timezone_set("America/Costa_Rica");

    $today = date("Y-m-d");
    $currentTime = date("H:i:s");

    $stmt = $conn->prepare("SELECT id, exit_time FROM assistance_records WHERE employee_id = ? AND date = ?");
    if (!$stmt) {
        return [
            'success' => false,
            'message' => "Prepare failed: " . $conn->error
        ];
    }
    $stmt->bind_param("is", $employee_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['exit_time'] !== null) {
            return [
                'success' => false,
                'message' => "Exit already registered today"
            ];
        }

        $stmt = $conn->prepare("
            UPDATE assistance_records 
            SET exit_time = ?, entry_status = 'complete' 
            WHERE id = ?
        ");
        if (!$stmt) {
            return [
                'success' => false,
                'message' => "Prepare failed: " . $conn->error
            ];
        }

        $stmt->bind_param("si", $currentTime, $row['id']);

        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => "Exit registered"
            ];
        } else {
            return [
                'success' => false,
                'message' => "Execute failed: " . $stmt->error
            ];
        }

    } else {

        $stmt = $conn->prepare("
            INSERT INTO assistance_records (employee_id, date, entry_time, entry_status)
            VALUES (?, ?, ?, 'incomplete')
        ");
        if (!$stmt) {
            return [
                'success' => false,
                'message' => "Prepare failed: " . $conn->error
            ];
        }

        $stmt->bind_param("iss", $employee_id, $today, $currentTime);
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => "Entry registered"
            ];
        } else {
            return [
                'success' => false,
                'message' => "Execute failed: " . $stmt->error
            ];
        }
    }
}
?>