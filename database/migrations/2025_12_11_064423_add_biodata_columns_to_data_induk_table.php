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
            if (!Schema::hasColumn('data_induk', 'birthPlace')) {
                $table->string('birthPlace')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'birthDate')) {
                $table->date('birthDate')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'nik')) {
                $table->string('nik')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'noHp')) {
                $table->string('noHp')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'statusPerkawinan')) {
                $table->string('statusPerkawinan')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'suami_istri')) {
                $table->string('suami_istri')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'alamat')) {
                $table->string('alamat')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('data_induk', 'keterangan')) {
                $table->string('keterangan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_induk', function (Blueprint $table) {
            $table->dropColumn([
                'birthPlace',
                'birthDate',
                'nik',
                'noHp',
                'statusPerkawinan',
                'suami_istri',
                'alamat',
                'email',
                'keterangan'
            ]);
        });
    }
};
