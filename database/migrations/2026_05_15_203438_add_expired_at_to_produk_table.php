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
        if (Schema::hasColumn('produk', 'expired_at')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->dropColumn('expired_at');
            });
        }

        if (!Schema::hasColumn('produk', 'masa_simpan')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->text('masa_simpan')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('produk', 'masa_simpan')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->dropColumn('masa_simpan');
            });
        }
    }
};
