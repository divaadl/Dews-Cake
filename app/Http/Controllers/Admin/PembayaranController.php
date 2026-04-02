<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('pesanan.user');
 
        // 1 SEARCH (Payment ID, Order ID, Customer)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                // Search by Payment ID
                $payId = str_replace('PAY-', '', strtoupper($search));
                if (is_numeric($payId)) {
                    $q->where('pembayaran_id', (int)$payId);
                }
 
                // Search by Order ID
                $orderId = str_replace('ORD-', '', strtoupper($search));
                if (is_numeric($orderId)) {
                    $q->orWhere('pesanan_id', (int)$orderId);
                }
 
                // Search by Customer Name
                $q->orWhereHas('pesanan.user', function($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                });
            });
        }
 
        // 2 FILTER METODE
        if ($request->filled('method')) {
            $query->where('metode_pembayaran', $request->input('method'));
        }
 
        // 3 FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->input('status'));
        }
 
        // 4 FILTER TANGGAL
        if ($request->filled('date')) {
            $query->whereDate('tanggal_bayar', $request->input('date'));
        }
 
        $pembayaran = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
 
        // Calculate Stats (Total success remains unfiltered for general context, or can be filtered if preferred - usually context stats are total)
        $totalSuccess = Pembayaran::where('status_pembayaran', 'berhasil')->sum('jumlah_bayar');
        $pendingCount = Pembayaran::where('status_pembayaran', 'menunggu')->count();
 
        return view('admin.pembayaran.index', compact('pembayaran', 'totalSuccess', 'pendingCount'));
    }
}
