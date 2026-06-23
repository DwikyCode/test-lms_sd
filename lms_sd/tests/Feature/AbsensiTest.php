<?php

use App\Models\User;
use App\Models\Siswa;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdf;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {

    $this->user = User::factory()->create();
    $this->tanggal_hari_ini = now()->format('Y-m-d');
});

describe('Halaman Absensi', function () {
    
    it('menampilkan halaman absensi kelas', function () {
        $response = $this->actingAs($this->user)->get('/kelas/1/absensi');

        $response->assertOk()
            ->assertViewIs('absensi.absensi')
            ->assertViewHas('id_kelas', '1')
            ->assertViewHas('tanggal', $this->tanggal_hari_ini);
    });

    it('hanya menampilkan siswa dari kelas yang dipilih', function () {
        Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);
        Siswa::create(['nis' => '002', 'nama' => 'Ani', 'kelas' => '2']);

        $response = $this->actingAs($this->user)->get('/kelas/1/absensi');

        $response->assertOk()
            ->assertSee('Budi')
            ->assertDontSee('Ani')
            ->assertViewHas('siswas', function ($siswas) {
                return $siswas->count() === 1
                    && $siswas->first()->nama === 'Budi'
                    && $siswas->first()->kelas === '1';
            });
    });

    it('tetap menampilkan halaman saat kelas belum memiliki siswa', function () {
        $response = $this->actingAs($this->user)->get('/kelas/6/absensi');

        $response->assertOk()
            ->assertSee('Belum ada siswa di kelas ini.')
            ->assertViewHas('siswas', fn ($siswas) => $siswas->isEmpty());
    });
});

describe('Simpan Absensi', function () {

    it('menyimpan data absensi dengan berhasil', function () {
        $siswa = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);

        $response = $this->actingAs($this->user)->post('/kelas/1/absensi', [
            'tanggal' => $this->tanggal_hari_ini,
            'absensi' => [$siswa->id => 'Hadir']
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Absensi berhasil disimpan!');

        $this->assertDatabaseHas('absensis', [
            'kelas'    => '1',
            'siswa_id' => $siswa->id,
            'tanggal'  => $this->tanggal_hari_ini,
            'status'   => 'Hadir',
        ]);
    });

    it('menolak penyimpanan ketika data absensi kosong', function () {
        $response = $this->actingAs($this->user)->post('/kelas/1/absensi', [
            'tanggal' => $this->tanggal_hari_ini,
        ]);

        $response->assertSessionHasErrors('absensi');
    });

    it('memperbarui absensi lama tanpa membuat data ganda', function () {
        $siswa = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);

        $this->actingAs($this->user)->post('/kelas/1/absensi', [
            'tanggal' => $this->tanggal_hari_ini,
            'absensi' => [$siswa->id => 'Hadir']
        ]);

        $this->actingAs($this->user)->post('/kelas/1/absensi', [
            'tanggal' => $this->tanggal_hari_ini,
            'absensi' => [$siswa->id => 'Izin']
        ]);

        $this->assertDatabaseCount('absensis', 1);
        $this->assertDatabaseHas('absensis', [
            'siswa_id' => $siswa->id,
            'tanggal'  => $this->tanggal_hari_ini,
            'status'   => 'Izin',
        ]);
    });

    it('menyimpan absensi untuk beberapa siswa sekaligus', function () {
        $s1 = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);
        $s2 = Siswa::create(['nis' => '002', 'nama' => 'Ani', 'kelas' => '1']);

        $this->actingAs($this->user)->post('/kelas/1/absensi', [
            'tanggal' => $this->tanggal_hari_ini,
            'absensi' => [
                $s1->id => 'Hadir',
                $s2->id => 'Izin'
            ]
        ]);

        $this->assertDatabaseCount('absensis', 2);
    });
});

describe('Unduh PDF Absensi', function () {

    it('mengembalikan pesan error ketika pdf tidak memiliki data absensi', function () {
        $response = $this->actingAs($this->user)->get('/kelas/1/absensi/pdf');

        $response->assertRedirect()
            ->assertSessionHas('error', 'Belum ada data absensi.');
    });

    it('mengunduh pdf absensi ketika data tersedia', function () {
        $siswa = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);
        
        Absensi::create([
            'kelas'    => '1',
            'siswa_id' => $siswa->id,
            'tanggal'  => $this->tanggal_hari_ini,
            'status'   => 'Hadir'
        ]);

        $pdfMock = Mockery::mock(DomPdf::class);
        $pdfMock->shouldReceive('download')
            ->once()
            ->with('Absensi_Kelas_1.pdf')
            ->andReturn(response('PDF absensi', 200));

        Pdf::shouldReceive('loadView')
            ->once()
            ->with('absensi.pdf', Mockery::on(function ($data) use ($siswa) {
                return $data['kelas'] === '1'
                    && $data['tanggal'] === $this->tanggal_hari_ini
                    && $data['data_absensi']->count() === 1
                    && $data['data_absensi']->first()->siswa_id === $siswa->id;
            }))
            ->andReturn($pdfMock);

        $response = $this->actingAs($this->user)->get('/kelas/1/absensi/pdf');

        $response->assertOk();
    });

    it('memfilter data absensi pdf berdasarkan tanggal yang dikirim', function () {
        $siswa = Siswa::create(['nis' => '001', 'nama' => 'Budi', 'kelas' => '1']);
        

        Absensi::create(['kelas' => '1', 'siswa_id' => $siswa->id, 'tanggal' => '2026-06-20', 'status' => 'Hadir']);

        Absensi::create(['kelas' => '1', 'siswa_id' => $siswa->id, 'tanggal' => '2026-01-01', 'status' => 'Izin']);

        $pdfMock = Mockery::mock(DomPdf::class);
        $pdfMock->shouldReceive('download')->once()->andReturn(response('PDF absensi', 200));

        Pdf::shouldReceive('loadView')
            ->once()
            ->with('absensi.pdf', Mockery::on(function ($data) {
                return $data['tanggal'] === '2026-01-01'; // Memastikan PDF merender tanggal yang direquest
            }))
            ->andReturn($pdfMock);

        $response = $this->actingAs($this->user)->get('/kelas/1/absensi/pdf?tanggal=2026-01-01');

        $response->assertOk();
    });
});