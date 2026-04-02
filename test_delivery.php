<?php
$curl = curl_init();

$url = 'https://api.collaborator.komerce.id/tariff/api/v1/calculate?origin=175&destination=153&weight=1000&courier=jne&is_international=0';

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'key: HAH5ngo41f7d502cf47f7dd4fIo9CE6S',
        'Authorization: Bearer HAH5ngo41f7d502cf47f7dd4fIo9CE6S', // providing both just in case
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

echo "HTTP CODE: " . $httpcode . "\n";
echo "RESPONSE:\n" . $response . "\n";
