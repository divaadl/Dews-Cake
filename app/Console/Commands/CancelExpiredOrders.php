<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        Log::info('Memulai pengecekan pesanan kadaluarsa via Scheduler (fallback)...');

        $expiredTime = now()->subHours(24);

        $expiredOrders = \App\Models\Pesanan::where('status_pesanan', 'menunggu_pembayaran')
            ->where('tanggal_pesan', '<', $expiredTime)
            ->get();

        $count = $expiredOrders->count();
        $successCount = 0;
        $failCount = 0;

        if ($count > 0) {
            Log::info("Ditemukan {$count} pesanan kadaluarsa di sistem.");
            
            foreach ($expiredOrders as $order) {
                try {
                    \DB::transaction(function () use ($order) {
                        $order->update([
                            'status_pesanan' => 'batal'
                        ]);

                        // Juga update status pembayaran jika ada
                        \App\Models\Pembayaran::where('pesanan_id', $order->pesanan_id)
                            ->where('status_pembayaran', 'menunggu')
                            ->update([
                                'status_pembayaran' => 'batal'
                            ]);
                    });

                    Log::info("Berhasil membatalkan pesanan #{$order->pesanan_id} via Scheduler.");
                    $successCount++;
                } catch (\Exception $e) {
                    Log::error("Gagal membatalkan pesanan #{$order->pesanan_id}. Error: " . $e->getMessage());
                    $failCount++;
                }
            }

            Log::info("Selesai memproses pembatalan via Scheduler. Berhasil: {$successCount}, Gagal: {$failCount}.");
            $this->info("Berhasil membatalkan {$successCount} pesanan, {$failCount} gagal.");
        } else {
            Log::info('Tidak ada pesanan kadaluarsa yang ditemukan oleh Scheduler.');
            $this->info('Tidak ada pesanan kadaluarsa.');
        }
    }
}
