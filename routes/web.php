<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\User\LokasiController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\ProdukPaketController;
use App\Http\Controllers\Admin\KategoriProdukController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentCallbackController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Route::get('/cron/cancel-expired', function (\Illuminate\Http\Request $request) {
    Log::info('Cron Attempt Cancel Expired - IP: ' . $request->ip() . ' - Params: ' . json_encode($request->all()));

    if ($request->key !== 'DewsCakeSecret2024') {
        Log::warning('Unauthorized Cron Attempt from IP: ' . $request->ip());
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized key.'
        ], 403);
    }
    
    Log::info('Executing orders:cancel-expired directly via HTTP...');
    
    try {
        Artisan::call('orders:cancel-expired');
        $output = Artisan::output();
        return response()->json([
            'status' => 'success',
            'message' => 'Direct command executed.',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        Log::error('Cron Execution Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/cron/order-reminder', function (\Illuminate\Http\Request $request) {
    Log::info('Cron Attempt Order Reminder - IP: ' . $request->ip() . ' - Params: ' . json_encode($request->all()));

    if ($request->key !== 'DewsCakeSecret2024') {
        Log::warning('Unauthorized Cron Attempt from IP: ' . $request->ip());
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized key.'
        ], 403);
    }
    
    Log::info('Executing orders:remind-pelunasan directly via HTTP...');
    
    try {
        Artisan::call('orders:remind-pelunasan');
        $output = Artisan::output();
        return response()->json([
            'status' => 'success',
            'message' => 'Direct command executed.',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        Log::error('Cron Execution Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

/*USER (PUBLIC)*/

Route::get('/clear-cache', function() {
    try {
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        return "Cache berhasil dibersihkan!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/', function () {
    return view('user.beranda');
})->name('beranda');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi');

Route::get('/debug-session', function () {
    return response()->json(session()->all());
});

Route::post('/cart/update', [PesananController::class, 'updateCart'])
    ->middleware('auth')
    ->name('cart.update');

Route::post('/payment/callback', [PaymentCallbackController::class, 'receive']);


Route::middleware('auth')->group(function () {
    Route::post('/checkout/review', [PesananController::class, 'review'])
    ->name('checkout.review');
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [PesananController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', function() {
        return view('user.checkout_success');
    })->name('checkout.success');
    Route::get('/pesanan-saya', [PesananController::class, 'saya'])->name('pesanan.saya');
    Route::post('/pesanan/{id}/batal', [PesananController::class, 'cancel'])->name('pesanan.cancel');
    Route::post('/pesanan/{id}/reorder', [PesananController::class, 'reorder'])->name('pesanan.reorder');
    Route::get('/pesanan/{id}/pelunasan', [PesananController::class, 'pelunasan'])->name('pesanan.pelunasan');
    Route::post('/pesanan/{id}/lanjut', [PesananController::class, 'lantutkanPembayaran'])->name('pesanan.lantutkanPembayaran');
    Route::post('/paket/rekomendasi', [PesananController::class, 'rekomendasi'])->name('paket.rekomendasi');
    Route::post('/rekomendasi-paket', [PesananController::class, 'rekomendasi'])->name('rekomendasi.paket');
    Route::post('/paket/rekomendasi/ajax', [App\Http\Controllers\PesananController::class, 'rekomendasiAjax'])->name('paket.rekomendasi.ajax');
    Route::post('/paket/rekomendasi-global', [App\Http\Controllers\PesananController::class, 'rekomendasiGlobal'])->name('rekomendasi.global');
    Route::get('/lanjutkan', [PesananController::class, 'lanjutkan'])->name('pesanan.lanjut');
    Route::post('/konfirmasi', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
    Route::put('/pesanan/{id}/update-metode',[PesananController::class, 'updateMetode'])->name('pesanan.updateMetode');
    Route::post('/cek-ongkir', [PesananController::class, 'cekOngkir'])->name('cek.ongkir');
    Route::get('/api/provinces', [PesananController::class, 'getProvinces'])->name('api.provinces');
    Route::get('/api/cities/{province}', [PesananController::class, 'getCities'])->name('api.cities');
    Route::get('/api/districts/{city}', [PesananController::class, 'getDistricts'])->name('api.districts');
    // Route::get('/paket/detail/{id}', 
    //     [PaketController::class, 'getDetail']
    // )->name('paket.detail.ajax');

    Route::get('/paket/{id}/produk-detail', function ($id) {
        return \App\Models\PaketDetail::where('paket_id', $id)
            ->with('produk')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->produk->nama_produk,
                    'harga' => $item->produk->harga,
                    'qty'   => $item->jumlah_per_jenis
                ];
            });
    });
    // web.php
    Route::post('/cart/reset-manual', function () {

        $cart = session('cart', []);

        // Ambil hanya paket
        $paket = collect($cart)->firstWhere('type', 'paket');

        session([
            'cart' => $paket ? [$paket] : [],
            'order_mode' => 'manual'
        ]);

        // JANGAN HAPUS session('rekomendasi')

        return response()->json(['success' => true]);
    })->name('cart.reset.manual');

    Route::post('/set-budget', function (\Illuminate\Http\Request $request) {
        session([
            'budget' => $request->budget
        ]);
        return response()->json(['ok' => true]);
    })->name('set.budget');
});

Route::middleware('auth')->group(function () {
    Route::post('/paket/select', [PesananController::class, 'selectPaket'])
        ->name('paket.select');
});

Route::middleware('auth')->group(function () {
    Route::get('/akun', [AccountController::class, 'index'])->name('akun.index');
    Route::get('/akun/edit', [AccountController::class, 'edit'])->name('akun.edit');
    Route::post('/akun/update', [AccountController::class, 'update'])->name('akun.update');
});

/*AUTH USER*/
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/*AUTH ADMIN*/
// Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
// Route::post('/admin/login', [AdminAuthController::class, 'login']);

/*ADMIN (PROTECTED)*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin']);
});

Route::prefix('admin')
    ->middleware('isAdmin')
    ->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/pesanan', [\App\Http\Controllers\Admin\PesananController::class, 'index'])->name('admin.pesanan.index');
        Route::post('/pesanan/{id}/update-status', [\App\Http\Controllers\Admin\PesananController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');

        Route::get('/pembayaran', [\App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('admin.pembayaran.index');

        // Pengiriman
        Route::get('/pengiriman', [App\Http\Controllers\Admin\PengirimanController::class, 'index'])->name('admin.pengiriman.index');
        Route::post('/pengiriman/update-status/{id}', [App\Http\Controllers\Admin\PengirimanController::class, 'updateStatus'])->name('admin.pengiriman.updateStatus');
        Route::post('/pengiriman/update-info/{id}', [App\Http\Controllers\Admin\PengirimanController::class, 'updateInfo'])->name('admin.pengiriman.updateInfo');

        // Laporan
        Route::get('/laporan-penjualan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan-penjualan/export', [App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('admin.laporan.export');

        /* === PRODUK SATUAN === */
        Route::get('/produk-satuan', [ProdukController::class, 'index']);
        Route::get('/produk-satuan/create', [ProdukController::class, 'create']);
        Route::post('/produk-satuan', [ProdukController::class, 'store']);
        Route::get('/produk-satuan/{id}/edit', [ProdukController::class, 'edit']);
        Route::post('/produk-satuan/{id}/update', [ProdukController::class, 'update']);
        Route::delete('/produk-satuan/{id}', [ProdukController::class, 'destroy']);

        /* === KATEGORI PRODUK === */
        Route::get('/kategori-produk', [KategoriProdukController::class, 'index']);
        Route::get('/kategori-produk/create', [KategoriProdukController::class, 'create']);
        Route::post('/kategori-produk', [KategoriProdukController::class, 'store']);
        Route::get('/kategori-produk/{id}/edit', [KategoriProdukController::class, 'edit']);
        Route::post('/kategori-produk/{id}', [KategoriProdukController::class, 'update']);
        Route::delete('/kategori-produk/{id}', [KategoriProdukController::class, 'destroy']);

        /* === PRODUK PAKET === */
        Route::get('/produk-paket', [ProdukPaketController::class, 'index']);
        Route::get('/produk-paket/create', [ProdukPaketController::class, 'create']);
        Route::post('/produk-paket', [ProdukPaketController::class, 'store']);
        Route::get('/produk-paket/{id}/edit', [ProdukPaketController::class, 'edit']);
        Route::post('/produk-paket/{id}/update', [ProdukPaketController::class, 'update']);
        Route::delete('/produk-paket/{id}', [ProdukPaketController::class, 'destroy']);
        Route::get('/produk-paket/{paket_id}/detail',[ProdukPaketController::class, 'detail']);
        Route::post('/produk-paket/{paket_id}/tambah-produk',[ProdukPaketController::class, 'tambahProduk']);
        Route::post('/produk-paket/{paket_id}/hapus-produk/{produk_id}',[ProdukPaketController::class, 'hapusProduk']);
});