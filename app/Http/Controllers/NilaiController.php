<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{

    public function index($id_kelas)
    {
        $mapels = Mapel::where('id_kelas', $id_kelas)->get();

        return view('nilai.mapel', [
            'id_kelas' => $id_kelas,
            'mapels'   => $mapels
        ]);
    }
    public function mapel($id_kelas)
    {
        $mapels = Mapel::where('id_kelas', $id_kelas)->get(); 
        return view('nilai.mapel', [
            'id_kelas' => $id_kelas,
            'mapels'   => $mapels
        ]);
    }

    public function create($id_kelas, $mapel)
    {
        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('nama', 'asc')->get();
        $existing_grades = Nilai::where('kelas', $id_kelas)
                                ->where('mapel', $mapel)
                                ->get()
                                ->keyBy('siswa_id'); 

        return view('nilai.input', [
            'id_kelas' => $id_kelas,
            'mapel'    => $mapel, 
            'siswas'   => $siswas,
            'nilai'    => $existing_grades
        ]);
    }

    public function store(Request $request, $id_kelas)
    {
        $mapel = $request->mapel;
        $data = $request->input('nilai');

        foreach ($data as $siswa_id => $skor) {
            $dataToSave = [
                'kelas'    => $id_kelas,
                'siswa_id' => $siswa_id,
                'mapel'    => $mapel 
            ];

            $valuesToUpdate = [];

            if ($mapel == 'STS') {
                $valuesToUpdate['uts'] = $skor['nilai_akhir'] ?? 0;
            } 
            elseif ($mapel == 'SAS') {
                $valuesToUpdate['uas'] = $skor['nilai_akhir'] ?? 0;
            } 
            else {
                $valuesToUpdate['tugas1'] = $skor['tugas1'] ?? 0;
                $valuesToUpdate['tugas2'] = $skor['tugas2'] ?? 0;
                $valuesToUpdate['tugas3'] = $skor['tugas3'] ?? 0;
                $valuesToUpdate['tugas4'] = $skor['tugas4'] ?? 0;
                $valuesToUpdate['kuis1']  = $skor['kuis1'] ?? 0;
                $valuesToUpdate['kuis2']  = $skor['kuis2'] ?? 0;
                
                $total = ($valuesToUpdate['tugas1'] + $valuesToUpdate['tugas2'] + $valuesToUpdate['tugas3'] + $valuesToUpdate['tugas4'] + $valuesToUpdate['kuis1'] + $valuesToUpdate['kuis2']);
                $valuesToUpdate['tugas'] = round($total / 6); 
            }

            Nilai::updateOrCreate($dataToSave, $valuesToUpdate);
        }

        return redirect()->route('nilai.input', ['id' => $id_kelas, 'mapel' => $mapel])
                        ->with('success', 'Nilai ' . $mapel . ' berhasil disimpan!');
    }
    public function downloadPDFPerMapel($id_kelas, $mapel)
    {
        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('nama', 'asc')->get();

        $nilai = Nilai::where('kelas', $id_kelas)
                    ->where('mapel', $mapel)
                    ->get()
                    ->keyBy('siswa_id');

        $pdf = Pdf::loadView('nilai.pdf_detail', [
            'id_kelas' => $id_kelas,
            'mapel'    => $mapel,
            'siswas'   => $siswas,
            'nilai'    => $nilai
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Nilai_'.$mapel.'_Kelas_'.$id_kelas.'.pdf');
    }
    public function createMapel($id_kelas)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('nilai.mapel', $id_kelas)->with('error', 'Akses ditolak!');
        }
        return view('nilai.tambah_mapel', ['id_kelas' => $id_kelas]);
    }

    public function storeMapel(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_mapel' => 'required',
            'id_kelas'   => 'required',
            'jenis'      => 'required'
        ]);

        Mapel::create([
            'nama'     => $request->nama_mapel,
            'id_kelas' => $request->id_kelas,
            'jenis'    => $request->jenis
        ]);

        return redirect()->route('nilai.mapel', $request->id_kelas)
                        ->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }
}