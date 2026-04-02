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
        Schema::create('pesanan_detail', function (Blueprint $table) {
            $table->bigIncrements('pesanan_detail_id');

            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('produk_id');

            $table->integer('jumlah');
            $table->integer('subtotal');

            $table->timestamps();

            // Relasi ke tabel pesanan
            $table->foreign('pesanan_id')
                ->references('pesanan_id')
                ->on('pesanan')
                ->onDelete('cascade');

            // Relasi ke tabel produk
            $table->foreign('produk_id')
                ->references('produk_id')
                ->on('produk')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_detail');
    }
};
