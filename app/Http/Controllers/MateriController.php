<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi; // Import Model Materi

class MateriController extends Controller
{
    // 1. MENAMPILKAN DAFTAR MATERI
    public function index($id_kelas)
    {
        // Ambil materi berdasarkan kelas, urutkan dari yang terbaru
        $materis = Materi::where('id_kelas', $id_kelas)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('materi.materi', [
            'id_kelas' => $id_kelas,
            'materis'  => $materis
        ]);
    }

    // 2. HALAMAN FORM TAMBAH (ADMIN)
    public function create($id_kelas)
    {
        // Cek Role Manual (Opsional jika belum pakai middleware role)
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        return view('materi.create_materi', [
            'id_kelas' => $id_kelas
        ]);
    }

    // 3. PROSES SIMPAN DATA (ADMIN)
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Validasi
        $request->validate([
            'judul'      => 'required|string|max:255',
            'link_video' => 'required|url', // Harus format URL valid
            'deskripsi'  => 'nullable|string',
            'id_kelas'   => 'required'
        ]);

        // Simpan
        Materi::create([
            'judul'      => $request->judul,
            'link_video' => $request->link_video,
            'deskripsi'  => $request->deskripsi,
            'id_kelas'   => $request->id_kelas
        ]);

        return redirect()->route('materi.index', $request->id_kelas)
                         ->with('success', 'Materi video berhasil ditambahkan!');
    }

    // 4. HAPUS MATERI (ADMIN)
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materi = Materi::findOrFail($id);
        $id_kelas = $materi->id_kelas; // Simpan id kelas dulu buat redirect
        
        $materi->delete();

        return redirect()->route('materi.index', $id_kelas)
                         ->with('success', 'Video berhasil dihapus.');
    }
}