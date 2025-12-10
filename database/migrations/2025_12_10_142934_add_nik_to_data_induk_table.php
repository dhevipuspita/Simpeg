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
        Schema::table('data_induk', function (Blueprint $table) {
            // Cek apakah kolom nik sudah ada
            if (!Schema::hasColumn('data_induk', 'nik')) {
                $table->string('nik')->nullable()->after('nama');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_induk', function (Blueprint $table) {
            if (Schema::hasColumn('data_induk', 'nik')) {
                $table->dropColumn('nik');
            }
        });
    }
};
