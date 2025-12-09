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
        $table->string('jenjang')->nullable()->after('nama');
        $table->string('jabatan')->nullable()->after('jenjang');

        // Jika kolom lama mau dihapus:
        $table->dropColumn('jenjang_jabatan');
    });
}

public function down(): void
{
    Schema::table('data_induk', function (Blueprint $table) {
        $table->string('jenjang_jabatan')->nullable();
        $table->dropColumn(['jenjang', 'jabatan']);
    });
}

};
