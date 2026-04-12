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
        $now = now();
        $expiredTime = $now->copy()->subHours(24);
        
        Log::info('--- Pencadangan Otomatis Pesanan Kadaluarsa ---');
        Log::info('Waktu Sistem Saat Ini: ' . $now);
        Log::info('Zona Waktu: ' . config('app.timezone'));
        Log::info('Batas Waktu Kadaluarsa (24 jam yang lalu): ' . $expiredTime);

        $expiredOrders = \App\Models\Pesanan::where('status_pesanan', 'menunggu_pembayaran')
            ->where('tanggal_pesan', '<', $expiredTime)
            ->get();

        $count = $expiredOrders->count();
        $successCount = 0;
        $failCount = 0;

        if ($count > 0) {
            Log::info("Ditemukan {$count} pesanan yang berpotensi kadaluarsa.");
            
            foreach ($expiredOrders as $order) {
                Log::info("Memproses Pesanan #{$order->pesanan_id} (Dibuat: {$order->tanggal_pesan})");
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

                    Log::info("BERHASIL membatalkan pesanan #{$order->pesanan_id}.");
                    $successCount++;
                } catch (\Exception $e) {
                    Log::error("GAGAL membatalkan pesanan #{$order->pesanan_id}. Error: " . $e->getMessage());
                    $failCount++;
                }
            }

            Log::info("Ringkasan: Berhasil: {$successCount}, Gagal: {$failCount}.");
            $this->info("Berhasil membatalkan {$successCount} pesanan, {$failCount} gagal.");
        } else {
            Log::info('Tidak ditemukan pesanan yang kadaluarsa.');
            $this->info('Tidak ada pesanan kadaluarsa.');
        }
    }
}
