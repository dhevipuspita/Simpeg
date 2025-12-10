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
        // Drop tabel staff beserta relasi
        Schema::dropIfExists('staff');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate tabel staff jika rollback
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staffId');
            $table->unsignedBigInteger('dataIndukId')->nullable();
            
            $table->string('name');
            $table->string('birthPlace')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('nik')->nullable();
            $table->string('noHp')->nullable();
            $table->string('statusPerkawinan')->nullable();
            $table->string('suami_istri')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('dataIndukId')
                  ->references('id')
                  ->on('data_induk')
                  ->onDelete('cascade');
        });
    }
};
