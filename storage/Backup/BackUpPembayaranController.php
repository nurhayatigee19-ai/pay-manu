<?php

namespace App\Http\Controllers\Backup;

use App\Http\Controllers\Controller;
use App\Models\TagihanSiswa;
use Illuminate\Http\Request;
use Throwable;

class BackUpPembayaranController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'tagihan_siswa_id' => ['required', 'exists:tagihan_siswa,id'],
            'jumlah'           => ['required', 'numeric', 'min:1'],
        ]);

        try {
            $tagihan = TagihanSiswa::findOrFail($data['tagihan_siswa_id']);

            $forceFail = (bool) config('app.simulasi_gagal_pembayaran', false);

            $pembayaran = $tagihan->prosesPembayaran(
                (int) $data['jumlah'],
                'Pembayaran SPP (backup)',
                $forceFail
            );

            return response()->json([
                'message'    => 'Pembayaran berhasil (backup)',
                'pembayaran' => $pembayaran,
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses pembayaran (backup)',
            ], 500);
        }
    }
}