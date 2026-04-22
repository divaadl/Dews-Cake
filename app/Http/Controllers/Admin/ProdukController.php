<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\KategoriProduk;

class ProdukController extends Controller
{
    public function index()
    {
        // Produk satuan = semua produk (bukan paket)
        $produk = Produk::with('kategori')->get();

        return view('admin.produk_satuan.index', compact('produk'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk_satuan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        // Generate kode produk otomatis
        $lastProduk = Produk::orderBy('produk_id', 'desc')->first();
        $newNumber = $lastProduk ? ((int) substr($lastProduk->kode_produk, 1) + 1) : 1;
        $kodeProduk = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Upload gambar
        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $namaGambar = null;
            if ($request->hasFile('gambar')) {
                $namaGambar = $request->file('gambar')->store('produk', 'public');
            }
        }

        Produk::create([
            'kode_produk'  => $kodeProduk,
            'nama_produk'  => $request->nama_produk,
            'kategori_id'  => $request->kategori_id,
            'harga'        => $request->harga,
            'berat'        => $request->berat,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => $namaGambar,
            'status'       => $request->status
        ]);

        return redirect('/admin/produk-satuan')
            ->with('success', 'Produk berhasil ditambahkan');
    }


    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = KategoriProduk::all();

        return view('admin.produk_satuan.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $data = [
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'berat'       => $request->berat,
            'deskripsi'   => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
            'status'      => $request->status
        ];

        // 🔥 JIKA ADA GAMBAR BARU
        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            // simpan gambar baru
            $gambarPath = $request->file('gambar')
                ->store('produk', 'public');

            $data['gambar'] = $gambarPath;
        }

        $produk->update($data);

        return redirect('/admin/produk-satuan')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Cek apakah produk dipakai di paket_detail
        $usedInPaket = \DB::table('paket_detail')->where('produk_id', $id)->exists();

        if ($usedInPaket) {
            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Produk tidak bisa dihapus karena sedang dipakai di paket.');
        }

        // Jika aman, hapus produk
        $produk->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $produk = Produk::where('produk_id', $id)->firstOrFail();

        $produk->status = $request->status;
        $produk->save();

        return redirect()->back();
    }

}
