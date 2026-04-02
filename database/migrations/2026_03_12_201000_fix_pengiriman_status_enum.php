<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Use raw SQL to modify enum column to ensure consistency
        DB::statement("ALTER TABLE pengiriman MODIFY COLUMN status_pengiriman ENUM('sedang_dikirim', 'terkirim') DEFAULT 'sedang_dikirim'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE pengiriman MODIFY COLUMN status_pengiriman ENUM('belum_dikirim', 'dalam_pengiriman', 'sampai') DEFAULT 'belum_dikirim'");
    }
};
