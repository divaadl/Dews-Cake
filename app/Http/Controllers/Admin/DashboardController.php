<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $stats = [
            'total'     => Pesanan::count(),
            'waiting'   => Pesanan::where('status_pesanan', 'menunggu_pembayaran')->count(),
            'processing'=> Pesanan::where('status_pesanan', 'diproses')->count(),
            'completed' => Pesanan::where('status_pesanan', 'selesai')->count(),
        ];

        // 2. 3 Pesanan Terbaru
        $recentOrders = Pesanan::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // 3. Pembayaran Terbaru (Menampilkan pembayaran yang baru masuk berstatus 'berhasil')
        $recentPayments = Pembayaran::with(['pesanan.user'])
            ->where('status_pembayaran', 'berhasil')
            ->orderBy('tanggal_bayar', 'desc')
            ->limit(5)
            ->get();

        // 4. Pengiriman Hari Ini
        $todayShipments = Pengiriman::with(['pesanan.user'])
            ->whereDate('tanggal_kirim', Carbon::today())
            ->get();

        // 5. Grafik Pendapatan & Jumlah Pesanan Bulanan (6 bulan terakhir)
        $monthlyStats = DB::table('pembayaran')
            ->select(
                DB::raw('MONTHNAME(tanggal_bayar) as month'),
                DB::raw('MONTH(tanggal_bayar) as month_num'),
                DB::raw('SUM(CASE WHEN status_pembayaran = "berhasil" THEN jumlah_bayar ELSE 0 END) as revenue'),
                DB::raw('COUNT(DISTINCT pesanan_id) as order_count')
            )
            ->where('tanggal_bayar', '>=', now()->subMonths(6))
            ->groupBy('month', 'month_num')
            ->orderBy('month_num', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'recentPayments',
            'todayShipments',
            'monthlyStats'
        ));
    }
}
