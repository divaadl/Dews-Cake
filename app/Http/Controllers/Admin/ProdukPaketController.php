<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Paket;
use App\Models\Produk;
use App\Models\PaketDetail;
use Illuminate\Http\Request;

class ProdukPaketController extends Controller
{
    public function index()
    {
        $paket = Paket::all();
        return view('admin.produk_paket.index', compact('paket'));
    }

    public function create()
    {
        return view('admin.produk_paket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'jenis_paket' => 'required',
            'max_kue' => 'required|integer|min:1',
            'minimal_budget' => 'required|numeric',
            'maksimal_budget' => 'required|numeric',
            'biaya_wadah' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('paket', 'public');
        }

        Paket::create($data);

        return redirect('/admin/produk-paket')
            ->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.produk_paket.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        // ✅ Validasi input termasuk max_kue
        $request->validate([
            'nama_paket' => 'required',
            'jenis_paket' => 'required',
            'minimal_budget' => 'required|numeric',
            'maksimal_budget' => 'required|numeric',
            'max_kue' => 'required|integer|min:1',
            'biaya_wadah' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|in:aktif,nonaktif',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->all();

        // ✅ Handle update gambar
        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if ($paket->gambar && Storage::disk('public')->exists($paket->gambar)) {
                Storage::disk('public')->delete($paket->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('paket', 'public');
        }

        // ✅ Update paket
        $paket->update($data);

        return redirect('/admin/produk-paket')
            ->with('success', 'Paket berhasil diupdate');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);

        // Cek apakah paket dipakai di tabel paket_detail
        $usedInDetail = \DB::table('paket_detail')->where('paket_id', $id)->exists();

        if ($usedInDetail) {
            return redirect()->back()->with('error', 'Paket ini tidak bisa dihapus karena masih ada detail paket.');
        }

        $paket->delete();

        return redirect()->back()->with('success', 'Paket berhasil dihapus.');
    }


    public function updateStatus(Request $request, $id)
    {
        $paket = Paket::where('paket_id', $id)->firstOrFail();
        $paket->status = $request->status;
        $paket->save();

        return redirect()->back();
    }

    public function detail($id)
    {
        $paket = Paket::where('paket_id', $id)->firstOrFail();

        $produk = Produk::where('status', 'aktif')->get();

        $produkPaket = PaketDetail::where('paket_id', $id)
            ->with('produk')
            ->get();

        // hanya untuk informasi
        $totalKue = $produkPaket->sum('jumlah_per_jenis');
        
        $jumlahPerJenis = $paket->qty_per_jenis ?? 1;
        $jumlahJenis = $paket->max_kue > 0 ? floor($paket->max_kue / $jumlahPerJenis) : 1; 

        return view('admin.produk_paket.detail', compact(
            'paket',
            'produkPaket',
            'produk',
            'totalKue',
            'jumlahPerJenis',
            'jumlahJenis'
        ));
    }

    public function tambahProduk(Request $request, $paket_id)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,produk_id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $cek = PaketDetail::where('paket_id', $paket_id)
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($cek) {
            $cek->increment('jumlah_per_jenis', $request->jumlah);
        } else {
            PaketDetail::create([
                'paket_id' => $paket_id,
                'produk_id' => $request->produk_id,
                'jumlah_per_jenis' => $request->jumlah
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function hapusProduk($paket_id, $produk_id)
    {
        $detail = PaketDetail::where('paket_id', $paket_id)
            ->where('produk_id', $produk_id)
            ->first();

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        // Jika jumlah lebih dari 1 → kurangi 1
        if ($detail->jumlah_per_jenis > 1) {
            $detail->decrement('jumlah_per_jenis');

            return response()->json([
                'success' => true,
                'deleted' => false,
                'new_jumlah' => $detail->jumlah_per_jenis
            ]);
        }

        // Jika jumlah tinggal 1 → hapus record
        $detail->delete();

        return response()->json([
            'success' => true,
            'deleted' => true
        ]);
    }
}
