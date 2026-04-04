<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\TagihanSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PembayaranAtomicityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function jumlah_wajib_diisi()
    {
        $user = User::factory()->create(['role' => 'stafkeuangan']);

        $siswa = Siswa::factory()->create();
        $tahunAjar = TahunAjar::factory()->create(['aktif' => true]);
        $tagihan = TagihanSiswa::create([
            'siswa_id'      => $siswa->id,
            'tahun_ajar_id' => $tahunAjar->id,
            'total_tagihan' => 500_000,
        ]);

        $this->actingAs($user) // 🔹 HARUS LOGIN
            ->postJson(route('stafkeuangan.pembayaran.store'), [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah'           => null, // test validasi wajib
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function jumlah_harus_angka()
    {
        $user = User::factory()->create(['role' => 'stafkeuangan']);

        $siswa = Siswa::factory()->create();
        $tahunAjar = TahunAjar::factory()->create(['aktif' => true]);
        $tagihan = TagihanSiswa::create([
            'siswa_id'      => $siswa->id,
            'tahun_ajar_id' => $tahunAjar->id,
            'total_tagihan' => 500_000,
        ]);

        $this->actingAs($user)
            ->postJson(route('stafkeuangan.pembayaran.store'), [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah'           => 'abc', // bukan angka
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function jumlah_tidak_boleh_nol_atau_negatif()
    {
        $user = User::factory()->create(['role' => 'stafkeuangan']);

        $siswa = Siswa::factory()->create();
        $tahunAjar = TahunAjar::factory()->create(['aktif' => true]);
        $tagihan = TagihanSiswa::create([
            'siswa_id'      => $siswa->id,
            'tahun_ajar_id' => $tahunAjar->id,
            'total_tagihan' => 500_000,
        ]);

        $this->actingAs($user)
            ->postJson(route('stafkeuangan.pembayaran.store'), [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah'           => 0, // nol
            ])
            ->assertStatus(422);

        $this->actingAs($user)
            ->postJson(route('stafkeuangan.pembayaran.store'), [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah'           => -100, // negatif
            ])
            ->assertStatus(422);
    }
}