<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with([
            'tagihanSiswa.siswa.kelas'
        ])->where('status', 'valid');

        if ($request->nis) {
            $query->whereHas('tagihanSiswa.siswa', function ($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->nis . '%');
            });
        }

        if ($request->nama) {
            $query->whereHas('tagihanSiswa.siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        $pembayaran = $query
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $totalBayar = $pembayaran->sum('jumlah');

        return view('kepsek.laporan.index', compact(
            'pembayaran',
            'totalBayar'
        ));
    }
}