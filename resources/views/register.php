<?php
// Registration page for new employees to create an account using Firebase Authentication and store their details in MySQL

session_start();
require_once '../actions/authregister.php';
require_once '../actions/dbuser.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $name     = trim($_POST['name'] ?? '');

    // Keep values in session so the form can repopulate on error
    $_SESSION['old_email'] = $email;
    $_SESSION['old_name']  = $name;

    // Basic input validation
    if (empty($name)) {
        $_SESSION['message'] = 'Name is required.';
        $_SESSION['success'] = false;

    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = 'A valid email is required.';
        $_SESSION['success'] = false;

    } else {
        // Register the user in Firebase
        $result = firebaseSignUp($email, $password);

        if ($result['success']) {
            // Save the employee in MySQL linked by Firebase UID
            $firebase_uid = $result['data']['localId'];
            $dbResult = insertUser($name, $email, $firebase_uid);

            if ($dbResult['success']) {
                unset($_SESSION['old_email'], $_SESSION['old_name']);
                $_SESSION['message'] = "User registered successfully";
                $_SESSION['success'] = true;

                // Redirect to login after successful registration
                header("Location: /EmployeeAttendanceTracker/resources/views/login.php");
                exit;
            } else {
                $_SESSION['message'] = $dbResult['message'];
                $_SESSION['success'] = false;
            }

        } else {
            $_SESSION['message'] = $result['message'];
            $_SESSION['success'] = false;
        }
    }

    header('Location: /EmployeeAttendanceTracker/resources/views/register.php');
    exit;
}

// Read flash messages and repopulate values
$message   = $_SESSION['message'] ?? '';
$success   = $_SESSION['success'] ?? null;
$old_email = $_SESSION['old_email'] ?? '';
$old_name  = $_SESSION['old_name'] ?? '';

unset($_SESSION['message'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/EmployeeAttendanceTracker/resources/assets/css/loginandregister.css">
</head>

<body>
    <form id="register_form" method="POST" action="/EmployeeAttendanceTracker/resources/views/register.php">
        <h2>Register</h2>

        <label for="register_name">Name:</label>
        <input type="text" id="register_name" name="name"
            value="<?= htmlspecialchars($old_name) ?>" placeholder="Name" required>

        <label for="register_email">Email:</label>
        <input type="email" id="register_email" name="email"
            value="<?= htmlspecialchars($old_email) ?>" placeholder="Email" required>

        <label for="register_password">Password:</label>
        <input type="password" id="register_password" name="password" placeholder="Password" required>

        <button type="submit">Register</button>

        <div id="auth_link">Already have an account?
            <a href="/EmployeeAttendanceTracker/resources/views/login.php">Login here</a>
        </div>

        <!-- Feedback message (error or success) -->
        <p id="message"><?php echo htmlspecialchars($message); ?></p>
    </form>
</body>

</html>
