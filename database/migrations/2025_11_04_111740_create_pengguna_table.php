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
        $table->id();
        $table->string('username')->unique()->nullable();
        $table->string('email')->unique()->nullable();
        $table->string('phone_number')->unique()->nullable();
        $table->string('password');
        $table->string('full_name');
        
        // KOLOM FOTO (Pastikan ini ada)
        $table->string('profile_photo_path', 2048)->nullable();
        $table->string('cover_photo_path', 2048)->nullable();
        
        // KOLOM PRIVASI (Pastikan ini ada)
        $table->boolean('show_aspirasi')->default(true);
        $table->boolean('show_pengaduan')->default(true);

        // KOLOM LAINNYA
        $table->integer('report_count')->default(0);
        $table->integer('aspiration_count')->default(0);
        $table->string('gender')->nullable();
        $table->date('birthday')->nullable();
        $table->string('birth_place')->nullable(); // Tempat Lahir
        $table->string('nik')->unique()->nullable();
        $table->string('job')->nullable();
        $table->string('domicile')->nullable();
        $table->string('address')->nullable();
        $table->string('role')->default('user');
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
