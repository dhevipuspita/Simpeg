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
        if (Schema::hasTable('staff')) {
            return;
        }
    
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staffId'); // Primary Key

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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
