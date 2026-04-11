<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\TagihanSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PembayaranConcurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_double_request_tidak_boleh_double_payment()
    {
        // =========================
        // SETUP DATA
        // =========================

        $user = User::factory()->create();

        $this->actingAs($user);
        $this->withoutMiddleware();

        $kelas = Kelas::factory()->create();   

        $siswa = Siswa::factory()->create([
            'kelas_id' => $kelas->id
        ]);

        // pastikan hanya 1 tahun ajar aktif
        TahunAjar::query()->delete();

        $tahunAjar = TahunAjar::create([
            'tahun' => '2025/2026',
            'aktif' => true
        ]);

        // 🔥 FIX UTAMA: gunakan field yang benar
        $tagihan = TagihanSiswa::create([
            'siswa_id' => $siswa->id,
            'tahun_ajar_id' => $tahunAjar->id,
            'semester' => 'ganjil',
            'total_tagihan' => 100000,
            'total_dibayar' => 0,
            'lunas' => false,
        ]);

        // =========================
        // SIMULASI 2 REQUEST
        // =========================

        $payload = [
            'tagihan_siswa_id' => $tagihan->id,
            'jumlah' => 100000,
            'idempotency_key' => 'TEST-123'
        ];

        // REQUEST PERTAMA (HARUS SUKSES)
        $response1 = $this->post(route('stafkeuangan.pembayaran.store'), $payload);

        // 🔥 VALIDASI WAJIB
        $response1->assertRedirect(); // pastikan tidak error
        $response1->assertSessionHasNoErrors();

        // 🔥 pastikan benar-benar masuk DB
        $this->assertDatabaseCount('pembayaran', 1);

        // REQUEST KEDUA (HARUS DITOLAK / DIABAIKAN)
        $response2 = $this->post(route('stafkeuangan.pembayaran.store'), $payload);

        // =========================
        // ASSERT
        // =========================

        // 🔥 tetap hanya 1 (tidak double)
        $this->assertDatabaseCount('pembayaran', 1);

        // cek tagihan
        $tagihan->refresh();

        $this->assertEquals(100000, $tagihan->total_dibayar);
        $this->assertTrue($tagihan->lunas);
    }
}