<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengiriman::query();
 
        // 1 SEARCH (Order ID, Penerima, No HP)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                // Search by Order ID
                $orderId = str_replace('ORD-', '', strtoupper($search));
                if (is_numeric($orderId)) {
                    $q->where('pesanan_id', (int)$orderId);
                }
 
                // Search by Name
                $q->orWhere('nama_penerima', 'like', "%{$search}%");
 
                // Search by Phone
                $q->orWhere('phone_penerima', 'like', "%{$search}%");
            });
        }
 
        // 2 FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status_pengiriman', $request->input('status'));
        }
 
        // 3 FILTER KURIR
        if ($request->filled('kurir')) {
            $query->where('kurir', 'like', "%" . $request->input('kurir') . "%");
        }
 
        // 4 FILTER TANGGAL
        if ($request->filled('date')) {
            $query->whereDate('tanggal_kirim', $request->input('date'));
        }
 
        $pengiriman = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        
        // Stats (unfiltered for context)
        $totalSedingDikirim = Pengiriman::where('status_pengiriman', 'sedang_dikirim')->count();
        $totalTerkirim = Pengiriman::where('status_pengiriman', 'terkirim')->count();
 
        return view('admin.pengiriman.index', compact('pengiriman', 'totalSedingDikirim', 'totalTerkirim'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update([
            'status_pengiriman' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function updateInfo(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update([
            'kurir' => $request->kurir,
            'tanggal_kirim' => $request->tanggal_kirim,
        ]);

        return redirect()->back()->with('success', 'Detail pengiriman berhasil diperbarui.');
    }
}
