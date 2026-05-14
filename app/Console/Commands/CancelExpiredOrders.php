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
        $hMinus2 = $now->copy()->addDays(2);
        
        Log::info('--- Pencadangan Otomatis Pesanan Kadaluarsa ---');
        Log::info('Waktu Sistem Saat Ini: ' . $now);
        Log::info('Zona Waktu: ' . config('app.timezone'));
        Log::info('Batas Waktu Pembayaran Awal (24 jam): ' . $expiredTime);
        Log::info('Batas Waktu Pelunasan (H-2 Pengambilan): ' . $hMinus2);

        // 1. Pesanan yang belum bayar DP/Lunas sama sekali dalam 24 jam
        $unpaidOrders = \App\Models\Pesanan::where('status_pesanan', 'menunggu_pembayaran')
            ->where('tanggal_pesan', '<', $expiredTime)
            ->whereDoesntHave('pembayaran', function ($query) {
                $query->where('metode_pembayaran', 'cash');
            })
            ->get();

        // 2. Pesanan DP yang belum lunas H-2 sebelum pengambilan
        $unpaidDpOrders = \App\Models\Pesanan::where('status_pesanan', 'dp_dibayar')
            ->where('tanggal_pengambilan', '<=', $hMinus2)
            ->get();

        $expiredOrders = $unpaidOrders->merge($unpaidDpOrders);
        $count = $expiredOrders->count();
        $successCount = 0;
        $failCount = 0;

        if ($count > 0) {
            Log::info("Ditemukan {$count} pesanan yang berpotensi kadaluarsa.");
            
            foreach ($expiredOrders as $order) {
                $reason = $order->status_pesanan == 'menunggu_pembayaran' ? 'Pembayaran awal > 24 jam' : 'Pelunasan DP > H-2 Pengambilan';
                Log::info("Memproses Pesanan #{$order->pesanan_id} [{$reason}] (Dibuat: {$order->tanggal_pesan}, Ambil: {$order->tanggal_pengambilan})");
                
                try {
                    \DB::transaction(function () use ($order) {
                        $order->update([
                            'status_pesanan' => 'batal'
                        ]);

                        // Juga update status pembayaran yang masih 'menunggu' jika ada
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
