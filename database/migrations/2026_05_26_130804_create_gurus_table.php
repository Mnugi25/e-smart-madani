<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('kode_guru')->unique(); // Identitas utama untuk jadwal
            $table->string('nama_lengkap');
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_hp');
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });

        // Tambahkan foreign key ke users setelah tabel guru dibuat
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
        });

        Schema::dropIfExists('guru');
    }
};
