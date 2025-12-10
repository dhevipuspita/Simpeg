<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('data_induk', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->string('nik')->unique();
    $table->string('npa')->nullable();
    $table->string('jabatan')->nullable();
    $table->string('gol')->nullable();
    $table->string('jenjang')->nullable();
    $table->date('mulai_bertugas')->nullable();

    // DATA DIRI
    $table->string('ttl')->nullable();
    $table->string('no_hp')->nullable();
    $table->string('status_perkawinan')->nullable();
    $table->string('suami_istri')->nullable();
    $table->string('alamat')->nullable();
    $table->string('email')->nullable();
    $table->text('keterangan')->nullable();

    // STATUS PEGAWAI (BEBAS ISI)
    $table->string('status_pegawai')->default('aktif');

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('data_induk');
    }
};
