<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $query = Pesanan::with(['user', 'paket', 'detail.produk', 'pembayaran' => function($q) {
                $q->where('status_pembayaran', 'berhasil');
            }])
            ->whereIn('status_pesanan', ['lunas', 'diproses', 'siap_dikirim', 'selesai', 'siap']) // Siap (dikirim) ditambahkan
            ->whereHas('pembayaran', function ($q) use ($startDate, $endDate) {
                $q->where('status_pembayaran', 'berhasil')
                  ->whereBetween('tanggal_bayar', [$startDate, $endDate]);
            });

        $pesanan = (clone $query)
            ->orderBy('tanggal_pesan', 'desc')
            ->paginate(10);

        // Sum of full total_harga for these orders
        $totalRevenue = (clone $query)->sum('total_harga');

        return view('admin.laporan.index', compact('pesanan', 'startDate', 'endDate', 'totalRevenue'));
    }

    public function export(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $pesananList = Pesanan::with(['user', 'paket', 'detail.produk', 'pembayaran' => function($q) {
                $q->where('status_pembayaran', 'berhasil');
            }])
            ->whereIn('status_pesanan', ['lunas', 'diproses', 'siap_dikirim', 'selesai', 'siap'])
            ->whereHas('pembayaran', function ($q) use ($startDate, $endDate) {
                $q->where('status_pembayaran', 'berhasil')
                  ->whereBetween('tanggal_bayar', [$startDate, $endDate]);
            })
            ->orderBy('tanggal_pesan', 'desc')
            ->get();

        $fileName = 'Laporan_Penjualan_' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID Pembayaran', 
            'ID Pesanan', 
            'Tanggal Pesan', 
            'Pelanggan', 
            'Metode Pembayaran', 
            'Total Produk (Rp)', 
            'Ongkir', 
            'Packaging', 
            'Total Bayar'
        ];

        $callback = function() use($pesananList, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pesananList as $pesanan) {
                // Get the latest successful payment
                $lastPayment = $pesanan->pembayaran->sortByDesc('pembayaran_id')->first();
                
                $ongkir = $pesanan->ongkir ?? 0;
                $packaging = $pesanan->biaya_wadah ?? 0;
                $pureProductPrice = $pesanan->total_harga - $ongkir - $packaging;

                $row['ID Pembayaran'] = $lastPayment ? '#PAY-' . str_pad($lastPayment->pembayaran_id, 5, '0', STR_PAD_LEFT) : '-';
                $row['ID Pesanan']    = '#ORD-' . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT);
                $row['Tanggal Pesan'] = $pesanan->tanggal_pesan->format('d/m/Y H:i:s');
                $row['Pelanggan']      = $pesanan->user->name ?? 'Guest';
                $row['Metode Pembayaran'] = $lastPayment ? strtoupper($lastPayment->metode_pembayaran) : '-';
                $row['Total Produk (Rp)'] = max(0, $pureProductPrice);
                $row['Ongkir'] = $ongkir;
                $row['Packaging'] = $packaging;
                $row['Total Bayar'] = $pesanan->total_harga;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
