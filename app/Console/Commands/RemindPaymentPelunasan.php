<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemindPaymentPelunasan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:remind-pelunasan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim pengingat WhatsApp H-1 sebelum batas pelunasan (H-3 sebelum pengambilan)';

    protected $fonnteService;

    public function __construct(\App\Services\FonnteService $fonnteService)
    {
        parent::__construct();
        $this->fonnteService = $fonnteService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('--- Menjalankan Task: Pengingat Pelunasan (10:30) ---');
        
        // H-1 sebelum deadline H-2 = H-3 sebelum pengambilan
        $targetDate = now()->addDays(3)->format('Y-m-d');
        \Log::info("Target tanggal pengambilan: {$targetDate}");
        
        $orders = \App\Models\Pesanan::with('user')
            ->where('status_pesanan', 'dp_dibayar')
            ->whereDate('tanggal_pengambilan', $targetDate)
            ->get();

        $count = $orders->count();
        \Log::info("Ditemukan {$count} pesanan yang belum lunas untuk diingatkan.");

        foreach ($orders as $order) {
            $orderIdFormatted = '#ORD-' . str_pad($order->pesanan_id, 5, '0', STR_PAD_LEFT);
            $tglAmbil = \Carbon\Carbon::parse($order->tanggal_pengambilan)->format('d/m/Y');
            $tglDeadline = \Carbon\Carbon::parse($order->tanggal_pengambilan)->subDays(2)->format('d/m/Y');
            
            $message = "*Pengingat Pelunasan Pesanan* 🍰\n\n" .
                       "Halo *{$order->user->name}*,\n\n" .
                       "Ini adalah pengingat untuk pesanan Anda *{$orderIdFormatted}*.\n\n" .
                       "*Detail Jadwal:*\n" .
                       "📅 Tgl Pengambilan: *{$tglAmbil}*\n" .
                       "⏳ Batas Pelunasan (H-2): *Besok ({$tglDeadline})*\n\n" .
                       "Mohon segera lakukan pelunasan agar pesanan dapat kami proses tepat waktu. Jika tidak dilunasi hingga besok, pesanan akan dibatalkan otomatis dan DP hangus sesuai ketentuan.\n\n" .
                       "Silakan cek menu *Pesanan Saya* di website untuk melakukan pelunasan online.\n\n" .
                       "Terika kasih! 🙏\n_Dews Cake_";

            $response = $this->fonnteService->sendMessage($order->phone_pesanan, $message);
            
            if ($response['status']) {
                \Log::info("Berhasil mengirim pengingat ke {$order->phone_pesanan} untuk pesanan {$orderIdFormatted}");
                $this->info("Sent reminder for {$orderIdFormatted}");
            } else {
                \Log::error("Gagal mengirim pengingat ke {$order->phone_pesanan}: " . ($response['reason'] ?? 'Unknown Error'));
            }
        }

        \Log::info("Selesai menjalankan task pengingat pelunasan.");
        $this->info("Selesai mengirim {$count} pengingat.");
    }
}
