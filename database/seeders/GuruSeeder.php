<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'budi@sekolah.id'],
            [
                'name' => 'Budi Utomo',
                'password' => Hash::make('1234'),
                'role' => 'guru',
            ]
        );

        User::updateOrCreate(
            ['email' => 'tri@sekolah.id'],
            [
                'name' => 'Tri Kusumawati',
                'password' => Hash::make('4321'),
                'role' => 'guru',
            ]
        );
    }
}
