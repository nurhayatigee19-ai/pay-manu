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
     * =======================
     * GLOBAL LIST SISWA
     * =======================
     */
    public function index(Request $request)
    {
        $tahunAjar = TahunAjar::where('aktif', 1)->first();

        $listKelas = Kelas::orderBy('nama_kelas')->get();

        $query = Siswa::with(['kelas', 'tagihanSiswa']);

        // =============================
        // 🔍 FILTER NAMA / NIS (FIX)
        // =============================
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                ->orWhere('nis', 'like', "%{$request->search}%");
            });
        }

        // =============================
        // 📚 FILTER KELAS (FIX)
        // =============================
        if ($request->kelas) {
            $query->where('kelas_id', $request->kelas);
        }

        // =============================
        // PAGINATE DULU
        // =============================
        $siswa = $query->paginate(10)->withQueryString();

        // =============================
        // HITUNG TAGIHAN
        // =============================
        $siswa->getCollection()->transform(function ($s) use ($tahunAjar) {

            $tagihan = collect();

            if ($tahunAjar) {
                $tagihan = $s->tagihanSiswa
                    ->where('tahun_ajar_id', $tahunAjar->id);
            }

            $s->tagihan = $tagihan->first();

            $totalTagihan = $tagihan->sum('nominal_tagihan');
            $totalBayar   = $tagihan->sum('total_dibayar');

            $s->total_tagihan = $totalTagihan;
            $s->total_bayar   = $totalBayar;
            $s->sisa_tagihan  = max($totalTagihan - $totalBayar, 0);
            $s->status        = $s->sisa_tagihan == 0 ? 'Lunas' : 'Belum Lunas';

            return $s;
        });

        // =============================
        // ❗ FILTER STATUS (VERSI BENAR)
        // =============================
        if ($request->status) {

            $filtered = $siswa->getCollection()->filter(function ($s) use ($request) {

                if ($request->status == 'lunas') {
                    return $s->status == 'Lunas';
                }

                if ($request->status == 'belum') {
                    return $s->status == 'Belum Lunas';
                }

                return true;
            });

            $siswa->setCollection($filtered->values());
        }

        // =============================
        // DETAIL KELAS
        // =============================
        $kelasDetail = $request->kelas 
            ? Kelas::find($request->kelas)
            : null;

        return view('stafkeuangan.siswa.index', [
            'siswa'       => $siswa,
            'listKelas'   => $listKelas,
            'kelasDetail' => $kelasDetail,
        ]);
    }

    /**
     * =======================
     * CREATE SISWA
     * =======================
     */
    public function create()
    {
        $listKelas = Kelas::orderBy('nama_kelas')->get();
        return view('stafkeuangan.siswa.create', compact('listKelas'));
    }

    /**
     * =======================
     * STORE SISWA + TAGIHAN
     * =======================
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis'      => 'required|unique:siswa,nis',
            'nama'     => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = Siswa::create([
            'nis'      => $request->nis,
            'nama'     => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        $tahunAjar = TahunAjar::where('aktif', 1)->first();

        if ($tahunAjar) {
            TagihanSiswa::create([
                'siswa_id'       => $siswa->id,
                'tahun_ajar_id'  => $tahunAjar->id,
                'semester'       => 'ganjil',
                'nominal_tagihan'=> 600000,
                'total_tagihan'  => 600000,
            ]);

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
     * =======================
     * LIST SISWA PER KELAS
     * =======================
     */
    public function byKelas(Kelas $kelas)
    {
        $tahunAjar = TahunAjar::where('aktif', 1)->firstOrFail();

        $siswa = Siswa::with('kelas')
            ->where('kelas_id', $kelas->id)
            ->paginate(10)
            ->withQueryString();

        $siswa->getCollection()->transform(function ($s) use ($tahunAjar) {

            $tagihan = $s->tagihanSiswa()
                ->where('tahun_ajar_id', $tahunAjar->id)
                ->get();

            $totalTagihan = $tagihan->sum('nominal_tagihan');
            $totalBayar   = $tagihan->sum('total_dibayar');

            $s->total_tagihan = $totalTagihan;
            $s->total_bayar   = $totalBayar;
            $s->sisa_tagihan  = max($totalTagihan - $totalBayar, 0);
            $s->status        = $s->sisa_tagihan == 0 ? 'Lunas' : 'Belum Lunas';

            return $s;
        });

        return view('stafkeuangan.siswa.index', [
            'kelasDetail' => $kelas,  // <- kini konsisten
            'siswa'       => $siswa,
            'listKelas'   => Kelas::all(),
        ]);
    }

    /**
     * =======================
     * DETAIL SISWA
     * =======================
     */
    public function show($id)
    {
        $siswa = \App\Models\Siswa::with([
            'kelas',
            'tagihanSiswa.tahunAjar',
            'tagihanSiswa.pembayaran'
        ])->findOrFail($id);

        $totalTagihan = $siswa->tagihanSiswa->sum('total_tagihan');

        $totalBayar = $siswa->tagihanSiswa->sum(function ($t) {
            return $t->pembayaran
                ->where('status', \App\Domain\Pembayaran\PembayaranStatus::VALID)
                ->sum('jumlah');
        });

        $sisaTagihan = $totalTagihan - $totalBayar;

        $status = $sisaTagihan <= 0 ? 'Lunas' : 'Belum Lunas';

        $riwayat = $siswa->tagihanSiswa
            ->flatMap(function ($t) {
                return $t->pembayaran;
            })
            ->where('status', \App\Domain\Pembayaran\PembayaranStatus::VALID)
            ->sortByDesc('tanggal_bayar');

        return view('stafkeuangan.siswa.show', compact(
            'siswa',
            'totalTagihan',
            'totalBayar',
            'sisaTagihan',
            'status',
            'riwayat'
        ));
    }

    /**
     * =======================
     * ⭐ EDIT SISWA (FORM)
     * =======================
     * Menampilkan form edit data siswa
     */
    public function edit($id)
    {
        // Ambil data siswa (termasuk yang sudah dihapus jika pakai soft delete)
        $siswa = Siswa::findOrFail($id); 
        
        // Ambil daftar kelas untuk dropdown
        $listKelas = Kelas::orderBy('nama_kelas')->get();
        
        return view('stafkeuangan.siswa.edit', compact('siswa', 'listKelas'));
    }

    /**
     * =======================
     * ⭐ UPDATE SISWA
     * =======================
     * Memproses update data siswa
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nis'      => 'required|unique:siswa,nis,' . $id,
            'nama'     => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Cari data siswa
        $siswa = Siswa::withTrashed()->findOrFail($id);
        
        // Update data
        $siswa->update([
            'nis'      => $request->nis,
            'nama'     => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()
            ->route('stafkeuangan.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * =======================
     * ⭐ DESTROY (HAPUS SISWA)
     * =======================
     * Menghapus data siswa (soft delete jika pakai SoftDeletes)
     */
    public function destroy($id)
    {
        // Cari data siswa
        $siswa = Siswa::findOrFail($id);
        
        // Cek apakah siswa memiliki tagihan
        $hasTagihan = $siswa->tagihanSiswa()->count() > 0;
        
        if ($hasTagihan) {
            return redirect()
                ->route('stafkeuangan.siswa.index')
                ->with('error', 'Siswa memiliki tagihan, tidak bisa dihapus!');
        }
        
        // Hapus data (soft delete jika pakai SoftDeletes)
        $siswa->delete();
        
        return redirect()
            ->route('stafkeuangan.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }

    /**
     * =======================
     * ⭐ RESTORE SISWA (OPSIONAL)
     * =======================
     * Memulihkan data siswa yang sudah dihapus (soft delete)
     */
    public function restore($id)
    {
        $siswa = Siswa::withTrashed()->findOrFail($id);
        
        if (!$siswa->trashed()) {
            return redirect()
                ->route('stafkeuangan.siswa.index')
                ->with('warning', 'Data siswa tidak dalam keadaan terhapus');
        }
        
        $siswa->restore();
        
        return redirect()
            ->route('stafkeuangan.siswa.index')
            ->with('success', 'Data siswa berhasil dipulihkan');
    }
}