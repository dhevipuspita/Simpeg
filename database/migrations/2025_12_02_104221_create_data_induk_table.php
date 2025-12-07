<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_induk', function (Blueprint $table) {
            $table->id();                       // Primary Key
            $table->integer('no')->nullable();  // No
            $table->date('mulai_bertugas')->nullable(); // Mulai bertugas
            $table->string('npa')->nullable();  // N P A
            $table->string('nama');             // Nama
            $table->string('jenjang_jabatan')->nullable(); // Jenjang jabatan
            $table->string('gol')->nullable();  // Gol
            $table->string('status')->nullable(); // Status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_induk');
    }
};
