<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    Illuminate\Http\Request::create('/test', 'GET')
);

use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = env('MIDTRANS_SERVER_KEY');
Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
Config::$isSanitized = true;
Config::$is3ds = true;

$params = array(
    'transaction_details' => array(
        'order_id' => 'PAY-TEST-' . time(),
        'gross_amount' => 10000,
    ),
    'customer_details' => array(
        'first_name' => 'Test',
        'email' => 'test@example.com',
        'phone' => '08123456789',
    ),
);

try {
    $snapToken = Snap::getSnapToken($params);
    echo "Snap Token: " . $snapToken . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
