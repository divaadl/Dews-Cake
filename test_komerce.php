<?php
    $url = 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost';
    $curl = curl_init();
    $payload = json_encode([
      'origin' => 444,
      'destination' => 114,
      'weight' => 1000,
      'couriers' => 'jne',
    ]);
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer HAH5ngo41f7d502cf47f7dd4fIo9CE6S',
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    echo "HTTP CODE: " . $httpcode . "\n";
    echo "RESPONSE:\n" . $response . "\n\n";
