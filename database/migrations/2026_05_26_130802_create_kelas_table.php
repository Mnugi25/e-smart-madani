<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            // Tabel relasi sebenarnya bernama 'jurusan'
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->string('tingkat'); // Simpan 'X', 'XI', 'XII' sesuai format yang digunakan di UI
            $table->string('nama_kelas'); // Contoh: 'X RPL 1', 'XI TKJ 1'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
