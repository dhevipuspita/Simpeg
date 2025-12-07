<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bpjs', function (Blueprint $table) {
            $table->id('bpjsId'); 

            $table->unsignedBigInteger('staffId'); 
            $table->foreign('staffId')->references('staffId')->on('staff')->onDelete('cascade');

            $table->string('name'); 
            $table->string('noBpjs')->nullable();
            $table->string('kjp_2p')->nullable();
            $table->string('kjp_3p')->nullable();
            $table->string('keterangan')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); 
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bpjs');
    }
};
