<?php
session_start();
require_once '../actions/authlogin.php';
require_once '../actions/dbuser.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $_SESSION['old_email'] = $email;

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = 'A valid email is required.';
        $_SESSION['success'] = false;

    } elseif (empty($password)) {
        $_SESSION['message'] = 'Password is required.';
        $_SESSION['success'] = false;

    } else {
        $result = firebaseSignIn($email, $password);

        $_SESSION['message'] = $result['message'];
        $_SESSION['success'] = $result['success'];

        if ($result['success']) {
            $firebase_uid = $result['data']['localId'];
            $user = getUserByFirebaseUid($firebase_uid);
            if ($user) {
                $_SESSION['employee_id'] = $user['id'];
                $_SESSION['employee_name'] = $user['name'];
            }
            unset($_SESSION['old_email']);
            header('Location: /EmployeeAttendanceTracker/resources/views/dashboard.php');
            exit;
        }
    }

    header('Location: /EmployeeAttendanceTracker/resources/views/login.php');
    exit;
}

$message = $_SESSION['message'] ?? '';
$success = $_SESSION['success'] ?? null;
$old_email = $_SESSION['old_email'] ?? '';

unset($_SESSION['message'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/EmployeeAttendanceTracker/resources/assets/css/loginandregister.css">
</head>

<body>
    <form id="register_form" method="POST" action="/EmployeeAttendanceTracker/resources/views/login.php">
        <h2>Login</h2>

        <label for="login_email">Email:</label>
        <input type="email" id="login_email" name="email" value="<?= htmlspecialchars($old_email) ?>"
            placeholder="Email" required>

        <label for="login_password">Password:</label>
        <input type="password" id="login_password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
        <div id="auth_link">Don't have an account? <a
                href="/EmployeeAttendanceTracker/resources/views/register.php">Register here</a></div>
        <p id="message"><?php echo htmlspecialchars($message); ?></p>


    </form>
</body>

</html>