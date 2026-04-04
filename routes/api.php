<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StafKeuangan\PembayaranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Semua route API untuk staf keuangan ada di sini.
| Autentikasi menggunakan Sanctum.
|
*/

Route::prefix('stafkeuangan')
    ->middleware('auth:sanctum')
    ->name('stafkeuangan.')
    ->group(function () {

        // 🔹 Menyimpan pembayaran siswa
        Route::post('/pembayaran', [PembayaranController::class, 'store'])
            ->name('pembayaran.store');

        // 🔹 Bisa tambahkan route lain untuk update / batal pembayaran
        // Route::patch('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        // Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
    });