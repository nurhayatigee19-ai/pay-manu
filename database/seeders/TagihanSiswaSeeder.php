<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\TagihanSiswa;

class TagihanSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = TahunAjar::where('aktif', true)->first();

        if (!$tahun) {
            throw new Exception('Tahun ajar aktif tidak ditemukan');
        }

        $siswa = Siswa::where('aktif', true)->get();

        foreach ($siswa as $s) {

            foreach (['ganjil','genap'] as $semester) {

                TagihanSiswa::firstOrCreate(
                    [
                        'siswa_id' => $s->id,
                        'tahun_ajar_id' => $tahun->id,
                        'semester' => $semester
                    ],
                    [
                        'nominal_tagihan' => 600000
                    ]
                );

            }
        }
    }
}