<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nama_siswa')->nullable()->after('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('jk');
        });

        // Copy data
        DB::table('siswa')->update([
            'nama_siswa' => DB::raw('nama_lengkap'),
            'jenis_kelamin' => DB::raw('jk'),
        ]);
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('nama_siswa');
            $table->dropColumn('jenis_kelamin');
        });
    }
};
