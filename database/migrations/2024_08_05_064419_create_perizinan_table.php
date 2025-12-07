<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perizinan', function (Blueprint $table) {
            $table->id('perizinanId');

            // foreign key ke tabel staff
            $table->unsignedBigInteger('staffId');

            // kolom-kolom sesuai dengan model
            $table->date('tglSurat')->nullable(); // boleh nullable kalau kadang kosong
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('npa')->nullable();
            $table->string('birthPlace')->nullable();
            $table->date('birthDate')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('jabatan')->nullable();

            $table->date('tglMulai')->nullable();
            $table->date('tglAkhir')->nullable();
            $table->integer('lamaCuti')->nullable(); // bisa integer untuk jumlah hari
            $table->text('alasan')->nullable();

            $table->boolean('isComback')->default(false);

            $table->timestamps();

            // sesuaikan nama tabel dan PK staff di sini
            $table->foreign('staffId')
                  ->references('staffId')
                  ->on('staff')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};
