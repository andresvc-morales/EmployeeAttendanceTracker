<?php
    $servername = "localhost";
    $username = "Van"; // Add you username
    $password = "vanilla_coke7"; // Add your password
    $dbname = "employee_attendance"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn -> connect_error){
        die("connection failed: " . $conn-> connect_error); 
    }
    echo "Connection succesfully";

?>

