<?php

namespace App\Http\Controllers;

use App\Models\TahunAjar;
use Illuminate\Http\Request;

class TahunAjarController extends Controller
{
    public function index()
    {
        $tahunAjar = TahunAjar::orderBy('tahun', 'desc')->get();
        return view('stafkeuangan.tahun_ajar.index', compact('tahunAjar'));
    }

    public function create()
    {
        return view('stafkeuangan.tahun_ajar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:9'
        ]);

        TahunAjar::create([
            'tahun' => $request->tahun,
            'aktif' => false
        ]);

        return redirect()->route('stafkeuangan.tahunajar.index')
            ->with('success', 'Tahun ajar berhasil ditambahkan');
    }

    public function aktifkan($id)
    {
        // nonaktifkan semua tahun ajar
        TahunAjar::query()->update([
            'aktif' => false
        ]);

        // aktifkan tahun ajar yang dipilih
        $tahun = TahunAjar::findOrFail($id);
        $tahun->update([
            'aktif' => true
        ]);

        // =========================
        // GENERATE TAGIHAN OTOMATIS
        // =========================
        $tahun->generateTagihan();

        return redirect()
            ->route('stafkeuangan.tahunajar.index')
            ->with('success', 'Tahun ajar berhasil diaktifkan dan tagihan dibuat');
    }

    public function destroy($id)
    {
        TahunAjar::findOrFail($id)->delete();

        return back()->with('success', 'Tahun ajar berhasil dihapus');
    }
}