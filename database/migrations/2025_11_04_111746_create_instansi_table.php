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
            Schema::create('instansi', function (Blueprint $table) {
            $table->id('gid'); // Menggunakan 'gid' sebagai primary key
            $table->string('username', 255)->unique();
            $table->string('password');
            $table->string('full_name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone_number', 15)->nullable();
            $table->string('nip', 18)->nullable()->unique();
            $table->text('instance_name')->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('ignored_report_count')->default(0);
            $table->integer('ignored_aspiration_count')->default(0);
            $table->integer('processing_report_count')->default(0);
            $table->integer('processing_aspiration_count')->default(0);
            $table->integer('completed_report_count')->default(0);
            $table->integer('completed_aspiration_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};
