<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_saw', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_izin_id')->constrained('pengajuan_izin')->onDelete('cascade');
            $table->foreignId('kriteria_saw_id')->constrained('kriteria_saw')->onDelete('cascade');
            $table->float('nilai_matriks');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_saw');
    }
};
