<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis membatalkan pesanan yang belum dibayar dalam 24 jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTime = now()->subHours(24);

        $expiredOrders = \App\Models\Pesanan::where('status_pesanan', 'menunggu_pembayaran')
            ->where('tanggal_pesan', '<', $expiredTime)
            ->get();

        $count = $expiredOrders->count();

        foreach ($expiredOrders as $order) {
            $order->update([
                'status_pesanan' => 'batal'
            ]);

            // Juga update status pembayaran jika ada
            \App\Models\Pembayaran::where('pesanan_id', $order->pesanan_id)
                ->where('status_pembayaran', 'menunggu')
                ->update([
                    'status_pembayaran' => 'batal'
                ]);
        }

        $this->info("Berhasil membatalkan {$count} pesanan yang kadaluarsa.");
    }
}
