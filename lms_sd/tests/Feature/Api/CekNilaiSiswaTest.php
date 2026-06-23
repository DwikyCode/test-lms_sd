<?php

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('siswa dapat cek nilai dengan data benar', function () {

    // Buat siswa
    $siswa = Siswa::create([
        'nis' => '12345',
        'nama' => 'Hadi',
        'kelas' => '5A',
    ]);

    // Buat nilai siswa
    Nilai::create([
        'kelas' => '5A',
        'siswa_id' => $siswa->id,
        'mapel' => 'Matematika',
        'tugas1' => 90,
        'tugas2' => 85,
        'tugas3' => 88,
        'tugas4' => 87,
        'kuis1' => 80,
        'kuis2' => 82,
        'tugas' => 88,
        'uts' => 90,
        'uas' => 95,
    ]);

    $response = $this->postJson('/api/cek-nilai-siswa', [
        'nis' => '12345',
        'nama' => 'Hadi',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Data ditemukan',
        ])
        ->assertJsonPath('data.siswa.nis', '12345')
        ->assertJsonPath('data.siswa.nama', 'Hadi');
});

test('cek nilai gagal jika siswa tidak ditemukan', function () {

    $response = $this->postJson('/api/cek-nilai-siswa', [
        'nis' => '99999',
        'nama' => 'Tidak Ada',
    ]);

    $response->assertStatus(404)
        ->assertJson([
            'status' => false,
            'message' => 'Data siswa tidak ditemukan. Periksa NIS dan Nama.',
        ]);
});

test('cek nilai gagal jika input kosong', function () {

    $response = $this->postJson('/api/cek-nilai-siswa', []);

    $response->assertStatus(400)
        ->assertJson([
            'status' => false,
            'message' => 'NIS dan Nama wajib diisi',
        ]);
});

test('response memuat relasi nilai siswa', function () {

    $siswa = Siswa::create([
        'nis' => '11111',
        'nama' => 'Budi',
        'kelas' => '6A',
    ]);

    Nilai::create([
        'kelas' => '6A',
        'siswa_id' => $siswa->id,
        'mapel' => 'IPA',
        'tugas1' => 90,
        'tugas2' => 91,
        'tugas3' => 92,
        'tugas4' => 93,
        'kuis1' => 94,
        'kuis2' => 95,
        'tugas' => 90,
        'uts' => 89,
        'uas' => 96,
    ]);

    $response = $this->postJson('/api/cek-nilai-siswa', [
        'nis' => '11111',
        'nama' => 'Budi',
    ]);

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data.siswa.nilai')
        ->assertJsonPath(
            'data.siswa.nilai.0.mapel',
            'IPA'
        );
});