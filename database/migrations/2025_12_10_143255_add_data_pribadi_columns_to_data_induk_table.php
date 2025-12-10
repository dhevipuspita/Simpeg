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
            // Tambahkan kolom data pribadi jika belum ada
            if (!Schema::hasColumn('data_induk', 'ttl')) {
                $table->string('ttl')->nullable()->after('mulai_bertugas');
            }
            if (!Schema::hasColumn('data_induk', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('ttl');
            }
            if (!Schema::hasColumn('data_induk', 'status_perkawinan')) {
                $table->string('status_perkawinan')->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('data_induk', 'suami_istri')) {
                $table->string('suami_istri')->nullable()->after('status_perkawinan');
            }
            if (!Schema::hasColumn('data_induk', 'alamat')) {
                $table->text('alamat')->nullable()->after('suami_istri');
            }
            if (!Schema::hasColumn('data_induk', 'email')) {
                $table->string('email')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('data_induk', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_induk', function (Blueprint $table) {
            $columns = ['ttl', 'no_hp', 'status_perkawinan', 'suami_istri', 'alamat', 'email', 'keterangan'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('data_induk', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
