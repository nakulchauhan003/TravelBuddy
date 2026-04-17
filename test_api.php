<?php
function loadEnvFile($envPath)
{
    if (!file_exists($envPath) || !is_readable($envPath)) {
        return;
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }

        $equalPos = strpos($line, '=');
        if ($equalPos === false) {
            continue;
        }

        $name = trim(substr($line, 0, $equalPos));
        $value = trim(substr($line, $equalPos + 1));

        if ($name === '') {
            continue;
        }

        $value = trim($value, "\"'");

        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
        putenv($name . '=' . $value);
    }
}

loadEnvFile(__DIR__ . DIRECTORY_SEPARATOR . '.env');

$apiKey = getenv('GEMINI_API_KEY') ?: getenv('GEMINI_API_KEY_OLD');
if (!$apiKey) {
    die("Missing GEMINI_API_KEY in .env\n");
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

$data = array(
    "contents" => array(
        array(
            "parts" => array(
                array("text" => "Test: Say OK if you are working")
            )
        )
    )
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_POST, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status Code: " . $httpCode . "\n";
echo "Response:\n";
echo $response . "\n";

if ($httpCode === 200) {
    $decoded = json_decode($response, true);
    if (isset($decoded['candidates'])) {
        echo "\n✓ API Key is VALID and working!\n";
    }
} else {
    echo "\n✗ API Key test failed with HTTP code: " . $httpCode . "\n";
}
?>
