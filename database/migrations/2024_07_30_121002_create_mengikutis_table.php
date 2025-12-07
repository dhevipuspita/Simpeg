<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mengikutis', function (Blueprint $table) {
            $table->id("mengikutiId");
            $table->unsignedBigInteger("santriId");
            $table->timestamps();

            $table->foreign("santriId")->references("santriId")->on("santris")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mengikutis');
    }
};