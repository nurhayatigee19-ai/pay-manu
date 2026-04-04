<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pembayaran;
use App\Models\TagihanSiswa;
use App\Models\User;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition()
    {
        // Ambil tagihan dan user otomatis
        $tagihan = TagihanSiswa::factory()->create();
        $user = User::factory()->state(['role' => 'stafkeuangan'])->create();

        return [
            'tagihan_siswa_id' => $tagihan->id,
            'user_id'          => $user->id,
            'jumlah'           => 200000,
            'status'           => 'valid',
            'tunggakan'        => false,
            'tanggal_bayar'    => now(),
            'keterangan'       => null,
            'kode_transaksi'   => 'PAY-' . date('Ymd') . '-' . strtoupper(substr($this->faker->unique()->bothify('?????'),0,5)),
        ];
    }

    /**
     * State untuk pembayaran batal
     */
    public function batal()
    {
        return $this->state(function () {
            return [
                'status' => 'batal',
                'keterangan' => 'dibatalkan pada test',
            ];
        });
    }

    /**
     * State untuk pembayaran tunggakan
     */
    public function tunggakan()
    {
        return $this->state(function () {
            return [
                'tunggakan' => true,
                'keterangan' => 'Bayar tunggakan',
            ];
        });
    }
}