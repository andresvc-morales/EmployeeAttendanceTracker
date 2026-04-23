<?php
// Database connection settings
$servername = "localhost";
$username = "Van"; // Add your username
$password = "vanilla_coke7"; // Add your password
$dbname = "employee_attendance";

// Open MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Stop execution if connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>