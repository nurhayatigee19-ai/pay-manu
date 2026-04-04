<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran_audit', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pembayaran_id')->constrained('pembayaran');
            $table->foreignId('user_id')->nullable()->constrained('users');

            $table->string('aksi'); // created, updated, batal
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_audit');
    }
};