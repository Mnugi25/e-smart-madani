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
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('siswa', 'no_hp_orang_tua')) {
                $table->dropColumn('no_hp_orang_tua');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'alamat')) {
                $table->text('alamat')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('siswa', 'no_hp_orang_tua')) {
                $table->string('no_hp_orang_tua')->nullable()->after('nama_orang_tua');
            }
        });
    }
};
