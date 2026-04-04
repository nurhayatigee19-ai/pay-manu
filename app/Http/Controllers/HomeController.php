<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Pembayaran;

class HomeController extends Controller
{
    /**
     * Redirect setelah login
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'stafkeuangan') {
            return redirect()->route('stafkeuangan.dashboard');
        }

        if ($user->role === 'kepsek') {
            return redirect()->route('kepsek.dashboard');
        }

        abort(403, 'Role tidak dikenali');
    }

    /**
     * Dashboard staf keuangan (FULL DATA)
     */
    public function stafkeuangan()
    {
        $jumlahSiswa = Siswa::count();

        $pembayaranHariIni = Pembayaran::whereDate(
            'tanggal_bayar',
            today()
        )->sum('jumlah');

        $pembayaranBulanIni = Pembayaran::whereMonth(
            'tanggal_bayar',
            now()->month
        )->whereYear(
            'tanggal_bayar',
            now()->year
        )->sum('jumlah');

        $pembayaranTahunIni = Pembayaran::whereYear(
            'tanggal_bayar',
            now()->year
        )->sum('jumlah');

        $riwayatPembayaran = Pembayaran::with('siswa')
            ->orderBy('tanggal_bayar', 'desc')
            ->limit(5)
            ->get();

        return view('stafkeuangan.dashboard', compact(
            'jumlahSiswa',
            'pembayaranHariIni',
            'pembayaranBulanIni',
            'pembayaranTahunIni',
            'riwayatPembayaran'
        ));
    }


    /**
     * Dashboard kepsek (RINGKAS – HANYA MELIHAT)
     */
    public function kepsek()
    {
        $jumlahSiswa = Siswa::count();

        $pembayaranBulanIni = Pembayaran::whereMonth(
            'tanggal_bayar',
            now()->month
        )->whereYear(
            'tanggal_bayar',
            now()->year
        )->sum('jumlah');

        return view('kepsek.dashboard', compact(
            'jumlahSiswa',
            'pembayaranBulanIni'
        ));
    }
}
