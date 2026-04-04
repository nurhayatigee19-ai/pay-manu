<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kelas')->insert([
            ['nama_kelas' => 'X IPA 1'],
            ['nama_kelas' => 'XI IPA 1'],
            ['nama_kelas' => 'XII IPA 1'],
        ]);
    }
}
