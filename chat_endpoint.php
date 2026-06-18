<?php
header('Content-Type: application/json');

// Get the API key from environment variables (checking both common formats)
$geminiApiKey = getenv('GEMINI_API_KEY') ?: getenv('gemini');

if (!$geminiApiKey) {
    echo json_encode(['error' => 'Gemini API key not found in environment variables.']);
    exit;
}

// Get the POST data sent from the client
$inputData = json_decode(file_get_contents('php://input'), true);

if (!$inputData) {
    echo json_encode(['error' => 'No input data provided.']);
    exit;
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$geminiApiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($inputData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code($httpCode);
}

echo $response;
?>
