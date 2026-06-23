<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaApiController extends Controller
{
    public function cekNilai(Request $request)
    {
        // 1. Validasi Input
        $validator = \Validator::make($request->all(), [
            'nis'  => 'required',
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'NIS dan Nama wajib diisi',
                'errors' => $validator->errors()
            ], 400);
        }

        // 2. Cari Siswa berdasarkan NIS & Nama (Case Insensitive buat nama biar aman)
        $siswa = Siswa::where('nis', $request->nis)
                      ->where('nama', 'LIKE', $request->nama) // Atau where('nama', $request->nama) kalau harus persis
                      ->with('nilai') // <--- PENTING: Load relasi nilainya
                        ->first();

        // 3. Cek Hasil
        if ($siswa) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'siswa' => $siswa,
                    // Kamu bisa format ulang nilainya di sini jika perlu
                ]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data siswa tidak ditemukan. Periksa NIS dan Nama.',
            ], 404);
        }
    }
}