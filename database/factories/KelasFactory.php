<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_kelas' => $this->faker->randomElement([
                'X IPA 1',
                'X IPA 2',
                'XI IPS 1',
                'XI IPS 2',
                'XII IPA 1',
                'XII IPS 1',
            ]),
        ];
    }

    /**
     * Helper: kelas dengan nama tertentu
     */
    public function nama(string $nama)
    {
        return $this->state([
            'nama_kelas' => $nama,
        ]);
    }
}