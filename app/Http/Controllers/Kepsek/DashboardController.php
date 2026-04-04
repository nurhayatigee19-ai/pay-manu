<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\TagihanSiswa;

class DashboardController extends Controller
{
    public function index()
    {
        // jumlah siswa
        $jumlahSiswa = Siswa::count();

        // total pembayaran bulan ini
        $pembayaranBulanIni = Pembayaran::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('jumlah');


        // total tunggakan
        $totalTunggakan = TagihanSiswa::selectRaw('SUM(total_tagihan - total_dibayar) as tunggakan')
            ->value('tunggakan');

        return view('kepsek.dashboard', compact(
            'jumlahSiswa',
            'pembayaranBulanIni',
            'totalTunggakan'
        ));
    }
}
