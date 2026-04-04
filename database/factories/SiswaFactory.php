<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nis' => $this->faker->unique()->numerify('SISWA-####'),
            'nama' => $this->faker->name(),
            'kelas_id' => Kelas::factory(),
        ];
    }

    /**
     * Set siswa ke kelas tertentu
     */
    public function inKelas($kelasId)
    {
        return $this->state([
            'kelas_id' => $kelasId,
        ]);
    }
}