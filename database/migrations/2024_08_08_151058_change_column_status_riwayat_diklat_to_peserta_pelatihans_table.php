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
        Schema::table('peserta_pelatihans', function (Blueprint $table) {
            $table->string('status_riwayat_diklat')->default('Tidak')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_pelatihans', function (Blueprint $table) {
            $table->string('status_riwayat_diklat')->default('Belum')->change();
        });
    }
};
