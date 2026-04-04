<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TagihanSiswa;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\User;
use DomainException;

class TagihanSiswaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper: login sebagai staf keuangan
     */
    private function loginStaf()
    {
        $user = User::factory()->create(['role' => 'stafkeuangan']);
        $this->actingAs($user);
    }

    /** @test */
    public function bisa_bayar_normal()
    {
        $this->loginStaf();

        $tagihan = TagihanSiswa::factory()->create([
            'total_tagihan' => 120000,
        ]);

        $pembayaran = $tagihan->prosesPembayaran(40000);

        $this->assertEquals(40000, $tagihan->fresh()->total_dibayar);
        $this->assertFalse($tagihan->fresh()->sisa_tagihan == 0);
        $this->assertEquals('Belum Lunas', $tagihan->fresh()->status);
    }

    /** @test */
    public function bisa_melunasi_tagihan()
    {
        $this->loginStaf();

        $tagihan = TagihanSiswa::factory()->create([
            'total_tagihan' => 120000,
        ]);

        $tagihan->prosesPembayaran(120000);

        $this->assertEquals(120000, $tagihan->fresh()->total_dibayar);
        $this->assertEquals(0, $tagihan->fresh()->sisa_tagihan);
        $this->assertEquals('Lunas', $tagihan->fresh()->status);
    }

    /** @test */
    public function tidak_boleh_overpay()
    {
        $this->expectException(DomainException::class);

        $this->loginStaf();

        $tagihan = TagihanSiswa::factory()->create([
            'total_tagihan' => 120000,
        ]);

        $tagihan->prosesPembayaran(130000);
    }

    /** @test */
    public function tidak_boleh_bayar_setelah_lunas()
    {
        $this->expectException(DomainException::class);

        $this->loginStaf();

        $tagihan = TagihanSiswa::factory()->create([
            'total_tagihan' => 120000,
        ]);

        $tagihan->prosesPembayaran(120000);
        $tagihan->prosesPembayaran(1);
    }

    /** @test */
    public function tidak_boleh_bayar_nol_atau_negatif()
    {
        $this->expectException(DomainException::class);

        $this->loginStaf();

        $siswa = Siswa::factory()->create();
        $tahun = TahunAjar::factory()->create();

        $tagihan = TagihanSiswa::create([
            'siswa_id' => $siswa->id,
            'tahun_ajar_id' => $tahun->id,
            'total_tagihan' => 120000,
        ]);

        $tagihan->prosesPembayaran(0);
    }

    /** @test */
    public function tidak_boleh_bayar_jika_tahun_ajar_non_aktif()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Tahun ajar tidak aktif');

        $this->loginStaf();

        $tahunAjar = TahunAjar::factory()->create(['aktif' => false]);
        $siswa = Siswa::factory()->create();

        $tagihan = TagihanSiswa::create([
            'siswa_id' => $siswa->id,
            'tahun_ajar_id' => $tahunAjar->id,
            'total_tagihan' => 120000,
        ]);

        $tagihan->prosesPembayaran(30000);
    }

    /** @test */
    public function boleh_bayar_tunggakan_jika_ada_tahun_ajar_aktif()
    {
        $this->loginStaf();

        // Tahun ajar lama non-aktif
        $tahunLama = TahunAjar::factory()->create(['aktif' => false]);
        // Tahun ajar baru aktif
        $tahunAktif = TahunAjar::factory()->create(['aktif' => true]);
        $siswa = Siswa::factory()->create();

        // Tagihan milik tahun lama
        $tagihan = TagihanSiswa::create([
            'siswa_id' => $siswa->id,
            'tahun_ajar_id' => $tahunLama->id,
            'total_tagihan' => 120000,
        ]);

        $pembayaran = $tagihan->prosesPembayaran(30000, 'Bayar tunggakan');

        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'jumlah' => 30000,
        ]);

        $this->assertEquals(90000, $tagihan->fresh()->sisa_tagihan);
        $this->assertTrue($pembayaran->tunggakan);
    }

    /** @test */
    public function pembayaran_tunggakan_ditandai_sebagai_tunggakan()
    {
        $this->loginStaf();

        $tahunLama = TahunAjar::factory()->create(['aktif' => false]);
        $tahunAktif = TahunAjar::factory()->create(['aktif' => true]);
        $siswa = Siswa::factory()->create();

        $tagihan = TagihanSiswa::create([
            'siswa_id' => $siswa->id,
            'tahun_ajar_id' => $tahunLama->id,
            'total_tagihan' => 120000,
        ]);

        $pembayaran = $tagihan->prosesPembayaran(20000, 'Bayar tunggakan');

        $this->assertTrue($pembayaran->tunggakan);
    }

    /** @test */
    public function pembayaran_batal_akan_update_total_dan_sisa_tagihan()
    {
        $this->loginStaf();

        $tagihan = TagihanSiswa::factory()->create(['total_tagihan' => 100000]);
        $pembayaran = $tagihan->prosesPembayaran(60000);

        $this->assertEquals(60000, $tagihan->fresh()->total_dibayar);

        $pembayaran->batalkan('salah input');

        $this->assertEquals(0, $tagihan->fresh()->total_dibayar);
        $this->assertEquals(100000, $tagihan->fresh()->sisa_tagihan);
        $this->assertEquals('Belum Lunas', $tagihan->fresh()->status);
    }
}