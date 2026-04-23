<?php
// Firebase REST API key (add yours from the Firebase Console)
define('FirebaseApiKey', '');

// Base URL for Firebase Authentication REST API
define('FirebaseBaseURL', 'https://identitytoolkit.googleapis.com/v1/accounts:');

// Function to send a request to the Firebase Authentication REST API
function firebaseRequest($endpoint, $data)
{
    $url = FirebaseBaseURL . $endpoint . '?key=' . FirebaseApiKey;

    $request = curl_init($url);

    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($request, CURLOPT_POST, true);
    curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);

    $raw_response = json_decode(curl_exec($request), true);

    // Return null if Firebase returns an error code at the top level
    if (isset($raw_response['code'])) {
        $response = $raw_response['code'];
    } else {
        $response = $raw_response;
        return $response;
    }
}
?>
