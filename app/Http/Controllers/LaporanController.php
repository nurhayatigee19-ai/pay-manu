<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Helper menentukan path view berdasarkan role
    |--------------------------------------------------------------------------
    */
    private function getViewPath(string $view, bool $isCetak = false)
    {
        $role = auth()->user()->role;

        $base = $role === 'kepsek'
            ? 'kepsek.laporan'
            : 'stafkeuangan.laporan';

        if ($isCetak) {
            return "$base.cetak.$view";
        }

        return "$base.$view";
    }


    /*
    |--------------------------------------------------------------------------
    | Filter query pembayaran
    |--------------------------------------------------------------------------
    */
    private function filterPembayaran($query, $kelasId = null, $tahunAjarId = null)
    {
        if ($kelasId) {
            $query->whereHas('tagihanSiswa.siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        if ($tahunAjarId) {
            $query->whereHas('tagihanSiswa', function ($q) use ($tahunAjarId) {
                $q->where('tahun_ajar_id', $tahunAjarId);
            });
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman laporan utama
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tahunAjarId = $request->tahun_ajar_id;
        $nis = $request->nis;
        $nama = $request->nama;

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $query = Pembayaran::query()
            ->with(['tagihanSiswa.siswa.kelas'])
            ->where('status', \App\Domain\Pembayaran\PembayaranStatus::VALID)
            ->whereHas('tagihanSiswa.siswa');

        if ($nis) {
            $query->whereHas('tagihanSiswa.siswa', function ($q) use ($nis) {
                $q->where('nis', 'like', "%$nis%");
            });
        }

        if ($nama) {
            $query->whereHas('tagihanSiswa.siswa', function ($q) use ($nama) {
                $q->where('nama', 'like', "%$nama%");
            });
        }

        if ($kelasId) {
            $query->whereHas('tagihanSiswa.siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        if ($tahunAjarId) {
            $query->whereHas('tagihanSiswa', function ($q) use ($tahunAjarId) {
                $q->where('tahun_ajar_id', $tahunAjarId);
            });
        }

        $pembayaran = $query->get();

        $sudahBayar = $pembayaran->count();
        $totalBayar = $pembayaran->sum('jumlah');

        return view(
            $this->getViewPath('index'),
            compact(
                'pembayaran',
                'kelas',
                'kelasId',
                'tahunAjarId',
                'sudahBayar',
                'totalBayar'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Cetak laporan pembayaran
    |--------------------------------------------------------------------------
    */
    public function cetakPdf(Request $request)
    {
        $siswa = Siswa::with(['kelas','tagihanSiswa.pembayaran'])
            ->when($request->kelas_id, function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            })
            ->get()
            ->map(function ($s) {

                $tagihan = $s->tagihanSiswa->sum('total_tagihan');

                $dibayar = $s->tagihanSiswa->sum(function ($t) {
                    return $t->total_dibayar;
                });

                return (object)[
                    'nis' => $s->nis,
                    'nama' => $s->nama,
                    'kelas' => $s->kelas,
                    'total_tagihan' => $tagihan,
                    'total_dibayar' => $dibayar,
                    'sisa' => $tagihan - $dibayar
                ];
            });

        $pdf = PDF::loadView(
            $this->getViewPath('laporan_siswa', true),
            compact('siswa')
        );

        return $pdf->download('laporan_pembayaran_siswa.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman laporan tunggakan
    |--------------------------------------------------------------------------
    */
    public function tunggakan(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tahunAjarId = $request->tahun_ajar_id;

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $query = \App\Models\TagihanSiswa::with(['siswa.kelas','tahunAjar'])
            ->withSum([
                'pembayaran as total_dibayar' => function ($q) {
                    $q->where('status', \App\Domain\Pembayaran\PembayaranStatus::VALID);
                }
            ], 'jumlah');

        if ($kelasId) {
            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        if ($tahunAjarId) {
            $query->where('tahun_ajar_id', $tahunAjarId);
        }

        $tagihan = $query->get()->filter(function ($item) {
            return $item->total_tagihan > $item->total_dibayar;
        });

        return view(
            $this->getViewPath('tunggakan'),
            compact('tagihan','kelas','kelasId','tahunAjarId')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Cetak laporan tunggakan PDF
    |--------------------------------------------------------------------------
    */
    public function cetakTunggakan(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tahunAjarId = $request->tahun_ajar_id;

        $query = \App\Models\TagihanSiswa::with(['siswa.kelas','tahunAjar'])
            ->withSum([
                'pembayaran as total_dibayar' => function ($q) {
                    $q->where('status', \App\Domain\Pembayaran\PembayaranStatus::VALID);
                }
            ], 'jumlah');

        if ($kelasId) {
            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        if ($tahunAjarId) {
            $query->where('tahun_ajar_id', $tahunAjarId);
        }

        $data = $query->get()->filter(function ($item) {
            return $item->total_tagihan > $item->total_dibayar;
        });

        $pdf = PDF::loadView(
            $this->getViewPath('tunggakan', true),
            compact('data')
        );

        return $pdf->download('laporan_tunggakan.pdf');
    }
}