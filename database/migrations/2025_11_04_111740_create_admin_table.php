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
        Schema::create('admin', function (Blueprint $table) {
            $table->id('aid'); // Menggunakan 'aid' sebagai primary key
            $table->string('username', 255)->unique();
            $table->string('password');
            $table->string('full_name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone_number', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('received_report')->default(0);
            $table->integer('processing_count')->default(0);
            $table->integer('completed_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
