<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePengambilan extends Model
{
    protected $table = 'metode_pengambilan';
    protected $primaryKey = 'metode_pengambilan_id';

    protected $fillable = [
        'nama_metode',
        'biaya'
    ];
}
