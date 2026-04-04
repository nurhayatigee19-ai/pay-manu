<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\TagihanSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PembayaranEndToEndTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pembayaran_valid_menyimpan_data_dan_mengurangi_tagihan()
    {
        // Tahun ajar aktif
        $tahunAjar = TahunAjar::factory()->create(['aktif' => true]);

        // Siswa
        $siswa = Siswa::factory()->create();

        // Tagihan
        $tagihan = TagihanSiswa::create([
            'siswa_id'      => $siswa->id,
            'tahun_ajar_id' => $tahunAjar->id,
            'total_tagihan' => 1_200_000,
        ]);

        // Login user staf keuangan
        $user = User::factory()->create(['role' => 'stafkeuangan']);
        $this->actingAs($user);

        // Kirim request pembayaran
        $response = $this->post(
            route('stafkeuangan.pembayaran.store'),
            [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah'           => 200_000,
            ]
        );

        // Jika route redirect, ikut redirect
        $response->assertStatus(302);

        // Assert data tersimpan
        $this->assertDatabaseHas('pembayaran', [
            'tagihan_siswa_id' => $tagihan->id,
            'jumlah'           => 200_000,
            'user_id'          => $user->id,
        ]);

        // Assert sisa tagihan berkurang
        $this->assertEquals(1_000_000, $tagihan->fresh()->sisa_tagihan);
    }
}