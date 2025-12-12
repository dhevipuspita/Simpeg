<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resign', function (Blueprint $table) {
            $table->id('resignId');

            // relasi
            $table->unsignedBigInteger('data_induk_id');

            // data cuti
            $table->date('tanggal_surat');
            $table->text('alasan_resign');
            $table->text('no_sk');
            $table->boolean('isComback')->default(false);
            $table->timestamps();

            // foreign key
            $table->foreign('data_induk_id')
                ->references('id')
                ->on('data_induk')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resign');
    }
};
