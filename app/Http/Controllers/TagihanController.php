<?php

namespace App\Http\Controllers;

use App\Models\TagihanSiswa;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihan = TagihanSiswa::with(['siswa.kelas'])
            ->orderBy('id','desc')
            ->get();

        return view('stafkeuangan.tagihan.index', compact('tagihan'));
    }
}