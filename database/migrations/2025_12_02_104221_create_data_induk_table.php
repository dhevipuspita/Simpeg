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
            $table->date('mulai_bertugas')->nullable(); 
            $table->string('npa')->nullable();  
            $table->string('nama');             
            $table->string('jenjang')->nullable(); 
            $table->string('jabatan')->nullable(); 
            $table->string('status')->nullable(); 
            $table->string('status_pegawai')->nullable(); 
            $table->string('gol')->nullable();  
            $table->string('birthPlace')->nullable(); 
            $table->date('birthDate')->nullable(); 
            $table->string('nik')->nullable(); 
            $table->string('noHp')->nullable(); 
            $table->string('statusPerkawinan')->nullable(); 
            $table->string('suami_istri')->nullable(); 
            $table->string('alamat')->nullable(); 
            $table->string('email')->nullable(); 
            $table->string('keterangan')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_induk');
    }
};
