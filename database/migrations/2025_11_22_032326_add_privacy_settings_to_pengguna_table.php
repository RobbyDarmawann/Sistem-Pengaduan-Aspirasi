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
    Schema::table('pengguna', function (Blueprint $table) {
        // 1 = Tampilkan, 0 = Sembunyikan
        $table->boolean('show_aspirasi')->default(true);
        $table->boolean('show_pengaduan')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            //
        });
    }
};
