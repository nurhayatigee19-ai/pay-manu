<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\Siswa;
use App\Models\TagihanSiswa;

class KelasController extends Controller
{
    public function index()
    {
        // Ambil tahun ajar aktif (tidak error jika kosong)
        $tahunAjarAktif = TahunAjar::where('aktif', 1)->first();

        $kelas = Kelas::with(['siswa.tagihanSiswa.pembayaranValid'])
            ->withCount('siswa')
            ->get()
            ->map(function ($k) use ($tahunAjarAktif) {

                // Jika belum ada tahun ajar aktif
                if (!$tahunAjarAktif) {
                    $k->belum_lunas = 0;
                    return $k;
                }

                $belumLunas = $k->siswa->filter(function ($s) use ($tahunAjarAktif) {

                    $tagihan = $s->tagihanSiswa
                        ->where('tahun_ajar_id', $tahunAjarAktif->id);

                    $totalTagihan = $tagihan->sum('nominal_tagihan');

                    $totalDibayar = $tagihan->sum(function ($t) {
                        return $t->pembayaranValid->sum('jumlah');
                    });

                    return $totalDibayar < $totalTagihan;
                })->count();

                $k->belum_lunas = $belumLunas;

                return $k;
            });

        return view('stafkeuangan.kelas.index', compact('kelas', 'tahunAjarAktif'));
    }

    public function siswa($kelas_id)
    {
        $siswa = Siswa::where('kelas_id', $kelas_id)->get();

        foreach ($siswa as $s) {
            $s->tagihan = TagihanSiswa::where('siswa_id', $s->id)->first();
        }

        return view('stafkeuangan.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('stafkeuangan.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100|unique:kelas,nama_kelas',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('stafkeuangan.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function destroy(Kelas $kelas)
    {
        if ($kelas->siswa()->count() > 0) {
            return back()->with('error', 'Kelas tidak bisa dihapus karena sudah memiliki siswa');
        }

        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus');
    }
}