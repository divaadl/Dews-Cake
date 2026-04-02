<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    protected $table = 'paket_detail';
    protected $primaryKey = 'paket_detail_id';

    protected $fillable = [
        'paket_id',
        'produk_id',
        'jumlah_per_jenis'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
