<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\FonnteService;

class PaymentCallbackController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }
    public function receive(Request $request)
    {
        Log::info('Midtrans Webhook Received', ['payload' => $request->all()]);

        try {
            // 1. Dapatkan JSON yang dikirim oleh Midtrans
            $payload = $request->getContent();
            $notification = json_decode($payload);

            if (!$notification) {
                Log::warning('Midtrans Webhook: Invalid payload received');
                return response()->json(['message' => 'Invalid payload'], 400);
            }

            $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

            if ($notification->signature_key !== $validSignatureKey) {
                Log::error('Midtrans Webhook: Invalid signature', [
                    'received' => $notification->signature_key,
                    'expected' => $validSignatureKey
                ]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;

            // Ekstrak pembayaran_id (Format PAY-12-1241243)
            $parts = explode('-', $orderId);
            if(count($parts) < 2) {
                Log::error('Midtrans Webhook: Invalid order_id format: ' . $orderId);
                return response()->json(['message' => 'Invalid order id formatting'], 400);
            }
            
            $pembayaranId = $parts[1];
            $pembayaran = Pembayaran::find($pembayaranId);

            if (!$pembayaran) {
                Log::error('Midtrans Webhook: Pembayaran tidak ditemukan untuk ID: ' . $pembayaranId);
                return response()->json(['message' => 'Payment record not found'], 404);
            }

            $pesanan = Pesanan::find($pembayaran->pesanan_id);

            if (!$pesanan) {
                Log::error('Midtrans Webhook: Pesanan tidak ditemukan untuk Pembayaran ID: ' . $pembayaranId);
                return response()->json(['message' => 'Order record not found'], 404);
            }

            Log::info("Memproses Status Midtrans: {$transactionStatus} untuk Pesanan #{$pesanan->pesanan_id}");

            // 2. Logic Update Status berdasarkan kembalian Midtrans
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                
                \DB::transaction(function () use ($pembayaran, $pesanan, $notification) {
                    $pembayaran->update([
                        'status_pembayaran' => 'berhasil',
                        'metode_pembayaran' => $notification->payment_type ?? $pembayaran->metode_pembayaran,
                        'tanggal_bayar' => now(),
                    ]);

                    if ($pembayaran->jenis_pembayaran == 'dp') {
                        $pesanan->update(['status_pesanan' => 'dp_dibayar']);
                        $msg = "*Pembayaran DP Berhasil!* ✅\n\nHalo {$pesanan->user->name}, pembayaran DP untuk pesanan #ORD-" . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) . " telah kami terima.\n\nStatus pesanan Anda sekarang sedang kami proses. Terima kasih!";
                    } else {
                        $pesanan->update(['status_pesanan' => 'lunas']);
                        $msg = "*Pembayaran Lunas!* ✅\n\nHalo {$pesanan->user->name}, pembayaran untuk pesanan #ORD-" . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) . " telah kami terima dan berstatus LUNAS.\n\nStatus pesanan Anda sekarang sedang kami proses. Terima kasih!";
                    }

                    $this->fonnteService->sendMessage($pesanan->phone_pesanan, $msg);
                    Log::info("Pesanan #{$pesanan->pesanan_id} berhasil diperbarui (Lunas/DP).");
                });

            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                
                \DB::transaction(function () use ($pembayaran, $pesanan, $transactionStatus) {
                    // Update status pembayaran menjadi batal
                    $pembayaran->update(['status_pembayaran' => 'batal']);
                    
                    // Update status pesanan menjadi batal
                    $pesanan->update(['status_pesanan' => 'batal']);
                    
                    Log::info("Pesanan #{$pesanan->pesanan_id} dibatalkan otomatis karena status: {$transactionStatus}");
                });
                
            } else if ($transactionStatus == 'pending') {
                $pembayaran->update(['status_pembayaran' => 'menunggu']);
                Log::info("Pesanan #{$pesanan->pesanan_id} menunggu pembayaran.");
            }

            return response()->json(['message' => 'Payment status updated successfully']);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
