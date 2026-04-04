<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\TagihanSiswa;

class PembayaranRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function jumlah_wajib_diisi()
    {
        $user = User::factory()->create([
            'role' => 'stafkeuangan',
        ]);

        $tagihan = TagihanSiswa::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/stafkeuangan/pembayaran', [
                'tagihan_siswa_id' => $tagihan->id,
                // jumlah sengaja tidak diisi
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('jumlah');
    }

    /** @test */
    public function jumlah_harus_angka()
    {
        $user = User::factory()->create([
            'role' => 'stafkeuangan',
        ]);

        $tagihan = TagihanSiswa::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/stafkeuangan/pembayaran', [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah' => 'abc',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('jumlah');
    }

    /** @test */
    public function jumlah_tidak_boleh_nol_atau_negatif()
    {
        $user = User::factory()->create([
            'role' => 'stafkeuangan',
        ]);

        $tagihan = TagihanSiswa::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/stafkeuangan/pembayaran', [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah' => 0,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('jumlah');

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/stafkeuangan/pembayaran', [
                'tagihan_siswa_id' => $tagihan->id,
                'jumlah' => -100,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('jumlah');
    }
}