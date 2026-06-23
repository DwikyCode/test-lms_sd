<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdf;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});


it('Path 1 Store: Sistem melakukan updateOrCreate pada data absensi siswa dan melanjutkan iterasi', function () {
    $siswa1 = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);
    $siswa2 = Siswa::create(['nis' => '002', 'nama' => 'Ani', 'kelas' => '1']);
    $tanggal = date('Y-m-d');

    $this->actingAs($this->user)
        ->post('/kelas/1/absensi', [
            'tanggal' => $tanggal,
            'absensi' => [
                $siswa1->id => 'Hadir',
                $siswa2->id => 'Sakit'
            ]
        ]);

    $this->assertDatabaseHas('absensis', ['siswa_id' => $siswa1->id, 'status' => 'Hadir']);
    $this->assertDatabaseHas('absensis', ['siswa_id' => $siswa2->id, 'status' => 'Sakit']);
});

it('Path 2 Store: Sistem menampilkan pesan sukses dan melakukan redirect ke halaman sebelumnya', function () {
    $siswa = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);

    $response = $this->actingAs($this->user)
        ->post('/kelas/1/absensi', [
            'tanggal' => date('Y-m-d'),
            'absensi' => [$siswa->id => 'Hadir']
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Absensi berhasil disimpan!');
});


it('Path 1 DownloadPdf: Sistem melakukan redirect kembali dan menampilkan pesan Belum ada data absensi', function () {

    $response = $this->actingAs($this->user)
        ->get('/kelas/1/absensi/pdf?tanggal=2026-01-01');

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Belum ada data absensi.');
});

it('Path 2 DownloadPdf: Sistem membuat file PDF absensi dan mengunduh file', function () {
    $siswa = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);
    Absensi::create([
        'kelas' => '1',
        'siswa_id' => $siswa->id,
        'tanggal' => date('Y-m-d'),
        'status' => 'Hadir'
    ]);

    $pdfMock = Mockery::mock(DomPdf::class);
    $pdfMock->shouldReceive('download')
        ->once()
        ->with('Absensi_Kelas_1.pdf')
        ->andReturn(response('PDF', 200));

    Pdf::shouldReceive('loadView')->once()->andReturn($pdfMock);

    $response = $this->actingAs($this->user)
        ->get('/kelas/1/absensi/pdf');

    $response->assertOk();
});