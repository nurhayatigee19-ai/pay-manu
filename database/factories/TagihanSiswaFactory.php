<?php

namespace Database\Factories;

use App\Models\TagihanSiswa;
use App\Models\Siswa;
use App\Models\TahunAjar;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagihanSiswaFactory extends Factory
{
    protected $model = TagihanSiswa::class;

    public function definition()
    {
        // Buat siswa baru
        $siswa = Siswa::factory()->create();

        // Buat tahun ajar baru, default aktif
        $tahun = TahunAjar::factory()->create(['aktif' => true]);

        // Tentukan nominal tagihan secara acak
        $nominal = $this->faker->numberBetween(100_000, 1_500_000);

        return [
            'siswa_id'       => $siswa->id,
            'tahun_ajar_id'  => $tahun->id,
            'semester'       => 'ganjil', // default ganjil, bisa diubah dengan method genap() atau ganjil()
            'nominal_tagihan'=> $nominal,
            'total_tagihan'  => $nominal,   // otomatis sama dengan nominal
            'total_dibayar'  => 0,
            'lunas'          => false
        ];
    }

    /**
     * Override total_tagihan jika ingin set custom
     */
    public function withTotal(int $total)
    {
        return $this->state(function () use ($total) {
            return [
                'total_tagihan' => $total,
            ];
        });
    }

    /**
     * Set tagihan khusus semester genap
     */
    public function genap()
    {
        return $this->state([
            'semester' => 'genap',
        ]);
    }

    /**
     * Set tagihan khusus semester ganjil
     */
    public function ganjil()
    {
        return $this->state([
            'semester' => 'ganjil',
        ]);
    }
}