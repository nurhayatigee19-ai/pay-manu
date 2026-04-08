<?php

namespace App\Http\Controllers\StafKeuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TagihanSiswa;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use DomainException;

class PembayaranController extends Controller
{
    // ===============================
    // LIST SEMUA PEMBAYARAN
    // ===============================
    public function index(Request $request)
    {
        $query = Pembayaran::with([
            'tagihanSiswa.siswa.kelas',
            'tagihanSiswa.tahunAjar'
        ]);

        // 🔍 SEARCH (nama / NIS)
        if ($request->search) {
            $query->whereHas('tagihanSiswa.siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // 📅 FILTER TANGGAL
        if ($request->tanggal) {
            $query->whereDate('tanggal_bayar', $request->tanggal);
        }

        // ✅ PAGINATION (WAJIB)
        $pembayaran = $query
            ->where('status', 'valid') // ✅ FILTER UTAMA
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // 🔥 TRANSFORM (BIAR BISA PAKAI DI BLADE)
        $pembayaran->getCollection()->transform(function ($p) {

            $siswa = $p->tagihanSiswa->siswa ?? null;
            $kelas = $siswa->kelas ?? null;

            $p->nis = $siswa->nis ?? '-';
            $p->nama_siswa = $siswa->nama ?? '-';
            $p->nama_kelas = $kelas->nama_kelas ?? '-';

            return $p;
        });

        // ambil info header
        $kelas = null;
        $tahunAjaran = null;

        if ($pembayaran->isNotEmpty()) {
            $tagihan = $pembayaran->first()->tagihanSiswa;

            if ($tagihan) {
                $kelas = $tagihan->siswa->kelas ?? null;
                $tahunAjaran = $tagihan->tahunAjar->tahun ?? null;
            }
        }

        return view('stafkeuangan.pembayaran.index', compact(
            'pembayaran',
            'kelas',
            'tahunAjaran'
        ));
    }

    // ===============================
    // FORM INPUT PEMBAYARAN
    // ===============================
    public function create($tagihan)
    {
        $tagihan = TagihanSiswa::with('siswa.kelas')
            ->findOrFail($tagihan);

        $siswa = $tagihan->siswa;
        $kelas = $siswa->kelas;

        $totalTagihan = $tagihan->nominal_tagihan;
        $totalDibayar = $tagihan->total_dibayar;
        $sisaTagihan  = $tagihan->sisa_tagihan;

        return view('stafkeuangan.pembayaran.create', compact(
            'tagihan', 'siswa', 'kelas', 'totalTagihan', 'totalDibayar', 'sisaTagihan'
        ));
    }

    // ===============================
    // SIMPAN PEMBAYARAN (WEB)
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'tagihan_siswa_id' => ['required', 'exists:tagihan_siswa,id'],
            'jumlah' => ['required','numeric','min:1'],
            'keterangan' => ['nullable','string','max:255'],
            'idempotency_key' => ['nullable','string']
        ]);

        // CEK DOUBLE TRANSAKSI
        if (Pembayaran::where('idempotency_key', $request->idempotency_key)->exists()) {
            return back()->with('error','Transaksi sudah diproses sebelumnya.');
        }

        $tagihan = TagihanSiswa::findOrFail($request->tagihan_siswa_id);

        try {

            $tagihan->bayar(
                (float) $request->jumlah,
                $request->keterangan,
                $request->idempotency_key
            );

            return redirect()
                ->route('stafkeuangan.pembayaran.index')
                ->with('success','Pembayaran berhasil');

        } catch (\DomainException $e) {

            return back()
                ->withInput()
                ->with('error',$e->getMessage());

        }
    }

    // ===============================
    // SIMPAN PEMBAYARAN (API JSON)
    // ===============================
    public function storeApi(Request $request)
    {
        $request->validate([
            'tagihan_siswa_id' => 'required|exists:tagihan_siswa,id',
            'jumlah'           => 'required|numeric|min:1',
            'keterangan'       => 'nullable|string|max:255',
        ]);

        $tagihan = TagihanSiswa::findOrFail($request->tagihan_siswa_id);
        $jumlah = (int) $request->jumlah;
        $keterangan = $request->keterangan;
        $userId = $request->user()->id;

        $pembayaran = DB::transaction(function () use ($tagihan, $jumlah, $keterangan, $userId) {
            
            $tunggakan = $keterangan !== null;

            if (!$tagihan->tahunAjar->aktif && !$tunggakan) {
                throw new DomainException('Tahun ajar tidak aktif');
            }

            if ($jumlah > $tagihan->sisa_tagihan) {
                throw new DomainException('Pembayaran melebihi sisa tagihan');
            }

            $pembayaran = $tagihan->pembayaran()->create([
                'jumlah'        => $jumlah,
                'keterangan'    => $keterangan,
                'status'        => 'valid',
                'tanggal_bayar' => now(),
                'user_id'       => $userId,
                'tunggakan'     => $tunggakan,
            ]);

            return $pembayaran;
        });

        return response()->json([
            'success' => true,
            'data'    => $pembayaran
        ], 200);
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with('tagihanSiswa.siswa.kelas')
            ->findOrFail($id);

        $tagihan = $pembayaran->tagihanSiswa;
        $siswa   = $tagihan->siswa;
        $kelas   = $siswa->kelas;

        $totalTagihan = $tagihan->nominal_tagihan;
        $totalDibayar = $tagihan->total_dibayar;
        $sisaTagihan  = $tagihan->sisa_tagihan;

        $riwayat = $tagihan->pembayaran()->latest()->get();

        return view('stafkeuangan.pembayaran.show', compact(
            'pembayaran',
            'siswa',
            'kelas',
            'totalTagihan',
            'totalDibayar',
            'sisaTagihan',
            'riwayat'
        ));
    }

    // ===============================
    // BATALKAN PEMBAYARAN
    // ===============================
    public function batalkan(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'alasan' => ['required', 'string', 'min:5'],
        ]);

        try {
            $pembayaran->batalkan($request->alasan);

            return redirect()
                ->route('stafkeuangan.pembayaran.index')
                ->with('success', 'Pembayaran berhasil dibatalkan');

        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ===============================
    // CETAK BUKTI PEMBAYARAN
    // ===============================
    public function cetak(Pembayaran $pembayaran)
    {
        $tagihan = $pembayaran->tagihanSiswa;

        if (!$tagihan || !$tagihan->siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        $siswa = $tagihan->siswa;
        $kelas = $siswa->kelas;

        // ----------- FIX DISINI -------------
        $semester   = ucfirst($tagihan->semester); // Ganjil / Genap
        $tahunAjar  = $tagihan->tahunAjar->tahun ?? '-';
        $periode    = "$semester $tahunAjar";      // contoh: Ganjil 2025/2026
        // -------------------------------------

        $totalTagihan = $tagihan->nominal_tagihan;
        $totalDibayar = $tagihan->total_dibayar;
        $sisaTagihan  = $tagihan->sisa_tagihan;

        $pdf = Pdf::loadView('stafkeuangan.pembayaran.cetak', [
            'pembayaran'   => $pembayaran,
            'siswa'        => $siswa,
            'kelas'        => $kelas,
            'totalTagihan' => $totalTagihan,
            'totalDibayar' => $totalDibayar,
            'sisaTagihan'  => $sisaTagihan,

            // kirim variabel periode
            'periode'      => $periode
        ]);

        return $pdf->stream('Bukti_Pembayaran_'.$siswa->nis.'_'.$pembayaran->id.'.pdf');
    }
}