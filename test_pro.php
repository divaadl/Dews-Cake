<?php
$curl = curl_init();

$payload = http_build_query([
    'origin' => 444, // Using district 444 just in case
    'originType' => 'subdistrict',
    'destination' => 114,
    'destinationType' => 'subdistrict',
    'weight' => 1000,
    'courier' => 'jne' 
]);

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => array(
        'key: HAH5ngo41f7d502cf47f7dd4fIo9CE6S',
        'Content-Type: application/x-www-form-urlencoded'
    ),
));

$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

echo "HTTP CODE: " . $httpcode . "\n";
echo "RESPONSE:\n" . $response . "\n";
