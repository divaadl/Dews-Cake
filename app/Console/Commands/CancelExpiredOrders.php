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
    public function handle(\App\Services\FonnteService $fonnteService)
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
        $unpaidOrders = \App\Models\Pesanan::with('user')->where('status_pesanan', 'menunggu_pembayaran')
            ->where('tanggal_pesan', '<', $expiredTime)
            ->whereDoesntHave('pembayaran', function ($query) {
                $query->where('metode_pembayaran', 'cash');
            })
            ->get();

        // 2. Pesanan DP yang belum lunas H-2 sebelum pengambilan
        $unpaidDpOrders = \App\Models\Pesanan::with('user')->where('status_pesanan', 'dp_dibayar')
            ->where('tanggal_pengambilan', '<=', $hMinus2)
            ->get();

        $expiredOrders = $unpaidOrders->merge($unpaidDpOrders);
        $count = $expiredOrders->count();
        $successCount = 0;
        $failCount = 0;

        if ($count > 0) {
            Log::info("Ditemukan {$count} pesanan yang berpotensi kadaluarsa.");
            
            foreach ($expiredOrders as $order) {
                $isDpIssue = $order->status_pesanan == 'dp_dibayar';
                $reasonText = $isDpIssue 
                    ? "Melewati batas waktu pelunasan (H-2 sebelum pengambilan)" 
                    : "Melewati batas waktu pembayaran awal (24 jam)";
                
                $reasonLog = $isDpIssue ? 'Pelunasan DP > H-2 Pengambilan' : 'Pembayaran awal > 24 jam';
                Log::info("Memproses Pesanan #{$order->pesanan_id} [{$reasonLog}] (Dibuat: {$order->tanggal_pesan}, Ambil: {$order->tanggal_pengambilan})");
                
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

                    // Kirim Notifikasi WhatsApp
                    $orderIdFormatted = '#ORD-' . str_pad($order->pesanan_id, 5, '0', STR_PAD_LEFT);
                    $waMessage = "*Pesanan Dibatalkan Otomatis* ❌\n\n" .
                                 "Halo *{$order->user->name}*,\n" .
                                 "Pesanan Anda *{$orderIdFormatted}* telah dibatalkan secara otomatis oleh sistem karena:\n" .
                                 "_{$reasonText}_\n\n";
                    
                    if ($isDpIssue) {
                        $waMessage .= "Sesuai ketentuan, DP yang telah dibayarkan tidak dapat dikembalikan (hangus). Terima kasih.\n";
                    } else {
                        $waMessage .= "Silakan lakukan pemesanan ulang jika Anda masih ingin memesan. Terima kasih.\n";
                    }
                    
                    $waMessage .= "\n_Dews Cake_";
                    $fonnteService->sendMessage($order->phone_pesanan, $waMessage);

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
