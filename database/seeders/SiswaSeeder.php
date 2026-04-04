<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswa')->insert([
            ['nama' => 'Budi Santoso', 'nis' => '12345', 'kelas_id' => 1, 'jumlah_tagihan' => '250000', 'status' => 'Lunas'],
            ['nama' => 'Ani Lestari', 'nis' => '12346', 'kelas_id' => 1, 'jumlah_tagihan' => '350000', 'status' => 'Lunas'],
            ['nama' => 'Joko Prasetyo', 'nis' => '12347', 'kelas_id' => 2, 'jumlah_tagihan' => '250000', 'status' => 'Lunas'],
        ]);
    }
}
