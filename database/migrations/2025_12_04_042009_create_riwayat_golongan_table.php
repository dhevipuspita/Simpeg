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
        Schema::create('riwayat_golongan', function (Blueprint $table) {
            $table->id('riwayat_gol_id');
            $table->unsignedBigInteger('riwayatId'); 
            $table->string('jenis_golongan');       
            $table->date('tanggal');               
            $table->timestamps();

            $table->foreign('riwayatId')
                ->references('riwayatId')
                ->on('riwayat')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_golongans');
    }
};
