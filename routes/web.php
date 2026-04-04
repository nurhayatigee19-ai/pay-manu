<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TahunAjarController;
use App\Http\Controllers\StafKeuangan\UserController;

use App\Http\Controllers\StafKeuangan\DashboardController as StafDashboard;
use App\Http\Controllers\StafKeuangan\PembayaranController as StafPembayaran;

use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboard;
use App\Http\Controllers\Kepsek\PembayaranController as KepsekPembayaran;
use App\Http\Controllers\Auth\RegisterController;


/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : view('landing');
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Auth::routes([
    'register' => false
]);

/*
|--------------------------------------------------------------------------
| Register Staf Keuangan Pertama
|--------------------------------------------------------------------------
*/

Route::get('/register-staf', [RegisterController::class, 'showRegistrationForm'])
    ->name('register.staf');

Route::post('/register-staf', [RegisterController::class, 'register'])
    ->name('register.staf.store');

/*
|--------------------------------------------------------------------------
| Setelah Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | Redirect laporan berdasarkan role
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', function () {

        switch(auth()->user()->role) {

            case 'stafkeuangan':
                return redirect()->route('stafkeuangan.laporan.index');

            case 'kepsek':
                return redirect()->route('kepsek.laporan.index');

            default:
                abort(403);

        }

    })->name('laporan.index');

});


/*
|--------------------------------------------------------------------------
| STAF KEUANGAN
|--------------------------------------------------------------------------
*/

Route::prefix('stafkeuangan')
    ->middleware(['auth','role:stafkeuangan'])
    ->name('stafkeuangan.')
    ->group(function () {

        /*
        | Dashboard
        */

        Route::get('/dashboard', [StafDashboard::class, 'index'])
            ->name('dashboard');


        /*
        | KELAS
        */

        Route::get('/kelas', [KelasController::class, 'index'])
            ->name('kelas.index');

        Route::get('/kelas/create', [KelasController::class, 'create'])
            ->name('kelas.create');

        Route::post('/kelas', [KelasController::class, 'store'])
            ->name('kelas.store');

        Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])
            ->name('kelas.destroy');


        /*
        | SISWA PER KELAS
        */

        Route::get('/kelas/{kelas}/siswa', [SiswaController::class, 'byKelas'])
            ->name('kelas.siswa.index');


        /*
        | SISWA
        */

        Route::get('/siswa', [SiswaController::class, 'index'])
            ->name('siswa.index');

        Route::get('/siswa/create', [SiswaController::class, 'create'])
            ->name('siswa.create');

        Route::post('/siswa', [SiswaController::class, 'store'])
            ->name('siswa.store');


        /*
        | TAGIHAN
        */

        Route::get('/tagihan', [TagihanController::class, 'index'])
            ->name('tagihan.index');


        /*
        | TAHUN AJAR
        */

        Route::get('/tahun_ajar', [TahunAjarController::class, 'index'])
            ->name('tahunajar.index');

        Route::get('/tahun_ajar/create', [TahunAjarController::class, 'create'])
            ->name('tahunajar.create');

        Route::post('/tahun_ajar', [TahunAjarController::class, 'store'])
            ->name('tahunajar.store');

        Route::post('/tahun_ajar/{id}/aktifkan', [TahunAjarController::class, 'aktifkan'])
            ->name('tahunajar.aktifkan');

        Route::delete('/tahun_ajar/{id}', [TahunAjarController::class, 'destroy'])
            ->name('tahunajar.destroy');


        /*
        | PEMBAYARAN
        */

        Route::get('/pembayaran', [StafPembayaran::class, 'index'])
            ->name('pembayaran.index');

        Route::get('/pembayaran/create/{tagihan}', [StafPembayaran::class, 'create'])
            ->name('pembayaran.create');

        Route::post('/pembayaran', [StafPembayaran::class, 'store'])
            ->name('pembayaran.store');

        Route::get('/pembayaran/{pembayaran}', [StafPembayaran::class, 'show'])
            ->name('pembayaran.show');

        // RESTFUL: ubah POST menjadi PATCH
        Route::patch('/pembayaran/{pembayaran}/batalkan', [StafPembayaran::class, 'batalkan'])
            ->name('pembayaran.batalkan');

        Route::get('/pembayaran/{pembayaran}/cetak', [StafPembayaran::class, 'cetak'])
            ->name('pembayaran.cetak');

        Route::get('/pembayaran/{pembayaran}/audit',
            [\App\Http\Controllers\StafKeuangan\PembayaranAuditController::class, 'index'])
            ->name('pembayaran.audit');


        /*
        | LAPORAN
        */

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/semester', [LaporanController::class, 'laporanSemester'])
            ->name('laporan.semester');

        Route::get('/laporan/cetak', [LaporanController::class, 'cetakPdf'])
            ->name('laporan.cetak');

        Route::get('/laporan/tunggakan', [LaporanController::class, 'tunggakan'])
            ->name('laporan.tunggakan');

        Route::get('/laporan/tunggakan/cetak', [LaporanController::class, 'cetakTunggakan'])
            ->name('laporan.cetakTunggakan');

        /*
        | USER MANAGEMENT
        */
        Route::resource('user', UserController::class);

        Route::put('user/{user}/reset-password', [UserController::class,'resetPassword'])
            ->name('user.reset');

});


/*
|--------------------------------------------------------------------------
| KEPSEK (READ ONLY)
|--------------------------------------------------------------------------
*/

Route::prefix('kepsek')
    ->middleware(['auth','role:kepsek'])
    ->name('kepsek.')
    ->group(function () {

        Route::get('/dashboard', [KepsekDashboard::class, 'index'])
            ->name('dashboard');

        Route::get('/siswa', [SiswaController::class, 'index'])
            ->name('siswa.index');

        Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])
            ->name('siswa.show');

        Route::get('/pembayaran', [KepsekPembayaran::class, 'index'])
            ->name('pembayaran.index');

        Route::get('/pembayaran/{pembayaran}', [KepsekPembayaran::class, 'show'])
            ->name('pembayaran.show');

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/semester', [LaporanController::class, 'laporanSemester'])
            ->name('laporan.semester');

        Route::get('/laporan/cetak', [LaporanController::class, 'cetakPdf'])
            ->name('laporan.cetak');

        Route::get('/laporan/tunggakan', [LaporanController::class, 'tunggakan'])
            ->name('laporan.tunggakan');

        Route::get('/laporan/tunggakan/cetak', [LaporanController::class, 'cetakTunggakan'])
            ->name('laporan.cetakTunggakan');

});