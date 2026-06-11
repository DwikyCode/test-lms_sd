<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::Create([
            'nis' => '1020621',
            'nama' => 'Muhammad Hadhie',
            'kelas' => $id_kelas = 1
        ]);

        Siswa::Create([
            'nis' => '1020622',
            'nama' => 'Muhammad Naufal',
            'kelas' => $id_kelas = 2
        ]);

        Siswa::Create([
            'nis' => '1020623',
            'nama' => 'Dwiky Rahman',
            'kelas' => $id_kelas = 2
        ]);
    }
}