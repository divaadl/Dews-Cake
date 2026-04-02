<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'nama_kategori',
        'status'
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
