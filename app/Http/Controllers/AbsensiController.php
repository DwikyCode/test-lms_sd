<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class AbsensiController extends Controller
{
    public function index($id_kelas)
    {
        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('id', 'asc')->get();
        
        return view('absensi.absensi', [
            'id_kelas' => $id_kelas,
            'siswas'   => $siswas,
            'tanggal'  => date('Y-m-d') 
        ]);
    }

    public function store(Request $request, $id_kelas)
    {
        $request->validate(['absensi' => 'required|array']);
        $tanggal = $request->tanggal;

        foreach ($request->absensi as $siswa_id => $status) {
            Absensi::updateOrCreate(
                ['siswa_id' => $siswa_id, 
                'tanggal' => $tanggal],
                ['kelas' => $id_kelas, 'status' => $status]
            );
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan!');
    }

    public function downloadPDF(Request $request, $id_kelas)
{
    $tanggal = $request->tanggal ?? date('Y-m-d');

    $data_absensi = Absensi::with('siswa')
        ->where('kelas', $id_kelas)
        ->where('tanggal', $tanggal)
        ->get();

    if ($data_absensi->isEmpty()) {
        return redirect()->back()
            ->with('error', 'Belum ada data absensi.');
    }

    $pdf = Pdf::loadView('absensi.pdf', [
        'data_absensi' => $data_absensi,
        'kelas' => $id_kelas,
        'tanggal' => $tanggal
    ]);

    return $pdf->download('Absensi_Kelas_'.$id_kelas.'.pdf');
}
}