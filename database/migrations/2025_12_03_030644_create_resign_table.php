<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_induk_id')->nullable()->constrained('data_induk')->onDelete('set null');
            $table->integer('no')->nullable();
            $table->date('mulai_bertugas')->nullable();
            $table->string('npa')->nullable();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('gol')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('ttl')->nullable(); // atau bisa split jadi tempat_lahir & tanggal_lahir
            $table->text('alamat')->nullable();
            $table->string('pendidikan')->nullable();
            $table->date('tanggal_resign')->nullable();
            $table->text('alasan_resign')->nullable();
            $table->string('nik')->nullable();
            $table->string('status_kepegawaian')->nullable();
            // Untuk TGL BLN THN - bisa digabung atau terpisah
            $table->string('tgl')->nullable();
            $table->string('bln')->nullable();
            $table->string('thn')->nullable();
            $table->string('no_sk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resign');
    }
};