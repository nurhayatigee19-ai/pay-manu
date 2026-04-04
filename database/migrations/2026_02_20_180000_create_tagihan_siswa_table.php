<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihan_siswa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->foreignId('tahun_ajar_id')
                ->constrained('tahun_ajar')
                ->cascadeOnDelete();

            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');

            $table->decimal('nominal_tagihan', 12, 2)->default(600000);

            // ➕ kolom baru untuk logika pembayaran
            $table->decimal('total_tagihan', 12, 2)->default(600000);
            $table->decimal('total_dibayar', 12, 2)->default(0);
            $table->boolean('lunas')->default(false);

            $table->timestamps();

            $table->unique(['siswa_id', 'tahun_ajar_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan_siswa');
    }
};