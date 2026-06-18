<?php
require_once 'db.php';

// Try uppercase and lowercase environment variables commonly used in Railway
$nasaApiKey = getenv('NASA_API_KEY') ?: getenv('nasa');
if (!$nasaApiKey) {
    die("Error: NASA API key not found in environment variables.");
}
$url = "https://api.nasa.gov/planetary/apod?api_key={$nasaApiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $data = json_decode($response, true);
    
    if (isset($data['date'])) {
        $title = $data['title'] ?? '';
        $imgUrl = $data['url'] ?? '';
        $explanation = $data['explanation'] ?? '';
        $date = $data['date'];
        $media_type = $data['media_type'] ?? '';

        try {
            // Insert or update using Supabase REST API Upsert
            supabase_request("nasa_data", "POST", [
                'title' => $title,
                'url' => $imgUrl,
                'explanation' => $explanation,
                'date' => $date,
                'media_type' => $media_type
            ], ['Prefer: resolution=merge-duplicates']);

            echo "NASA Data synced successfully for date: " . $date;

        } catch (Exception $e) {
            echo "Error inserting NASA data: " . $e->getMessage();
        }
    } else {
        echo "Error: NASA API response did not contain 'date' field.";
    }
} else {
    echo "Error fetching from NASA API.";
}
?>
