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
            // Cek dulu agar tidak error jika kolom sudah ada
            if (!Schema::hasColumn('pengguna', 'birth_place')) {
                $table->string('birth_place')->nullable()->after('birthday');
            }
            if (!Schema::hasColumn('pengguna', 'cover_photo_path')) {
                $table->string('cover_photo_path')->nullable()->after('profile_photo_path');
            }
            if (!Schema::hasColumn('pengguna', 'show_aspirasi')) {
                $table->boolean('show_aspirasi')->default(true)->after('cover_photo_path');
            }
            if (!Schema::hasColumn('pengguna', 'show_pengaduan')) {
                $table->boolean('show_pengaduan')->default(true)->after('show_aspirasi');
            }
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
