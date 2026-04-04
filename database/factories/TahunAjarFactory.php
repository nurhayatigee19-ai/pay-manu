<?php

namespace Database\Factories;

use App\Models\TahunAjar;
use Illuminate\Database\Eloquent\Factories\Factory;

class TahunAjarFactory extends Factory
{
    protected $model = TahunAjar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tahun' => $this->faker->unique()->regexify('20[2-9][0-9]/20[2-9][0-9]'),
            'aktif' => true,
        ];
    }

    /**
     * Set tahun ajar menjadi aktif
     */
    public function aktif()
    {
        return $this->state([
            'aktif' => true,
        ]);
    }

    /**
     * Set tahun ajar menjadi non-aktif
     */
    public function nonAktif()
    {
        return $this->state([
            'aktif' => false,
        ]);
    }
}