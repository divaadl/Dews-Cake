<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Services\FonnteService;

class PesananController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'paket', 'detail.produk', 'pembayaran']);
 
        // 1 SEARCH (ID, Nama, No HP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search by Order ID (remove prefix if present)
                $orderId = str_replace('ORD-', '', strtoupper($search));
                if (is_numeric($orderId)) {
                    $q->where('pesanan_id', (int)$orderId);
                }
 
                // Search by Phone
                $q->orWhere('phone_pesanan', 'like', "%{$search}%");
 
                // Search by Customer Name
                $q->orWhereHas('user', function($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                });
            });
        }
 
        // 2 FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }
 
        $pesanan = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString(); // Maintain search/filter params in links
 
        // Total stats (without filters for summary context)
        $activeOrdersCount = Pesanan::whereIn('status_pesanan', ['diproses', 'siap_diambil', 'siap_dikirim'])->count();
        $pendingPaymentCount = Pesanan::where('status_pesanan', 'menunggu_pembayaran')->count();
 
        return view('admin.pesanan.index', compact('pesanan', 'activeOrdersCount', 'pendingPaymentCount'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Cegah pengembalian status jika pesanan sudah masuk tahap pembayaran/proses
        $advancedStatuses = ['lunas', 'diproses', 'siap_diambil', 'siap_dikirim', 'selesai'];
        $reversalStatuses = ['menunggu_pembayaran', 'dp_dibayar'];

        if (in_array($pesanan->status_pesanan, $advancedStatuses) && in_array($request->status, $reversalStatuses)) {
            return redirect()->back()->with('error', 'Status pesanan yang sudah dibayar tidak dapat dikembalikan ke Menunggu Pembayaran.');
        }

        $pesanan->update([
            'status_pesanan' => $request->status
        ]);

        // Sinkronisasi data pembayaran jika status berubah menjadi Lunas
        if ($request->status === 'lunas') {
            $pembayaran = \App\Models\Pembayaran::where('pesanan_id', $id)
                ->where('status_pembayaran', 'menunggu')
                ->first();

            if ($pembayaran) {
                $pembayaran->update([
                    'status_pembayaran' => 'berhasil',
                    'tanggal_bayar' => now(),
                    'metode_pembayaran' => $pembayaran->metode_pembayaran ?: 'cash'
                ]);
            }

            $msg = "*Pembayaran Diterima!* ✅\n\nHalo {$pesanan->user->name}, pembayaran untuk pesanan #ORD-" . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) . " telah dikonfirmasi oleh Admin dan berstatus LUNAS.\n\nStatus pesanan Anda sekarang sedang kami proses. Terima kasih!";
            $this->fonnteService->sendMessage($pesanan->phone_pesanan, $msg);
        }

        // Otomatis buat data pengiriman jika status berubah menjadi Siap Dikirim
        if ($request->status === 'siap_dikirim') {
            $exists = \App\Models\Pengiriman::where('pesanan_id', $id)->exists();
            if (!$exists) {
                \App\Models\Pengiriman::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'nama_penerima' => $pesanan->user->name ?? 'Customer',
                    'phone_penerima' => $pesanan->phone_pesanan,
                    'alamat_pengiriman' => $pesanan->alamat_pesanan,
                    'kurir' => $pesanan->kurir,
                    'ongkir' => $pesanan->ongkir ?? 0,
                    'status_pengiriman' => 'sedang_dikirim',
                    'tanggal_kirim' => now(),
                ]);
            }

            $msg = "*Pesanan Siap Dikirim!* 🚚\n\nHalo {$pesanan->user->name}, kabar baik! Pesanan #ORD-" . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) . " Anda sudah siap dan sedang dalam proses pengiriman oleh kurir.\n\nMohon tunggu ya! 🍰\n\n_Pesan otomatis dari Dews Cake_";
            $this->fonnteService->sendMessage($pesanan->phone_pesanan, $msg);
        }

        // Jika status diubah kembali ke Siap Diambil, hapus data pengiriman jika ada
        if ($request->status === 'siap_diambil') {
            \App\Models\Pengiriman::where('pesanan_id', $id)->delete();

            $msg = "*Pesanan Siap Diambil!* 🧁\n\nHalo {$pesanan->user->name}, kabar baik! Pesanan #ORD-" . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) . " Anda sudah siap dan bisa diambil di toko kami.\n\nKami tunggu kehadirannya! 😊\n\n_Pesan otomatis dari Dews Cake_";
            $this->fonnteService->sendMessage($pesanan->phone_pesanan, $msg);
        }

        if ($request->status === 'batal') {
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back();
    }
}
