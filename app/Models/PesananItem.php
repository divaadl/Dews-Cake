<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $table = 'pesanan_item';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'jumlah',
        'subtotal'
    ];
}
