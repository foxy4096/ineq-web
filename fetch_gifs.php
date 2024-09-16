<?php
include "_secrets.php";

header('Content-Type: application/json');

$api_key = $TENOR_API_KEY;
$query = isset($_GET['query']) ? $_GET['query'] : '';
$limit = 10;

$api_url = "https://tenor.googleapis.com/v2/search?q=" . urlencode($query) . "&key=" . $api_key . "&limit=" . $limit;

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
    curl_close($ch);
    exit();
}

// Check HTTP response code
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($http_code != 200) {
    echo json_encode(['error' => 'API request failed with status code ' . $http_code]);
    curl_close($ch);
    exit();
}

curl_close($ch);

echo $response;
