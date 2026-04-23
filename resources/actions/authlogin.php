<?php
// Handle authentication for employee login

require(__DIR__ . "/../config/firebase.php");

// Function to handle Firebase sign-in
function firebaseSignIn($email, $password)
{
    try {
        // Send sign-in request to Firebase
        $result = firebaseRequest('signInWithPassword', [
            'email' => $email,
            'password' => $password,
            'returnSecureToken' => true
        ]);
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error: " . $e->getMessage()
        ];
    }

    // Map Firebase error codes to user-friendly messages
    if (isset($result['error'])) {
        $error_message = $result['error']['message'];

        if ($error_message === "EMAIL_NOT_FOUND") {
            $message = "This email is not registered";
        } elseif ($error_message === "INVALID_PASSWORD") {
            $message = "Incorrect password";
        } elseif ($error_message === "INVALID_EMAIL") {
            $message = "The email address is badly formatted.";
        } elseif ($error_message === "MISSING_PASSWORD") {
            $message = "The password is required";
        } elseif (str_contains($error_message, "INVALID_LOGIN_CREDENTIALS")) {
            $message = "Invalid login credentials";
        } elseif (str_contains($error_message, "TOO_MANY_ATTEMPTS_TRY_LATER")) {
            $message = "Too many failed login attempts. Please try again later";
        } else {
            $message = "An unknown error occurred: " . $error_message;
        }

        return [
            'success' => false,
            'message' => $message
        ];
    }

    // Sign-in successful
    return [
        'success' => true,
        'message' => "Login successful",
        'data' => $result
    ];
}
?>
