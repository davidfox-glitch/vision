<?php
define('SUPABASE_URL', 'https://tafbhuqkfgvvfrlqowek.supabase.co');
define('SUPABASE_ANON_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InRhZmJodXFrZmd2dmZybHFvd2VrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODE3MDI2MTcsImV4cCI6MjA5NzI3ODYxN30.QVR8FJ9HqpxkAydOdw1a5PagcIuCkiRmjwLzp3Ap63U');

define('AUTH_FALLBACK_FILE', __DIR__ . '/data/users.json');

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

function supabase_auth_request($endpoint, $method = 'POST', $data = null, $headers = []) {
    $url = SUPABASE_URL . '/auth/v1/' . ltrim($endpoint, '/');
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
        throw new Exception("Supabase Auth Error HTTP $httpCode: $response");
    }

    return json_decode($response, true);
}

function is_missing_table_error($message) {
    return stripos($message, 'PGRST205') !== false || stripos($message, 'Could not find the table') !== false;
}

function normalize_email($email) {
    return strtolower(trim($email));
}

function load_auth_users() {
    if (!file_exists(AUTH_FALLBACK_FILE)) {
        return [];
    }

    $contents = file_get_contents(AUTH_FALLBACK_FILE);
    if ($contents === false || trim($contents) === '') {
        return [];
    }

    $data = json_decode($contents, true);
    return is_array($data) ? $data : [];
}

function save_auth_users($users) {
    if (!is_dir(dirname(AUTH_FALLBACK_FILE))) {
        mkdir(dirname(AUTH_FALLBACK_FILE), 0777, true);
    }

    file_put_contents(
        AUTH_FALLBACK_FILE,
        json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );
}
?>
