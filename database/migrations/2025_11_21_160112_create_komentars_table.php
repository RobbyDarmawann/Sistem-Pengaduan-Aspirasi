<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('komentars', function (Blueprint $table) {
        $table->id();
        $table->foreignId('laporan_id')->constrained('laporan')->onDelete('cascade');
        // Bisa null jika komentar dari admin/instansi
        $table->foreignId('pengguna_id')->nullable()->constrained('pengguna')->onDelete('cascade'); 
        $table->string('nama_pengomentar'); // Simpan nama manual jika dari instansi
        $table->text('isi_komentar');
        $table->string('peran'); // 'pengguna', 'admin', 'instansi'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
