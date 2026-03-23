<?php
define('FirebaseApiKey','AIzaSyA13I09OPMLm-tMH9zMQgUFH2abe_rfLM8');
define('FirebaseBaseURL', 'https://identitytoolkit.googleapis.com/v1/accounts:');

function firebaseRequest($endpoint, $data){
  $url = FirebaseBaseURL . $endpoint . '?key=' . FirebaseApiKey;

  $request = curl_init($url);

  curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($request, CURLOPT_POST, true);  
  curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($data));  
  curl_setopt($request, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
  $response = json_decode(curl_exec($request), true);
  return $response;
  }
?>
