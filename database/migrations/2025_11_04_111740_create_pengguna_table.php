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
Schema::create('pengguna', function (Blueprint $table) {
            $table->id(); // Sesuai gambar Anda, Anda pakai 'id'
            
            // --- INI PERBAIKANNYA ---
            $table->string('username')->unique()->nullable(); // <-- TAMBAHKAN ->nullable()
            $table->string('email')->unique()->nullable();    // <-- TAMBAHKAN ->nullable()
            $table->string('phone_number')->unique()->nullable(); // <-- TAMBAHKAN ->nullable()
            // --- AKHIR PERBAIKAN ---

            $table->string('password');
            $table->string('full_name');
            $table->integer('report_count')->default(0);
            $table->integer('aspiration_count')->default(0);
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('job')->nullable();
            $table->string('domicile')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
