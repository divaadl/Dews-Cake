<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use App\Models\Paket;
use App\Models\Produk;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tab      = $request->tab ?? 'satuan';
        $q        = $request->q;
        $kategori = $request->kategori;
        $min      = $request->min;
        $max      = $request->max;

        $kategoriList = KategoriProduk::all();

        /* ================= PAKET ================= */
        if ($tab == 'paket') {

            $paket = Paket::with(['detail.produk']) // ⬅️ INI PENTING
                ->where('status', 'aktif')
                ->when($q, function ($query) use ($q) {
                    $query->where('nama_paket', 'like', "%$q%")
                        ->orWhere('deskripsi', 'like', "%$q%");
                })
                ->when($min, fn($q2) => $q2->where('minimal_budget', '>=', $min))
                ->when($max, fn($q2) => $q2->where('maksimal_budget', '<=', $max))
                ->orderBy('jenis_paket')
                ->get()
                ->groupBy('jenis_paket');

            $cart = session()->get('cart', []);

            return view('user.menu.index', compact(
                'paket',
                'tab',
                'kategoriList',
                'cart'
            ));
        }

        /* ================= PRODUK SATUAN ================= */
        $kategoriData = KategoriProduk::with(['produk' => function ($query) use ($q, $kategori, $min, $max) {

            if ($q) {
                $query->where('nama_produk', 'like', "%$q%")
                    ->orWhere('deskripsi', 'like', "%$q%");
            }

            if ($min) {
                $query->where('harga', '>=', $min);
            }

            if ($max) {
                $query->where('harga', '<=', $max);
            }

        }])
        ->when($kategori, fn($q3) => $q3->where('id', $kategori))
        ->get();

        $cart = session()->get('cart', []);

        return view('user.menu.index', [
            'kategori'      => $kategoriData,
            'tab'           => $tab,
            'kategoriList'  => $kategoriList,
            'cart'          => $cart
        ]);
    }
}
