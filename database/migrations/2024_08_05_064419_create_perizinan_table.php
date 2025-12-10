<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void // ← diperbaiki di sini
    {
        Schema::create('perizinan', function (Blueprint $table) {
            $table->id('perizinanId');

            // relasi
            $table->unsignedBigInteger('staffId');
            $table->unsignedBigInteger('data_induk_id');

            // data cuti
            $table->date('tglSurat')->nullable();
            $table->integer('lamaCuti')->nullable();
            $table->date('mulai_tanggal')->nullable();
            $table->date('akhir_tanggal')->nullable();
            $table->text('alasan')->nullable();

            $table->boolean('isComback')->default(false);

            $table->timestamps();

            // foreign key
            $table->foreign('staffId')
                ->references('staffId')
                ->on('staff')
                ->onDelete('cascade');

            $table->foreign('data_induk_id')
                ->references('id')
                ->on('data_induk')
                ->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};
