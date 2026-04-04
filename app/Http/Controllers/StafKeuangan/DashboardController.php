<?php

namespace App\Http\Controllers\StafKeuangan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSiswa = Siswa::count();

        $pembayaranHariIni = Pembayaran::whereDate('tanggal_bayar', today())
            ->sum('jumlah');

        $pembayaranBulanIni = Pembayaran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah');

        $pembayaranTahunIni = Pembayaran::whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah');

        $riwayatPembayaran = Pembayaran::latest()
            ->take(5)
            ->get();

        return view('stafkeuangan.dashboard', compact(
            'jumlahSiswa',
            'pembayaranHariIni',
            'pembayaranBulanIni',
            'pembayaranTahunIni',
            'riwayatPembayaran'
        ));
    }
}
