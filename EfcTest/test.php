<?php

$url = 'https://postman-echo.com/get';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

echo "<pre>";

$result = json_decode(curl_exec($ch), 1);
echo json_encode($result, JSON_PRETTY_PRINT);
curl_close($ch);

echo "</pre>";
?>