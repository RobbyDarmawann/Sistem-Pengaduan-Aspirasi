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
            $table->id('uid'); 
            $table->string('username', 100)->unique();
            $table->string('password'); 
            $table->string('full_name', 255);
            $table->integer('report_count')->default(0);   
            $table->integer('aspiration_count')->default(0);
            $table->tinyInteger('gender')->nullable()->comment('1=Laki-laki, 2=Perempuan');
            $table->string('email', 255)->unique();
            $table->date('birthday')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('nik', 16)->nullable()->unique();
            $table->string('job', 50)->nullable();
            $table->string('domicile', 255)->nullable();
            $table->string('address', 255)->nullable();
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
