<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TagihanSiswa;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\User;
use DomainException;

class PembayaranTest extends TestCase
{
    use RefreshDatabase;

    private function buatTagihan($nominal = 100000)
    {
        $tahun = TahunAjar::factory()->create(['aktif' => true]);
        $siswa = Siswa::factory()->create();

        return TagihanSiswa::create([
            'siswa_id' => $siswa->id,
            'tahun_ajar_id' => $tahun->id,
            'semester' => 'ganjil',
            'total_tagihan' => $nominal,
        ]);
    }

    /** @test */
    public function pembayaran_mengurangi_sisa_tagihan()
    {
        $user = User::factory()->create(['role' => 'stafkeuangan']);
        $this->actingAs($user);

        $tagihan = $this->buatTagihan(100_000);
        $tagihan->prosesPembayaran(40_000);

        $this->assertEquals(40_000, $tagihan->fresh()->total_dibayar);
        $this->assertEquals(60_000, $tagihan->fresh()->sisa_tagihan);
    }

    /** @test */
    public function pembayaran_tidak_boleh_melebihi_sisa_tagihan()
    {
        $this->expectException(DomainException::class);

        $user = User::factory()->create(['role' => 'stafkeuangan']);
        $this->actingAs($user);

        $tagihan = $this->buatTagihan(50_000);
        $tagihan->prosesPembayaran(60_000);
    }

    /** @test */
    public function pembayaran_batal_tidak_dihitung_dalam_total()
    {
        $user = User::factory()->create(['role' => 'stafkeuangan']);
        $this->actingAs($user);

        $tagihan = $this->buatTagihan(100_000);
        $pembayaran = $tagihan->prosesPembayaran(50_000);

        $this->assertEquals(50_000, $tagihan->fresh()->total_dibayar);

        // Batalkan pembayaran
        $pembayaran->batalkan('salah input');

        $this->assertEquals(0, $tagihan->fresh()->total_dibayar);
    }
}