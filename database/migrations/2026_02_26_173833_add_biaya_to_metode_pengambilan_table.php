<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('metode_pengambilan', function (Blueprint $table) {
            $table->integer('biaya')->default(0)->after('nama_metode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('metode_pengambilan', function (Blueprint $table) {
            $table->dropColumn('biaya');
        });
    }
};
