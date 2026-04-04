<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tagihan_siswa', function (Blueprint $table) {

            // hanya tambah unique constraint
            $table->unique(
                ['siswa_id', 'tahun_ajar_id', 'semester'],
                'tagihan_unique'
            );

        });
    }

    public function down(): void
    {
        Schema::table('tagihan_siswa', function (Blueprint $table) {

            $table->dropUnique('tagihan_unique');

        });
    }
};