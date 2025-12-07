<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('data_induk', function (Blueprint $table) {
        $table->string('status_pegawai')->default('aktif');
    });
}
    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('data_induk', function (Blueprint $table) {
        $table->dropColumn('status_pegawai');
    });
}
};
