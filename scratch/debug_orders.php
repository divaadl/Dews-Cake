<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pesanan;
use Carbon\Carbon;

$expiredTime = now()->subHours(24);
echo "Current Time: " . now() . "\n";
echo "Expired Time Threshold: " . $expiredTime . "\n\n";

$orders = Pesanan::with('pembayaran')
    ->where('status_pesanan', 'menunggu_pembayaran')
    ->get();

echo "Found " . $orders->count() . " orders with 'menunggu_pembayaran' status.\n";

foreach ($orders as $o) {
    echo "Order #{$o->pesanan_id}:\n";
    echo "  - Created At: {$o->tanggal_pesan}\n";
    echo "  - Older than 24h? " . ($o->tanggal_pesan < $expiredTime ? "YES" : "NO") . "\n";
    echo "  - Payment Methods: " . $o->pembayaran->pluck('metode_pembayaran')->implode(', ') . "\n";
    
    $hasCash = $o->pembayaran->contains(fn($p) => $p->metode_pembayaran === 'cash');
    echo "  - Has Cash Payment? " . ($hasCash ? "YES (Will be EXCLUDED by current logic)" : "NO") . "\n";
}
