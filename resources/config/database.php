<?php
$servername = "localhost";
$username = ""; // Add you username
$password = ""; // Add your password
$dbname = "employee_attendance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}
?>