<?php

namespace App\Http\Controllers;

use App\Models\Siswa; 
use Illuminate\Http\Request;
use App\Models\Siswas; // <--- PASTIKAN INI ADA
use Illuminate\Support\Facades\Validator; //

class SiswaController extends Controller
{
    public function index($id_kelas)
    {
        $siswas = Siswa::where('kelas', $id_kelas)->orderBy('id', 'asc')->get();
        $total_siswa = $siswas->count();

        return view('kelas.dasboard', [
            'id_kelas'    => $id_kelas,
            'siswas'      => $siswas,
            'total_siswa' => $total_siswa
        ]);
    }
    public function create($id_kelas)
    {
        return view('siswa.create', ['id_kelas' => $id_kelas]);
    }

    public function store(Request $request, $id_kelas)
    {
        $request->validate([
            'nis' => 'required|numeric|unique:siswas,nis',
            'nama' => 'required|string|max:255',
        ], [
            'nis.unique' => 'NIS ini sudah ada di database!',
            'nama.required' => 'Nama siswa wajib diisi!'
        ]);
        Siswa::create([
            'nis'   => $request->nis,
            'nama'  => $request->nama,
            'kelas' => $id_kelas,
        ]);

        return redirect()->route('kelas.show', $id_kelas)
                        ->with('success', 'Berhasil menambahkan data siswa!');
    }
    public function edit($id)
    {
        // Cari siswa berdasarkan ID
        $siswa = Siswa::findOrFail($id);
        
        // Tampilkan view edit
        return view('siswa.edit', [
            'siswa' => $siswa,
            'id_kelas' => $siswa->kelas 
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|numeric|unique:siswas,nis,'.$id,
            'nama' => 'required|string|max:255',
        ]);

        $siswa = Siswa::findOrFail($id);
        
        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
        ]);

        return redirect()->route('kelas.show', $siswa->kelas)
                        ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $id_kelas = $siswa->kelas; 
        
        $siswa->delete();

        return redirect()->route('kelas.show', $id_kelas)
                    ->with('success', 'Data siswa berhasil dihapus.');
    }
}