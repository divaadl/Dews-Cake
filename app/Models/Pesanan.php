<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'pesanan_id';

    protected $fillable = [
        'user_id',
        'paket_id',
        'metode_pengambilan_id',
        'tanggal_pesan',
        'tanggal_pengambilan',
        'status_pesanan',
        'total_harga',
        'biaya_wadah',
        'ongkir',
        'catatan',
        'alamat_pesanan',
        'phone_pesanan',
        'jumlah_paket',
        'kurir'
    ];

    protected $casts = [
        'tanggal_pesan' => 'datetime',
        'tanggal_pengambilan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class, 'pesanan_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pesanan_id', 'pesanan_id');
    }

    public function detail()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id', 'paket_id');
    }
}
