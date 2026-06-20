<?php
define('SUPABASE_URL', 'https://tafbhuqkfgvvfrlqowek.supabase.co');
define('SUPABASE_PUBLISHABLE_KEY', 'sb_publishable_nvAb-we6S0nx0_fSEkUIig_NxDH9chP');
define('SUPABASE_ANON_KEY', SUPABASE_PUBLISHABLE_KEY);

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

function supabase_auth_error_message($message) {
    $jsonStart = strpos($message, '{');
    if ($jsonStart !== false) {
        $decoded = json_decode(substr($message, $jsonStart), true);
        if (is_array($decoded)) {
            return $decoded['msg'] ?? $decoded['message'] ?? $message;
        }
    }

    return $message;
}

function normalize_email($email) {
    return strtolower(trim($email));
}

function app_url($path = '') {
    $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
    $scheme = (!empty($forwardedProto))
        ? explode(',', $forwardedProto)[0]
        : ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http');
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $path = ltrim($path, '/');

    return $scheme . '://' . $host . ($basePath ? $basePath . '/' : '/') . $path;
}
?>
