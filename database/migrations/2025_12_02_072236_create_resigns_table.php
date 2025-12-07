<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resigns', function (Blueprint $table) {

            // Primary Key
            $table->id('resignId');

            // Fields
            $table->string('npa')->nullable();                  // NPA
            $table->string('name');                             // Nama
            $table->string('jabatan')->nullable();              // Jabatan
            $table->string('gol')->nullable();                  // Golongan
            $table->string('jenjang')->nullable();              // Jenjang
            $table->string('ttl')->nullable();                  // Tempat Tanggal Lahir
            $table->text('alamat')->nullable();                 // Alamat
            $table->string('pendidikan')->nullable();           // Pendidikan
            $table->date('tanggal_resign')->nullable();         // Tanggal Resign
            $table->string('alasan_resign')->nullable();        // Alasan Resign
            $table->string('nik')->nullable();                  // NIK
            $table->string('status_kepegawaian')->nullable();   // Status Kepegawaian
            $table->string('tahun')->nullable();                // Tahun
            $table->string('no_sk')->nullable();                // No SK

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resigns');
    }
};
