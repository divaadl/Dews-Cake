<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Kategori;
use App\Models\Paket;
use App\Models\Pembayaran;
use App\Models\PesananDetail;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use App\Services\FonnteService;

class PesananController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }
    /*HALAMAN CHECKOUT*/
    // public function checkout()
    // {
    //     // session()->forget('cart');
    //     $user = Auth::user();
    //     $cart = session()->get('cart', []);

    //     $paketDipilih = null;

    //     foreach ($cart as $item) {
    //         if (($item['type'] ?? null) == 'paket') {
    //             $paketDipilih = Paket::find($item['id']);
    //             break;
    //         }
    //     }

    //     $total = collect($cart)->sum(function ($item) {
    //         return $item['harga'] * $item['qty'];
    //     });

    //     $produk = Produk::where('status','aktif')->get();
    //     $rekomendasi = session('rekomendasi');
    //     $budget = session('budget');
    //     $jumlahPerJenis = session('jumlahPerJenis');
    //     $orderMode = session('order_mode', 'manual');
    //     $weight = collect($cart)->sum(function($item){
    //         return $item['qty'] * 500; // asumsi 1 item = 500 gram
    //     });

    //     return view('user.checkout', compact(
    //         'user',
    //         'cart',
    //         'paketDipilih',
    //         'produk',
    //         'rekomendasi',
    //         'budget',
    //         'jumlahPerJenis',
    //         'orderMode',
    //         'total',
    //         'weight'
    //     ));
    // }
    public function checkout()
    {
        $cart = session('cart', []);

        // cari paket dari cart
        $paketDipilih = null;

        foreach ($cart as $item) {
            if (($item['type'] ?? null) == 'paket') {
                $paketId = $item['id'];
                $paketDipilih = Paket::find($paketId);
                break;
            }
        }

        $total = collect($cart)->sum(function ($item) {
            if (in_array(($item['type'] ?? ''), ['produk', 'rekomendasi'])) {
                return $item['qty'] * $item['harga'];
            }
            return 0;
        });

        // Hitung biaya wadah awal untuk ditampilkan
        $biayaWadahAwal = 0;
        $kardusCart = 0;
        if ($paketDipilih) {
            $totalKueCart = 0;
            foreach ($cart as $cartItem) {
                if (in_array(($cartItem['type'] ?? ''), ['produk', 'rekomendasi'])) {
                    $totalKueCart += (int) $cartItem['qty'];
                }
            }
            if ($totalKueCart > 0) {
                $kardusCart = ceil($totalKueCart / max(1, $paketDipilih->max_kue));
                $biayaWadahAwal = $kardusCart * $paketDipilih->biaya_wadah;
            }
        }

        return view('user.checkout', compact(
            'cart',
            'total',
            'paketDipilih',
            'biayaWadahAwal',
            'kardusCart'
        ));
    }

    /*SIMPAN PESANAN*/
    public function store(Request $request)
    {
        $cartRaw = json_decode($request->cart_data, true);
        $cart = [];

        foreach ($cartRaw as $item) {
            if (!isset($item['id']) || !$item['id']) continue;

            $cart[] = [
                'id'    => (int) $item['id'],
                'nama'  => $item['nama'],
                'harga' => (int) $item['harga'],
                'qty'   => (int) $item['qty'],
                'type'  => $item['type'] ?? 'produk'
            ];
        }

        if (empty($cart)) {
            return back()->with('error', 'Cart tidak valid.');
        }

        // ✅ simpan cart dari sidebar
        session(['cart' => $cart]);

        // kombinasikan tanggal dan jam
        $waktuPengambilan = $request->tanggal_pengambilan;
        
        // VALIDASI H-3 PENGAMBILAN
        $minDate = now()->addDays(3)->startOfDay();
        if ($waktuPengambilan) {
            try {
                $selectedDate = \Carbon\Carbon::parse($waktuPengambilan)->startOfDay();
                if ($selectedDate->lt($minDate)) {
                    return back()->with('error', 'Pemesanan minimal H-3 sebelum tanggal pengambilan. Tanggal paling awal yang tersedia adalah ' . $minDate->translatedFormat('d F Y') . '.');
                }
            } catch (\Exception $e) {
                // Ignore parse errors
            }
        }

        if ($request->has('jam_pengambilan') && $request->jam_pengambilan) {
            $waktuPengambilan .= ' ' . $request->jam_pengambilan . ':00';
        }

        // simpan data checkout
        session([
            'checkout_data' => [
                'tanggal_pengambilan' => $waktuPengambilan,
                'alamat' => $request->alamat_pesanan,
                'phone' => $request->phone_pesanan,
                'metode_pengambilan' => $request->metode_pengambilan,
                'ongkir' => $request->ongkir ?? 0,
                'mode_pesan' => $request->mode_pesan,
                'catatan_produk' => $request->catatan_produk ?? []
            ]
        ]);

        return redirect()->route('pesanan.lanjut');
    }

    /*UPDATE CART (AJAX)*/
    public function updateCart(Request $request)
    {
        $cart = [];

        foreach ($request->items as $item) {
            if ($item['qty'] > 0) {
                $cart[] = [
                'id'    => (int) $item['id'],      // ✅ pakai dari request
                'nama'  => $item['nama'],
                'harga' => $item['harga'],
                'qty'   => $item['qty'],
                'type'  => $item['type'] ?? 'produk'
            ];
            }
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'count'   => count($cart)
        ]);
    }

    public function rekomendasi(Request $request)
    {
        $budget  = (int) $request->budget;
        $paketId = $request->paket_id;

        $produk = Produk::orderBy('harga', 'asc')->get();

        $cart  = [];
        $total = 0;

        foreach ($produk as $p) {
            if ($total + $p->harga <= $budget) {

                $cart[] = [
                    'id'    => $p->produk_id,
                    'nama'  => $p->nama_produk,
                    'harga' => $p->harga,
                    'qty'   => 1,
                    'type'  => 'rekomendasi'
                ];

                $total += $p->harga;
            }
        }

        // ✅ TAMBAHKAN PAKET KE CART
        if ($paketId) {

            $paket = Paket::find($paketId);

            $cart[] = [
                'id' => $paket->paket_id,
                'nama' => $paket->nama_paket,
                'harga' => 0,
                'qty' => 1,
                'type' => 'paket'
            ];

            session()->put('paket_dipilih', $paket);
        }

        session()->put('cart', $cart);
        session()->put('total', $total);

        return redirect()->route('checkout');
    }

    public function rekomendasiAjax(Request $request)
    {
        $budget  = $request->budget;
        $paketId = $request->paket_id;

        $paket = Paket::with('detail.produk')
            ->findOrFail($paketId);

        // Validasi range budget
        if ($budget < $paket->minimal_budget || $budget > $paket->maksimal_budget) {
            return response()->json([
                'info' => 'Budget di luar range paket.'
            ], 200);
        }

        // Hitung jumlah jenis
        if ($paket->jenis_paket == 'kotak') {
            $jumlahJenis = $paket->max_kue;
            $qtyPerJenis = 1;
        } else {
            $qtyPerJenis = $paket->qty_per_jenis;
            $jumlahJenis = intval($paket->max_kue / $qtyPerJenis);
        }

        $produkList = $paket->detail;

        if ($produkList->count() < $jumlahJenis) {
            return response()->json([
                'info' => 'Produk dalam paket tidak mencukupi jumlah jenis.'
            ], 200);
        }

        $bestTotal = 0;
        $bestCombination = [];

        // 🔥 Recursive untuk cari kombinasi terbaik
        $findCombination = function ($start, $currentItems, $currentTotal)
            use (&$findCombination, $produkList, $budget, $paket,
                $jumlahJenis, $qtyPerJenis, &$bestTotal, &$bestCombination)
        {
            if (count($currentItems) == $jumlahJenis) {
                // Total kardus = pembulatan ke atas dari (total kue / kapasitas maksimum kue per kardus)
                $kardusDibutuhkan = ceil(count($currentItems) * $qtyPerJenis / max(1, $paket->max_kue));
                $biayaWadahTotal = $kardusDibutuhkan * $paket->biaya_wadah;
                $finalTotal = $currentTotal + $biayaWadahTotal;

                if (
                    $finalTotal >= $paket->minimal_budget &&
                    $finalTotal <= $budget &&
                    $finalTotal > $bestTotal
                ) {
                    $bestTotal = $finalTotal;
                    $bestCombination = $currentItems;
                }

                return;
            }

            for ($i = $start; $i < $produkList->count(); $i++) {

                $detail = $produkList[$i];
                if (!$detail->produk) continue;

                $hargaTotalItem = $detail->produk->harga * $qtyPerJenis;

                if ($currentTotal + $hargaTotalItem > $budget)
                    continue;

                $newItems = $currentItems;
                $newItems[] = $detail->produk;

                $findCombination(
                    $i + 1,
                    $newItems,
                    $currentTotal + $hargaTotalItem
                );
            }
        };

        $findCombination(0, [], 0);

        if (empty($bestCombination)) {
            return response()->json([
                'info' => 'Tidak ada kombinasi yang sesuai dengan budget dan paket yang dipilih.',
                'items' => [],
                'total' => 0
            ], 200);
        }

        return response()->json([
            'items' => collect($bestCombination)->map(function ($p) use ($qtyPerJenis) {
                return [
                    'id'    => $p->produk_id,
                    'nama'  => $p->nama_produk,
                    'harga' => $p->harga,
                    'qty'   => $qtyPerJenis
                ];
            }),
            'total' => $bestTotal
        ]);
    }

    public function lanjutkan()
    {
        $user = Auth::user();
        $cart = session('cart', []);
        $checkout = session('checkout_data');

        if (empty($cart) || !$checkout) {
            return redirect()->route('checkout')
                ->with('error', 'Data checkout tidak lengkap.');
        }

        $paketDipilih = null;

        foreach ($cart as $item) {
            if (($item['type'] ?? null) == 'paket') {
                $paketDipilih = Paket::find($item['id']);
                break;
            }
        }

        $produk = Produk::where('status','aktif')->get();

        $total = collect($cart)->sum(function ($item) {
            if (in_array(($item['type'] ?? ''), ['produk', 'rekomendasi'])) {
                return $item['qty'] * $item['harga'];
            }
            return 0;
        });
        // dd(session('cart'));

        return view('user.checkout', compact(
            'user',
            'cart',
            'paketDipilih',
            'produk',
            'checkout',
            'total'
        ));
    }

    public function konfirmasi(Request $request)
    {
        $cart = session('cart', []);
        $checkout = session('checkout_data');

        // VALIDASI H-3 PENGAMBILAN
        $minDate = now()->addDays(3)->startOfDay();
        $tglAmbilInput = $request->tanggal_pengambilan ?? (isset($checkout['tanggal_pengambilan']) ? explode(' ', $checkout['tanggal_pengambilan'])[0] : null);
        
        if ($tglAmbilInput) {
            try {
                $selectedDate = \Carbon\Carbon::parse($tglAmbilInput)->startOfDay();
                if ($selectedDate->lt($minDate)) {
                    return back()->with('error', 'Pemesanan minimal H-3 sebelum tanggal pengambilan. Tanggal paling awal yang tersedia adalah ' . $minDate->translatedFormat('d F Y') . '.');
                }
            } catch (\Exception $e) {
                // Ignore parse errors, will be caught by required validation or other logic
            }
        }

        // Jika cart kosong di session, coba parse dari cart_data (form submission langsung)
        if (empty($cart) && $request->has('cart_data')) {
            $cartRaw = json_decode($request->cart_data, true);
            foreach ($cartRaw as $item) {
                if (!isset($item['id']) || !$item['id']) continue;
                $cart[] = [
                    'id'    => (int) $item['id'],
                    'nama'  => $item['nama'],
                    'harga' => (int) $item['harga'],
                    'qty'   => (int) $item['qty'],
                    'type'  => $item['type'] ?? 'produk'
                ];
            }
        }

        if (!$checkout || $request->has('metode_pengambilan')) {
            $date = $request->tanggal_pengambilan;
            $time = $request->jam_pengambilan;
            $waktuPengambilan = ($date && $time) ? ($date . ' ' . $time . ':00') : ($date ?? ($checkout['tanggal_pengambilan'] ?? null));

            $checkout = [
                'tanggal_pengambilan' => $waktuPengambilan,
                'alamat' => $request->alamat_lengkap ?? $request->alamat_pesanan ?? ($checkout['alamat'] ?? ''),
                'phone' => $request->phone_pesanan ?? ($checkout['phone'] ?? ''),
                'metode_pengambilan' => $request->metode_pengambilan ?? ($checkout['metode_pengambilan'] ?? 'ambil'),
                'ongkir' => $request->ongkir ?? ($checkout['ongkir'] ?? 0),
                'mode_pesan' => $request->mode_pesan ?? ($checkout['mode_pesan'] ?? 'manual'),
                'catatan_produk' => $request->catatan_produk ?? ($checkout['catatan_produk'] ?? [])
            ];
        }

        if (empty($cart)) {
            return redirect()->route('checkout')
                ->with('error', 'Data keranjang tidak ditemukan atau tidak lengkap.');
        }

        // ================= AMBIL PAKET =================
        $paketId = null;

        foreach ($cart as $item) {
            if (($item['type'] ?? null) == 'paket') {
                $paketId = $item['id'];
                $jumlahPaket = $item['qty'] ?? 1;
                break;
            }
        }

        // ================= HITUNG TOTAL =================
        $totalProduk = collect($cart)->sum(function ($item) {
            if (in_array(($item['type'] ?? ''), ['produk', 'rekomendasi'])) {
                return $item['qty'] * $item['harga'];
            }
            return 0;
        });
        
        // ================= HITUNG BIAYA WADAH =================
        $biayaWadahTotal = 0;
        if ($paketId) {
            $paketDipilih = Paket::find($paketId);
            if ($paketDipilih) {
                // Hitung total kue di keranjang
                $totalKueCart = 0;
                foreach($cart as $cartItem) {
                    if(in_array(($cartItem['type'] ?? ''), ['produk', 'rekomendasi'])) {
                        $totalKueCart += $cartItem['qty'];
                    }
                }
                
                // Jika ada kue, hitung box
                if($totalKueCart > 0) {
                    $kardusCart = ceil($totalKueCart / max(1, $paketDipilih->max_kue));
                    $biayaWadahTotal = $kardusCart * $paketDipilih->biaya_wadah;
                }
            }
        }

        $ongkir = $checkout['ongkir'] ?? 0;
        $grandTotal = $totalProduk + $biayaWadahTotal + $ongkir;

        // ================= SUSUN ALAMAT LENGKAP =================
        $alamatLengkap = $checkout['alamat'];
        
        if ($request->metode_pengambilan == 'kirim') {
            $provName = ''; $cityName = ''; $distName = '';
            
            // Get names from Komerce APIs
            $provResponse = Http::withHeaders(['key' => env('RAJAONGKIR_KEY')])->get(env('RAJAONGKIR_URL').'/destination/province')->json('data');
            $cityResponse = Http::withHeaders(['key' => env('RAJAONGKIR_KEY')])->get(env('RAJAONGKIR_URL').'/destination/city/'.$request->provinsi)->json('data');
            $distResponse = Http::withHeaders(['key' => env('RAJAONGKIR_KEY')])->get(env('RAJAONGKIR_URL').'/destination/district/'.$request->kota)->json('data');
            
            if(is_array($provResponse)) { $p = collect($provResponse)->firstWhere('id', $request->provinsi); $provName = $p['name'] ?? ''; }
            if(is_array($cityResponse)) { $c = collect($cityResponse)->firstWhere('id', $request->kota); $cityName = $c['name'] ?? ''; }
            if(is_array($distResponse)) { $d = collect($distResponse)->firstWhere('id', $request->kecamatan); $distName = $d['name'] ?? ''; }
            
            $alamatLengkap = $request->alamat_lengkap . ', Kec. ' . $distName . ', ' . $cityName . ', Prov. ' . $provName;
        }

        // ================= SIMPAN PESANAN =================
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'paket_id' => $paketId ?? null,
            'alamat_pesanan' => $alamatLengkap,
            'phone_pesanan' => $checkout['phone'],
            'metode_pengambilan_id' => $request->metode_pengambilan == 'ambil' ? 1 : 2,
            'kurir' => $request->metode_pengambilan == 'kirim' ? strtoupper($request->kurir) : null,
            'tanggal_pesan' => now(),
            'tanggal_pengambilan' => ($request->tanggal_pengambilan && $request->jam_pengambilan) 
                ? ($request->tanggal_pengambilan . ' ' . $request->jam_pengambilan . ':00') 
                : ($checkout['tanggal_pengambilan'] ?? null),
            'status_pesanan' => 'menunggu_pembayaran',
            'total_harga' => $grandTotal,
            'biaya_wadah' => $biayaWadahTotal,
            'ongkir' => $ongkir,
            'catatan' => null,
            'jumlah_paket' => $jumlahPaket ?? 0,
        ]);

        $totalProduk = 0;

        // ================= SIMPAN DETAIL =================
        \Illuminate\Support\Facades\Storage::put('cart_dump.txt', json_encode($cart, JSON_PRETTY_PRINT));
        foreach ($cart as $item) {

            if (in_array(($item['type'] ?? null), ['produk', 'rekomendasi'])) {
                $qtyBaru = $request->qty_produk[$item['id']] ?? $item['qty'];
                $totalProduk += $item['harga'] * $qtyBaru;

                PesananDetail::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'produk_id'  => $item['id'],
                    'jumlah' => $qtyBaru,
                    'subtotal' => $item['harga'] * $qtyBaru,
                    'catatan'    => $checkout['catatan_produk'][$item['id']] ?? null
                ]);
            }
        }

        // ================= HITUNG JUMLAH BAYAR =================
        $jenis_pembayaran = $request->jenis_pembayaran ?? 'lunas';
        $jumlah_bayar = $jenis_pembayaran === 'dp' ? floor($grandTotal / 2) : $grandTotal;

        // ================= SIMPAN KE TABLE PEMBAYARAN =================
        $pembayaran = Pembayaran::create([
            'pesanan_id' => $pesanan->pesanan_id,
            'jenis_pembayaran' => $jenis_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran_pilihan == 'cash' ? 'cash' : null,
            'jumlah_bayar' => $jumlah_bayar,
            'status_pembayaran' => 'menunggu',
        ]);

        $snapToken = null;

        if ($request->metode_pembayaran_pilihan == 'online') {
            // ================= INTEGRASI MIDTRANS =================
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => 'PAY-' . $pembayaran->pembayaran_id . '-' . time(),
                    'gross_amount' => $jumlah_bayar,
                ),
                'customer_details' => array(
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => $checkout['phone'] ?? '',
                ),
            );

            try {
                $snapToken = Snap::getSnapToken($params);
            } catch (\Exception $e) {
                \Log::error('Midtrans Error: ' . $e->getMessage());
                return redirect()->route('checkout')
                    ->with('error', 'Gagal membuat tagihan pembayaran. Server Midtrans mungkin sedang bermasalah.');
            }
        }

        // ================= BERSIHKAN SESSION =================
        session()->forget(['cart', 'checkout_data']);

        // ================= KIRIM NOTIFIKASI WHATSAPP =================
        $expirationWarning = $pembayaran->metode_pembayaran != 'cash' 
            ? "\n\n*Penting:* Pesanan akan otomatis dibatalkan jika tidak dibayar dalam waktu *24 jam*." 
            : "";
        $customerMessage = "*Hallo {$pesanan->user->name}*,\n\nTerima kasih telah memesan di *Dews Cake*! 🎂\n\n*Detail Pesanan:*\nID Pesanan: #ORD-" . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) . "\nTotal Pembayaran: Rp " . number_format($pembayaran->jumlah_bayar, 0, ',', '.') . "\n\nSilakan selesaikan pembayaran Anda agar pesanan dapat segera kami proses.{$expirationWarning}\n\n_Pesan otomatis dari Dews Cake_";
        
        $adminMessage = "*Notifikasi Pesanan Baru* 🚨\n\nAda pesanan masuk dengan ID #ORD-" . str_pad($pesanan->pesanan_id, 5, '0', STR_PAD_LEFT) . "\nPelanggan: {$pesanan->user->name}\nTotal: Rp " . number_format($pesanan->total_harga, 0, ',', '.') . "\n\nSegera cek dashboard admin untuk proses lebih lanjut.";

        $this->fonnteService->sendMessage($pesanan->phone_pesanan, $customerMessage);
        $this->fonnteService->sendMessage(env('ADMIN_PHONE'), $adminMessage);

        return view('user.pay', compact('pesanan', 'pembayaran', 'snapToken'));
    }

    public function updateMetode(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'metode_pengambilan_id' => $request->metode_pengambilan_id
        ]);

        return redirect()->back()->with('success','Metode berhasil dipilih.');
    }

    public function getProvinces()
    {
        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get(env('RAJAONGKIR_URL').'/destination/province');

        if ($response->failed() || ($response->json('meta.status') === 'failed')) {
            return response()->json(['error' => true, 'message' => $response->json('meta.message') ?? 'Gagal mengambil data provinsi'], 400);
        }

        return response()->json($response->json('data') ?? []);
    }

    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get(env('RAJAONGKIR_URL').'/destination/city/' . $provinceId);

        if ($response->failed() || ($response->json('meta.status') === 'failed')) {
            return response()->json(['error' => true, 'message' => $response->json('meta.message') ?? 'Gagal mengambil data kota'], 400);
        }

        return response()->json($response->json('data') ?? []);
    }

    public function getDistricts($cityId)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get(env('RAJAONGKIR_URL').'/destination/district/' . $cityId);

        if ($response->failed() || ($response->json('meta.status') === 'failed')) {
            return response()->json(['error' => true, 'message' => $response->json('meta.message') ?? 'Gagal mengambil data kecamatan'], 400);
        }

        return response()->json($response->json('data') ?? []);
    }

    public function cekOngkir(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'weight' => 'numeric',
            'courier' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->asForm()->post(env('RAJAONGKIR_URL').'/calculate/district/domestic-cost', [
            'origin' => env('RAJAONGKIR_ORIGIN_DISTRICT'),
            'destination' => $request->destination,
            'weight' => $request->weight ?? 1000,
            'courier' => $request->courier
        ]);

        return $response->json();
    }


    public function review(Request $request)
    {
        $cartRaw = json_decode($request->cart_data, true) ?? [];
        $cart = [];

        foreach ($cartRaw as $item) {
            if (!isset($item['id']) || !$item['id']) continue;
            $cart[] = [
                'id'    => (int) $item['id'],
                'nama'  => $item['nama'],
                'harga' => (int) $item['harga'],
                'qty'   => (int) $item['qty'],
                'type'  => $item['type'] ?? 'produk'
            ];
        }

        session([
            'cart' => $cart,
            'checkout_data' => [
                'mode_pesan' => $request->mode_pesan ?? 'manual',
                'budget' => $request->budget,
                'cart_data' => $request->cart_data,
                'total_harga' => $request->total_harga,
                'tanggal_pengambilan' => null,
                'alamat' => '',
                'phone' => '',
                'metode_pengambilan' => 'ambil',
                'ongkir' => 0
            ]
        ]);

        return redirect()->route('pesanan.lanjut');
    }

    public function saya()
    {
        $pesanan = Pesanan::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->with(['detail.produk', 'pembayaran' => function($q) {
                 // Order by id descending to get the latest payment attempt (in case of double DP + Pelunasan records)
                 $q->orderBy('pembayaran_id', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pesanan_saya', compact('pesanan'));
    }

    public function pelunasan($id)
    {
        $pesanan = Pesanan::where('pesanan_id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        // Ensure order is eligible for pelunasan
        if ($pesanan->status_pesanan !== 'dp_dibayar') {
            return redirect()->route('pesanan.saya')->with('error', 'Pesanan ini tidak bisa dilakukan pelunasan saat ini.');
        }

        // Get the successful DP payment
        $dpPayment = Pembayaran::where('pesanan_id', $pesanan->pesanan_id)
            ->where('jenis_pembayaran', 'dp')
            ->where('status_pembayaran', 'berhasil')
            ->first();

        if (!$dpPayment) {
            return redirect()->route('pesanan.saya')->with('error', 'Pembayaran DP sebelumnya tidak valid.');
        }

        // Check if there is already an existing pelunasan attempt
        $pelunasan = Pembayaran::where('pesanan_id', $pesanan->pesanan_id)
            ->where('jenis_pembayaran', 'lunas')
            ->where('status_pembayaran', 'menunggu')
            ->first();

        if (!$pelunasan) {
            // Calculate remaining amount
            $wajibLunas = $pesanan->total_harga - $dpPayment->jumlah_bayar;

            $pelunasan = Pembayaran::create([
                'pesanan_id' => $pesanan->pesanan_id,
                'jenis_pembayaran' => 'lunas',
                'jumlah_bayar' => $wajibLunas,
                'status_pembayaran' => 'menunggu',
                'tanggal_bayar' => null,
            ]);
        }

        // Generate Midtrans Snap
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'PAY-' . $pelunasan->pembayaran_id . '-' . time(),
                'gross_amount' => $pelunasan->jumlah_bayar,
            ],
            'customer_details' => [
                'first_name' => $pesanan->user->name,
                'email' => $pesanan->user->email ?? 'noemail@example.com',
                'phone' => $pesanan->phone_pesanan,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $pembayaran = $pelunasan;
            return view('user.pay', compact('pesanan', 'pembayaran', 'snapToken'));
            
        } catch (\Exception $e) {
            \Log::error('Midtrans Pelunasan Error: ' . $e->getMessage());
            return redirect()->route('pesanan.saya')
                ->with('error', 'Gagal memproses pelunasan ke Midtrans. Silakan coba lagi nanti.');
        }
    }

    public function cancel($id)
    {
        $pesanan = Pesanan::where('pesanan_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pesanan->status_pesanan !== 'menunggu_pembayaran') {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        $pesanan->update([
            'status_pesanan' => 'batal'
        ]);

        // Update payment status if exists
        $pembayaran = Pembayaran::where('pesanan_id', $pesanan->pesanan_id)->first();
        if ($pembayaran) {
            $pembayaran->update([
                'status_pembayaran' => 'batal'
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function reorder($id)
    {
        $pesanan = Pesanan::where('pesanan_id', $id)
            ->where('user_id', Auth::id())
            ->with(['detail.produk', 'paket'])
            ->firstOrFail();

        $cart = [];

        // Jika ada paket
        if ($pesanan->paket_id) {
            $cart[] = [
                'id'    => (int) $pesanan->paket_id,
                'nama'  => $pesanan->paket->nama_paket ?? 'Paket Utama',
                'harga' => 0,
                'qty'   => (int) ($pesanan->jumlah_paket ?? 1),
                'type'  => 'paket'
            ];
        }

        // Tambahkan detail produk
        foreach ($pesanan->detail as $item) {
            if (!$item->produk) continue;

            $cart[] = [
                'id'    => (int) $item->produk_id,
                'nama'  => $item->produk->nama_produk,
                'harga' => (int) $item->produk->harga,
                'qty'   => (int) $item->jumlah,
                'type'  => 'produk'
            ];
        }

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Tidak ada item untuk dipesan kembali.');
        }

        session(['cart' => $cart]);

        return redirect()->route('checkout')->with('success', 'Item dari pesanan sebelumnya telah ditambahkan ke keranjang.');
    }

    public function lantutkanPembayaran($id)
    {
        $pesanan = Pesanan::where('pesanan_id', $id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        if ($pesanan->status_pesanan !== 'menunggu_pembayaran') {
            return redirect()->route('pesanan.saya')->with('error', 'Pesanan ini sudah tidak dalam status menunggu pembayaran.');
        }

        $pembayaran = Pembayaran::where('pesanan_id', $pesanan->pesanan_id)->first();
        if (!$pembayaran) {
            return redirect()->route('pesanan.saya')->with('error', 'Data pembayaran tidak ditemukan.');
        }

        // Generate Midtrans Snap
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'PAY-' . $pembayaran->pembayaran_id . '-' . time(),
                'gross_amount' => $pembayaran->jumlah_bayar,
            ],
            'customer_details' => [
                'first_name' => $pesanan->user->name,
                'email' => $pesanan->user->email ?? 'noemail@example.com',
                'phone' => $pesanan->phone_pesanan,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('user.pay', compact('pesanan', 'pembayaran', 'snapToken'));
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->route('pesanan.saya')
                ->with('error', 'Gagal menghubungkan ke Midtrans. Server mungkin sedang bermasalah.');
        }
    }
}