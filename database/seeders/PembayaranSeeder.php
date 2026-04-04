<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pembayaran')->insert([
            [
                'siswa_id' => 1,
                'bulan' => 'Januari',
                'jumlah' => 200000,
                'status' => 'lunas',
                'tanggal_bayar' => Carbon::now(),
            ],
            [
                'siswa_id' => 2,
                'bulan' => 'Januari',
                'jumlah' => 200000,
                'status' => 'belum',
                'tanggal_bayar' => null,
            ],
            [
                'siswa_id' => 3,
                'bulan' => 'Februari',
                'jumlah' => 200000,
                'status' => 'lunas',
                'tanggal_bayar' => Carbon::now(),
            ],
        ]);
    }
}
