<?php

namespace App\Http\Controllers\StafKeuangan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;

class PembayaranAuditController extends Controller
{
    public function index($pembayaranId)
    {
        $pembayaran = Pembayaran::with(['audit.user'])
            ->findOrFail($pembayaranId);

        return view('stafkeuangan.pembayaran.audit', compact('pembayaran'));
    }
}