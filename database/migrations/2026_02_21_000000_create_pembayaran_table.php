<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tagihan_siswa_id')
                ->constrained('tagihan_siswa')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('jumlah', 12, 2);

            $table->string('status');

            $table->boolean('tunggakan')->default(false);

            $table->text('keterangan')->nullable();

            $table->dateTime('tanggal_bayar')->index();

            $table->string('idempotency_key')->nullable()->unique();

            $table->timestamps();

            $table->index(['status','tanggal_bayar']);

            $table->string('kode_transaksi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};