<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::withCount('produk')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori,
            'status' => $request->status
        ]);

        return redirect('/admin/kategori-produk');
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'status' => $request->status
        ]);

        return redirect('/admin/kategori-produk');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::withCount('produk')
            ->where('kategori_id', $id)
            ->firstOrFail();

        if ($kategori->produk_count > 0) {
            return redirect()
                ->back()
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh produk.');
        }

        $kategori->delete();

        return redirect()
            ->back()
            ->with('success', 'Kategori berhasil dihapus');
    }
}
