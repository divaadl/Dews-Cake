<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengiriman', function (Blueprint $col) {
            $col->string('nama_penerima')->after('pesanan_id')->nullable();
            $col->string('phone_penerima')->after('nama_penerima')->nullable();
            $col->string('kurir')->after('alamat_pengiriman')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pengiriman', function (Blueprint $col) {
            $col->dropColumn(['nama_penerima', 'phone_penerima', 'kurir']);
        });
    }
};
