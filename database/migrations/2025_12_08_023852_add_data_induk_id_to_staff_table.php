<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->unsignedBigInteger('dataIndukId')->nullable()->after('staffId');

            $table->foreign('dataIndukId')
                  ->references('id')
                  ->on('data_induk')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropForeign(['dataIndukId']);
            $table->dropColumn('dataIndukId');
        });
    }
};
