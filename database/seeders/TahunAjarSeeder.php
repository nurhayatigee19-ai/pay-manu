<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjar;

class TahunAjarSeeder extends Seeder
{
    public function run(): void
    {
        TahunAjar::updateOrCreate(
            ['tahun' => '2025/2026'],
            ['aktif' => true]
        );

        // Pastikan hanya SATU tahun ajar aktif
        TahunAjar::where('tahun', '!=', '2025/2026')
            ->update(['aktif' => false]);
    }
}