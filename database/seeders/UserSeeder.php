<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Staf Keuangan',
            'email' => 'stafkeuangan@gmail.com',
            'password' => Hash::make('password'), // password = "password"
            'role' => 'stafkeuangan',
        ]);
    }
}
