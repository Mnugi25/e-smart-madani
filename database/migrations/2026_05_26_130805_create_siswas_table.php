<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique(); // Identitas utama
            $table->string('nama_lengkap');
            $table->string('nama_orang_tua')->nullable();
            $table->enum('jk', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->timestamps();
        });

        // Tambahkan foreign key ke users setelah tabel siswa dibuat
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
        });

        Schema::dropIfExists('siswa');
    }
};
