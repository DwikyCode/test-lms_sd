<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\Mapel; // JANGAN LUPA IMPORT INI
use Barryvdh\DomPDF\Facade\Pdf;

class RekapController extends Controller
{
    // HAPUS function getDaftarTema()

    // Helper untuk ambil absensi
    private function getDataAbsensi($id_kelas) {
        $absensi_raw = Absensi::where('kelas', $id_kelas)->get();
        $rekap_absen = [];
        
        foreach ($absensi_raw as $absen) {
            $sid = $absen->siswa_id;
            if (!isset($rekap_absen[$sid])) {
                $rekap_absen[$sid] = ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpha' => 0];
            }
            if ($absen->status == 'Hadir') $rekap_absen[$sid]['Hadir']++;
            elseif ($absen->status == 'Sakit') $rekap_absen[$sid]['Sakit']++;
            elseif ($absen->status == 'Izin') $rekap_absen[$sid]['Izin']++;
            elseif ($absen->status == 'Alpha') $rekap_absen[$sid]['Alpha']++;
        }
        return $rekap_absen;
    }

    public function index($id_kelas)
    {
        // PERBAIKAN UTAMA:
        // Ambil nama mapel dari database dan ubah jadi array string sederhana.
        // Contoh hasil: ['Tema 1', 'Matematika', 'Mapel Baru']
        $mapels = Mapel::where('id_kelas', $id_kelas)->pluck('nama')->toArray();

        // Opsional: Tambahkan STS dan SAS manual jika belum ada di database mapel, 
        // tapi sebaiknya STS dan SAS juga dimasukkan ke database mapel agar konsisten.
        // Jika STS/SAS tidak masuk database mapel, bisa di-merge manual:
        // $mapels = array_merge($mapels, ['STS', 'SAS']); 

        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('nama', 'asc')->get();
        $all_nilai = Nilai::where('kelas', $id_kelas)->get();
        
        $data_nilai = [];
        foreach ($all_nilai as $n) {
            if ($n->mapel == 'STS') $nilai_fix = $n->uts;
            elseif ($n->mapel == 'SAS') $nilai_fix = $n->uas;
            else $nilai_fix = $n->tugas; 
            
            // Key array menggunakan nama mapel string dari database
            $data_nilai[$n->siswa_id][$n->mapel] = $nilai_fix;
        }

        $data_absensi = $this->getDataAbsensi($id_kelas);

        return view('nilai.rekap', [
            'id_kelas' => $id_kelas,
            'siswas' => $siswas,
            'mapels' => $mapels, // Ini sekarang array dinamis dari DB
            'data_nilai' => $data_nilai,
            'data_absensi' => $data_absensi
        ]);
    }

    public function downloadPDF($id_kelas)
    {
        // SAMA SEPERTI INDEX: Ambil dari DB
        $mapels = Mapel::where('id_kelas', $id_kelas)->pluck('nama')->toArray();

        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('nama', 'asc')->get();
        $all_nilai = Nilai::where('kelas', $id_kelas)->get();
        
        $data_nilai = [];
        foreach ($all_nilai as $n) {
            if ($n->mapel == 'STS') $nilai_fix = $n->uts;
            elseif ($n->mapel == 'SAS') $nilai_fix = $n->uas;
            else $nilai_fix = $n->tugas;
            $data_nilai[$n->siswa_id][$n->mapel] = $nilai_fix;
        }

        $data_absensi = $this->getDataAbsensi($id_kelas);

        $pdf = Pdf::loadView('nilai.pdf_rekap', [
            'id_kelas' => $id_kelas,
            'siswas' => $siswas,
            'mapels' => $mapels,
            'data_nilai' => $data_nilai,
            'data_absensi' => $data_absensi
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Rekap_Rapot_Kelas_'.$id_kelas.'.pdf');
    }
}