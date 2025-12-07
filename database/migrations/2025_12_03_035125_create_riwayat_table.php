<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id('riwayatId');

            $table->unsignedBigInteger('staffId');        
            $table->string('pendidikan')->nullable();
            $table->string('instansi')->nullable();
            $table->date('tmt_awal')->nullable();
            $table->string('golongan')->nullable();
            $table->date('tmt_kini')->nullable();
            $table->tinyInteger('riwayat_jabatan')
                  ->default(0)
                  ->comment('0 = tetap pada amanahnya, 1 = pernah pindah tugas');
            $table->string('status')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
