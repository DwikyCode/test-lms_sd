<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\Mapel; // <--- JANGAN LUPA IMPORT MODEL MAPEL
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RapotController extends Controller
{
    // HAPUS function getMapels() karena sudah tidak dipakai

    private function getDataAbsensi($id_kelas) {
        $data_raw = Absensi::where('kelas', $id_kelas)->get();
        $rekap = [];

        foreach ($data_raw as $row) {
            $sid = $row->siswa_id;
            if (!isset($rekap[$sid])) {
                $rekap[$sid] = ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpha' => 0];
            }
            if(isset($rekap[$sid][$row->status])) {
                $rekap[$sid][$row->status]++;
            }
        }
        return $rekap;
    }

    private function getDataNilai($id_kelas) {
        $nilai_raw = Nilai::where('kelas', $id_kelas)->get();
        $rekap = [];

        foreach ($nilai_raw as $row) {
            if ($row->mapel == 'STS') {
                $nilai_fix = $row->uts;
            } elseif ($row->mapel == 'SAS') {
                $nilai_fix = $row->uas;
            } else {
                $nilai_fix = $row->tugas;
            }
            // Simpan nilai berdasarkan ID Siswa dan Nama Mapel
            $rekap[$row->siswa_id][$row->mapel] = $nilai_fix;
        }
        return $rekap;
    }

    public function index($id_kelas)
    {
        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('nama', 'asc')->get();
        
        // PERBAIKAN: Ambil nama mapel dari database
        // pluck('nama') mengambil kolom 'nama' saja
        // toArray() mengubahnya menjadi array string sederhana ['Tema 1', 'Matematika', ...]
        $mapels = Mapel::where('id_kelas', $id_kelas)->pluck('nama')->toArray();

        return view('rapot.rapor', [ 
            'id_kelas'     => $id_kelas,
            'siswas'       => $siswas,
            'mapels'       => $mapels, // Kirim data dari DB
            'data_nilai'   => $this->getDataNilai($id_kelas),
            'data_absensi' => $this->getDataAbsensi($id_kelas)
        ]);
    }

    public function cetakPDF($id_kelas)
    {
        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('nama', 'asc')->get();

        // PERBAIKAN: Ambil nama mapel dari database juga untuk PDF
        $mapels = Mapel::where('id_kelas', $id_kelas)->pluck('nama')->toArray();

        $pdf = Pdf::loadView('rapot.pdf_rapor', [
            'id_kelas'     => $id_kelas,
            'siswas'       => $siswas,
            'mapels'       => $mapels, // Kirim data dari DB
            'data_nilai'   => $this->getDataNilai($id_kelas),
            'data_absensi' => $this->getDataAbsensi($id_kelas)
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Rapor_Kelas_'.$id_kelas.'.pdf');
    }
}