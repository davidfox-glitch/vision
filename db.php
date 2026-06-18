<?php
define('SUPABASE_URL', 'https://tafbhuqkfgvvfrlqowek.supabase.co');
define('SUPABASE_ANON_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InRhZmJodXFrZmd2dmZybHFvd2VrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODE3MDI2MTcsImV4cCI6MjA5NzI3ODYxN30.QVR8FJ9HqpxkAydOdw1a5PagcIuCkiRmjwLzp3Ap63U');

function supabase_request($endpoint, $method = 'GET', $data = null, $headers = []) {
    $url = SUPABASE_URL . '/rest/v1/' . ltrim($endpoint, '/');
    $ch = curl_init($url);

    $defaultHeaders = [
        'apikey: ' . SUPABASE_ANON_KEY,
        'Authorization: Bearer ' . SUPABASE_ANON_KEY,
        'Content-Type: application/json'
    ];
    
    $mergedHeaders = array_merge($defaultHeaders, $headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $mergedHeaders);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

    if ($data !== null && in_array(strtoupper($method), ['POST', 'PATCH', 'PUT'])) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        throw new Exception("cURL Error: " . $error);
    }

    if ($httpCode >= 400) {
        throw new Exception("Supabase Error HTTP $httpCode: $response");
    }

    return json_decode($response, true);
}
?>
