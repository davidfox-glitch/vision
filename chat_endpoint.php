<?php
header('Content-Type: application/json');

$geminiApiKey = null;
foreach (['GEMINI_API_KEY', 'GOOGLE_API_KEY', 'gemini', 'Gemini_API_KEY'] as $key) {
    if (!empty($_ENV[$key])) {
        $geminiApiKey = $_ENV[$key];
        break;
    }
    if (!empty($_SERVER[$key])) {
        $geminiApiKey = $_SERVER[$key];
        break;
    }
    $envValue = getenv($key);
    if ($envValue !== false && $envValue !== '') {
        $geminiApiKey = $envValue;
        break;
    }
}

if (!$geminiApiKey) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Gemini API key is not configured on the server.',
        'details' => 'Set GEMINI_API_KEY (or GOOGLE_API_KEY) in your deployment environment.'
    ]);
    exit;
}

$geminiApiKey = trim($geminiApiKey);
if ($geminiApiKey === '') {
    http_response_code(500);
    echo json_encode([
        'error' => 'Gemini API key is empty.',
        'details' => 'The configured API key appears to be blank.'
    ]);
    exit;
}

$inputData = json_decode(file_get_contents('php://input'), true);
if (!$inputData) {
    http_response_code(400);
    echo json_encode([
        'error' => 'No input data provided.'
    ]);
    exit;
}

$query = http_build_query([
    'key' => $geminiApiKey
]);
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?' . $query;

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Generated Gemini API URL is invalid.',
        'details' => 'The configured API key may contain characters that break the URL.'
    ]);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($inputData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($response === false) {
    $response = json_encode([
        'error' => 'Failed to reach Gemini API.',
        'details' => curl_error($ch)
    ]);
    $httpCode = 500;
}
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code($httpCode);
}

echo $response;
?>
