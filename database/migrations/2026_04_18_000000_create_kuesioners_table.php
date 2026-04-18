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
        Schema::dropIfExists('kuesioners');
        Schema::create('kuesioners', function (Blueprint $table) {
            $table->id();
            $table->string('nama_responden');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->integer('usia');
            $table->string('jabatan');
            $table->string('nama_bumdesa');
            $table->string('kabupaten_kota');
            $table->string('lama_menjabat');
            $table->string('pendidikan_terakhir');
            $table->enum('pernah_pelatihan', ['Ya', 'Tidak']);
            $table->enum('menggunakan_aplikasi', ['Ya', 'Tidak']);
            $table->string('frekuensi_pelatihan')->nullable();
            
            // Variabel X1 s.d Y (20 item)
            for ($i = 1; $i <= 5; $i++) $table->integer("x1_$i");
            for ($i = 1; $i <= 5; $i++) $table->integer("x2_$i");
            for ($i = 1; $i <= 5; $i++) $table->integer("x3_$i");
            for ($i = 1; $i <= 5; $i++) $table->integer("y$i");
            
            // Pertanyaan Terbuka
            $table->text('hambatan_besar')->nullable();
            $table->text('pengaruh_budaya')->nullable();
            $table->text('perbaikan_dibutuhkan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioners');
    }
};