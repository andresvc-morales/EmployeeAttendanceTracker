<?php
// Database connection settings
$servername = "localhost";
$username = ""; // Add your username
$password = ""; // Add your password
$dbname = "employee_attendance";

// Open MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Stop execution if connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
