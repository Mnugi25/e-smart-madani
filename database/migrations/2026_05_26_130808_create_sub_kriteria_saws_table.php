<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_kriteria_saw', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_saw_id')->constrained('kriteria_saw')->onDelete('cascade');
            $table->string('keterangan');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria_saw');
    }
};
