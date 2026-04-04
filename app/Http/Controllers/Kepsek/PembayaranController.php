<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::latest()->get();
        return view('kepsek.pembayaran.index', compact('pembayaran'));
    }

    public function show(Pembayaran $pembayaran)
    {
        return view('kepsek.pembayaran.show', compact('pembayaran'));
    }
}