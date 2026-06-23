<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Absensi;

class CekRaporController extends Controller
{
    public function cariSiswa(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
        ]);

        // 2. Cari Siswa (Cek NIS & Nama mirip)
        $siswa = Siswa::where('nis', $request->nis)
                        ->where('nama', 'LIKE', '%' . $request->nama . '%')
                        ->first();

        // 3. Jika Tidak Ketemu
        if (!$siswa) {
            return redirect('/')->with('status', 'Maaf, Data Siswa tidak ditemukan. Cek NIS dan Nama.');
        }

        // 4. Jika Ketemu, Siapkan Data Rapor
        $data = $this->siapkanDataRapor($siswa);

        // 5. Tampilkan View
        return view('rapor.public_view', $data);
    }

    private function siapkanDataRapor($siswa)
    {
        $mapels = [
            'Tema 1', 'Tema 2', 'Tema 3', 'Tema 4',
            'Tema 5', 'Tema 6', 'Tema 7', 'Tema 8',
            'Pendidikan Agama', 'Matematika', 'PJOK', 'Seni Budaya', 'B. Inggris',
            'STS', 'SAS'
        ];

        // Ambil Nilai
        $nilai_raw = Nilai::where('siswa_id', $siswa->id)->get();
        $data_nilai = [];

        foreach ($nilai_raw as $row) {
            if ($row->mapel == 'STS') $nilai_fix = $row->uts;
            elseif ($row->mapel == 'SAS') $nilai_fix = $row->uas;
            else $nilai_fix = $row->tugas;
            
            $data_nilai[$row->mapel] = $nilai_fix;
        }

        // Ambil Absensi
        $absensi_raw = Absensi::where('siswa_id', $siswa->id)->get();
        $absen = ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpha' => 0];

        foreach ($absensi_raw as $row) {
            if (isset($absen[$row->status])) {
                $absen[$row->status]++;
            }
        }

        return [
            'siswa' => $siswa,
            'mapels' => $mapels,
            'nilai' => $data_nilai,
            'absen' => $absen
        ];
    }
}