<?php

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array(
    "key: HAH5ngo41f7d502cf47f7dd4fIo9CE6S"
  ),
));

$response = curl_exec($curl);
echo "KEY: HAH5ngo41f7d502cf47f7dd4fIo9CE6S\n";
echo "HTTP: " . curl_getinfo($curl, CURLINFO_HTTP_CODE) . "\n";
echo "RESPONSE: " . substr($response, 0, 300) . "\n";

curl_close($curl);
