<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaApiController;
use App\Http\Controllers\Api\AuthController;
// Import controller lain jika ada (misal Api\SiswaController yg kita buat sebelumnya utk CRUD)

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses siapa saja / Siswa)
|--------------------------------------------------------------------------
*/
// Endpoint untuk Siswa cek nilai (Tanpa Login)
Route::post('/cek-nilai-siswa', [SiswaApiController::class, 'cekNilai']);


// Endpoint Login untuk Guru/Admin
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| 2. PROTECTED ROUTES (Harus Login / Punya Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Contoh endpoint Dashboard Guru/Admin (Ambil user yg sedang login)
    Route::get('/user-profile', function (Request $request) {
        return $request->user();
    });

    // CRUD Siswa (Hanya bisa diakses kalau punya Token)
    // Pastikan kamu sudah punya Api/SiswaController seperti jawaban sebelumnya
    // Route::get('/siswa', [Api\SiswaController::class, 'index']);
    // Route::post('/siswa', [Api\SiswaController::class, 'store']);
});