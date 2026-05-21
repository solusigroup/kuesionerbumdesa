<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('interview_logs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bumdesa');
            $table->string('nama_narasumber');
            $table->string('jabatan');
            $table->text('transkrip_kapasitas_x1')->nullable(); // Untuk menyimpan jawaban terkait X1
            $table->text('transkrip_budaya_x2')->nullable();    // Untuk menyimpan jawaban terkait X2
            $table->text('transkrip_tata_kelola_x3')->nullable(); // Untuk menyimpan jawaban terkait X3
            $table->text('transkrip_pelaporan_y')->nullable();   // Untuk menyimpan jawaban terkait Y
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('interview_logs');
    }
};
