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
        Schema::create('peserta_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelatihan');
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('nip');
            $table->string('pangkat');
            $table->string('jabatan');
            $table->string('unit');
            $table->string('surat');
            $table->date('tanggal_surat');
            $table->string('status_riwayat_diklat');
            $table->string('angkatan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('keterangan_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_pelatihans');
    }
};
