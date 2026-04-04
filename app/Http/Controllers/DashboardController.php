<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function stafKeuangan()
    {
        $jumlahSiswa = Siswa::count();

        $pembayaranHariIni = Pembayaran::whereDate('tanggal_bayar', Carbon::today())
            ->sum('jumlah');

        $pembayaranBulanIni = Pembayaran::whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah');

        $pembayaranTahunIni = Pembayaran::whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah');

        $riwayatPembayaran = Pembayaran::with('siswa')
            ->latest('tanggal_bayar')
            ->limit(10)
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
