<?php
// Handle user registration through Firebase Authentication

require(__DIR__ . "/../config/firebase.php");

// Function to handle Firebase sign-up
function firebaseSignUp($email, $password)
{
    try {
        // Send sign-up request to Firebase
        $result = firebaseRequest('signUp', [
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

        if ($error_message === "EMAIL_EXISTS") {
            $message = "This email is already registered";
        } elseif ($error_message === "INVALID_EMAIL") {
            $message = "The email address is badly formatted.";
        } elseif (str_contains($error_message, "WEAK_PASSWORD")) {
            $message = "The password is too weak";
        } elseif ($error_message === "MISSING_PASSWORD") {
            $message = "The password is required.";
        } else {
            $message = "An unknown error occurred: " . $error_message;
        }

        return [
            'success' => false,
            'message' => $message
        ];
    }

    // Sign-up successful
    return [
        'success' => true,
        'message' => "User registered successfully.",
        'data' => $result
    ];
}
?>
