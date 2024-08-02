<?php

use Filament\Forms\Components\Tabs\Tab;
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
            $table->string('golongan')->nullable()->after('pangkat');
            $table->string('riwayat_diklat')->nullable()->after('status_riwayat_diklat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_pelatihans', function (Blueprint $table) {
            $table->dropColumn('golongan');
            $table->dropColumn('riwayat_diklat');
        });
    }
};
