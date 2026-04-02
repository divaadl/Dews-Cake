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
        // 1. Dapatkan JSON yang dikirim oleh Midtrans
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($notification->signature_key !== $validSignatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id; // Format PAY-12-1241243

        // Ekstrak pembayaran_id
        $parts = explode('-', $orderId);
        if(count($parts) < 2) return response()->json(['message' => 'Invalid order id formatting'], 400);
        
        $pembayaranId = $parts[1];
        
        $pembayaran = Pembayaran::find($pembayaranId);

        if (!$pembayaran) {
            Log::error('Pembayaran tidak ditemukan untuk Order ID: ' . $orderId);
            return response()->json(['message' => 'Payment record not found'], 404);
        }

        $pesanan = Pesanan::find($pembayaran->pesanan_id);

        if (!$pesanan) {
            return response()->json(['message' => 'Order record not found'], 404);
        }

        // 2. Logic Update Status berdasarkan kembalian Midtrans
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            
            // Payment Berhasil
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

        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            
            // Payment Gagal/Kadaluarsa
            // Kita biarkan status menunggu_pembayaran / gagal, atau ubah logikanya jika perlu
            // $pesanan->update(['status_pesanan' => 'batal']);
            
        } else if ($transactionStatus == 'pending') {
            // Belum dibayar
            $pembayaran->update(['status_pembayaran' => 'menunggu']);
        }

        return response()->json(['message' => 'Payment status updated successfully']);
    }
}
