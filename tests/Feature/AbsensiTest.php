<?php

use App\Models\User;
use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can store absensi successfully', function () {

    $user = User::factory()->create();

    $siswa = Siswa::create([
        'nis' => '12345',
        'nama' => 'Hadi',
        'kelas' => '1A'
    ]);

    $response = $this->actingAs($user)
        ->post('/kelas/1A/absensi', [
            'tanggal' => now()->format('Y-m-d'),
            'absensi' => [
                $siswa->id => 'Hadir'
            ]
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('absensis', [
        'siswa_id' => $siswa->id,
        'kelas' => '1A',
        'status' => 'Hadir'
    ]);
});

test('absensi validation fails when empty', function () {

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/kelas/1A/absensi', []);

    $response->assertSessionHasErrors([
        'absensi'
    ]);
});

test('absensi can be updated on same date', function () {

    $user = User::factory()->create();

    $siswa = Siswa::create([
        'nis' => '54321',
        'nama' => 'Budi',
        'kelas' => '1A'
    ]);

    $tanggal = now()->format('Y-m-d');

    Absensi::create([
        'kelas' => '1A',
        'siswa_id' => $siswa->id,
        'tanggal' => $tanggal,
        'status' => 'Hadir'
    ]);

    $this->actingAs($user)
        ->post('/kelas/1A/absensi', [
            'tanggal' => $tanggal,
            'absensi' => [
                $siswa->id => 'Izin'
            ]
        ]);

    $this->assertDatabaseHas('absensis', [
        'siswa_id' => $siswa->id,
        'tanggal' => $tanggal,
        'status' => 'Izin'
    ]);
});

test('download pdf absensi successfully', function () {

    $user = User::factory()->create();

    $siswa = Siswa::create([
        'nis' => '99999',
        'nama' => 'Siti',
        'kelas' => '1A'
    ]);

    Absensi::create([
        'kelas' => '1A',
        'siswa_id' => $siswa->id,
        'tanggal' => now()->format('Y-m-d'),
        'status' => 'Hadir'
    ]);

    $response = $this->actingAs($user)
        ->get('/kelas/1A/absensi/pdf');

    $response->assertStatus(200);
});

test('download pdf fails when no absensi data', function () {

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/kelas/1A/absensi/pdf');

    $response->assertRedirect();
});