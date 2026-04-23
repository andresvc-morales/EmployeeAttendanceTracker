<?php
// Handle database operations related to employee records and attendance

require_once '../config/database.php';

// Function to insert a new user into the employees table after successful Firebase registration
function insertUser($name, $email, $firebase_uid)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO employees (name, email, firebase_uid) VALUES (?, ?, ?)");

    if (!$stmt) {
        return ['success' => false, 'message' => "Prepare failed: " . $conn->error];
    }

    $stmt->bind_param("sss", $name, $email, $firebase_uid);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => "User saved in database"];
    } else {
        return ['success' => false, 'message' => "Execute failed: " . $stmt->error];
    }
}

// Function to retrieve user information based on Firebase UID
function getUserByFirebaseUid($firebase_uid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT id, name FROM employees WHERE firebase_uid = ?");

    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("s", $firebase_uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}
?>
