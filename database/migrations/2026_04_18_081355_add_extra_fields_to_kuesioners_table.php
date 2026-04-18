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
        Schema::table('kuesioners', function (Blueprint $table) {
            $table->string('nomor_wa')->nullable()->after('nama_responden');
            $table->string('email_bumdesa')->nullable()->after('nomor_wa');
            $table->string('nama_desa')->nullable()->after('nama_bumdesa');
            $table->string('kecamatan')->nullable()->after('nama_desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuesioners', function (Blueprint $table) {
            $table->dropColumn(['nomor_wa', 'email_bumdesa', 'nama_desa', 'kecamatan']);
        });
    }
};
