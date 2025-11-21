<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');

            $table->string('tipe_laporan'); // 'pengaduan' atau 'aspirasi'
            $table->string('judul');
            $table->text('isi_laporan');
            $table->date('tanggal_kejadian')->nullable(); // Nullable untuk aspirasi
            $table->string('lokasi_kejadian')->nullable(); // Nullable untuk aspirasi
            $table->string('kategori');
            $table->string('instansi_tujuan');

            $table->enum('status', ['belum_disetujui', 'disetujui', 'diproses', 'selesai', 'ditolak'])->default('belum_disetujui');
            
            $table->string('visibilitas'); 
            $table->string('lampiran')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
