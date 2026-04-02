<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'harga',
        'deskripsi',
        'gambar',
        'kategori_id',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function detail()
    {
        return $this->hasMany(PesananDetail::class, 'produk_id');
    }
}
