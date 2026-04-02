<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket';
    protected $primaryKey = 'paket_id';

    protected $fillable = [
        'nama_paket',
        'jenis_paket',
        'minimal_budget',
        'maksimal_budget',
        'deskripsi',
        'status',
        'gambar',
        'max_kue',
        'qty_per_jenis',
        'biaya_wadah',
    ];

    public function detail()
    {
        return $this->hasMany(PaketDetail::class, 'paket_id', 'paket_id');
    }

    // public function produk()
    // {
    //     return $this->belongsToMany(
    //         Produk::class,
    //         'paket_detail',      // nama tabel pivot
    //         'paket_id',          // foreign key di pivot untuk Paket
    //         'produk_id',         // foreign key di pivot untuk Produk
    //         'paket_id',          // local key Paket
    //         'produk_id'          // local key Produk
    //     )->withPivot('jumlah_per_jenis');
    // }
}
