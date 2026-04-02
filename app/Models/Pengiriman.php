<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'pengiriman_id';

    protected $fillable = [
        'pesanan_id',
        'nama_penerima',
        'phone_penerima',
        'alamat_pengiriman',
        'kurir',
        'ongkir',
        'status_pengiriman',
        'tanggal_kirim'
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'pesanan_id');
    }
}
