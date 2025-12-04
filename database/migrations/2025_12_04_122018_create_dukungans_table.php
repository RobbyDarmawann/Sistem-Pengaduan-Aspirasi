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
    Schema::create('dukungans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('laporan_id')->constrained('laporan')->onDelete('cascade');

        // Kita simpan ID user dan Jenis Usernya (admin, instansi, atau pengguna)
        $table->unsignedBigInteger('user_id'); 
        $table->string('user_type'); // Isinya nanti: 'admin', 'instansi', atau 'pengguna'

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dukungans');
    }
};
