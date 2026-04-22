<?php
define('FirebaseApiKey', ''); // add your API key here
define('FirebaseBaseURL', 'https://identitytoolkit.googleapis.com/v1/accounts:');

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
  if (isset($raw_response['code'])) {
    $response = $raw_response['code'];
  } else {
    $response = $raw_response;
    return $response;
  }
}
?>