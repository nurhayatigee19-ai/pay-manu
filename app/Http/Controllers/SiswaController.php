<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\TagihanSiswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * ===============================
     * HALAMAN SISWA GLOBAL (READ ONLY)
     * route: stafkeuangan.siswa.index
     * ===============================
     */
    public function index()
    {
        $tahunAjar = TahunAjar::where('aktif', 1)->first();

        $siswa = Siswa::with('kelas')
            ->get()
            ->map(function ($s) use ($tahunAjar) {

                $tagihan = null;

                if ($tahunAjar) {
                    $tagihan = $s->tagihanSiswa()
                        ->where('tahun_ajar_id', $tahunAjar->id)
                        ->get();
                }

                $totalTagihan = $tagihan->sum('nominal_tagihan');
                $totalBayar = $tagihan->sum(function ($t) {
                    return $t->total_dibayar;
                });

                // ATTRIBUTE VIRTUAL (TIDAK DISIMPAN DI DB)
                $s->total_tagihan = $totalTagihan;
                $s->total_bayar   = $totalBayar;
                $s->sisa_tagihan  = max($totalTagihan - $totalBayar, 0);
                $s->status        = $s->sisa_tagihan == 0 ? 'Lunas' : 'Belum Lunas';

                return $s;
            });

        return view('stafkeuangan.siswa.index', compact('siswa'));
    }

    /**
     * ===============================
     * FORM TAMBAH SISWA
     * route: stafkeuangan.siswa.create
     * ===============================
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('stafkeuangan.siswa.create', compact('kelas'));
    }

    /**
     * ===============================
     * SIMPAN SISWA BARU
     * route: stafkeuangan.siswa.store
     * ===============================
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis'      => 'required|unique:siswa,nis',
            'nama'     => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // simpan siswa
        $siswa = Siswa::create([
            'nis'      => $request->nis,
            'nama'     => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        // ambil tahun ajar aktif
        $tahunAjar = TahunAjar::where('aktif', 1)->first();

        if ($tahunAjar) {

            // semester ganjil
            TagihanSiswa::create([
                'siswa_id'       => $siswa->id,
                'tahun_ajar_id'  => $tahunAjar->id,
                'semester'       => 'ganjil',
                'nominal_tagihan'=> 600000,
                'total_tagihan'  => 600000,
            ]);

            // semester genap
            TagihanSiswa::create([
                'siswa_id'       => $siswa->id,
                'tahun_ajar_id'  => $tahunAjar->id,
                'semester'       => 'genap',
                'nominal_tagihan'=> 600000,
                'total_tagihan'  => 600000,
            ]);
        }

        return redirect()
            ->route('stafkeuangan.siswa.index')
            ->with('success', 'Siswa dan tagihan berhasil dibuat');
    }

    /**
     * ===============================
     * SISWA PER KELAS (INTI SISTEM)
     * route: stafkeuangan.kelas.siswa
     * ===============================
     */
    public function byKelas(Kelas $kelas)
    {
        $tahunAjar = TahunAjar::where('aktif', 1)->firstOrFail();

        $siswa = Siswa::with('kelas')
            ->where('kelas_id', $kelas->id)
            ->get()
            ->map(function ($s) use ($tahunAjar) {

                $tagihan = $s->tagihanSiswa()
                    ->where('tahun_ajar_id', $tahunAjar->id)
                    ->get();

                $totalTagihan = $tagihan->sum('nominal_tagihan');
                $totalBayar   = $tagihan->sum('total_dibayar');

                // simpan tagihan ke objek siswa (penting untuk blade)
                $s->tagihan = $tagihan->first();

                $s->total_tagihan = $totalTagihan;
                $s->total_bayar   = $totalBayar;
                $s->sisa_tagihan  = max($totalTagihan - $totalBayar, 0);
                $s->status        = $s->sisa_tagihan == 0 ? 'Lunas' : 'Belum Lunas';

                return $s;
            });

        return view('stafkeuangan.siswa.index', compact('kelas', 'siswa'));
    }
}