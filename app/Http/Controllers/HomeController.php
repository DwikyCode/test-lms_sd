<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas; 

class HomeController extends Controller
{
    public function index()
    {

        $kelas = [
            (object) ['id' => 1, 'nama' => 'Kelas 1', 'warna' => 'blue'],
            (object) ['id' => 2, 'nama' => 'Kelas 2', 'warna' => 'green'],
            (object) ['id' => 3, 'nama' => 'Kelas 3', 'warna' => 'red'],
            (object) ['id' => 4, 'nama' => 'Kelas 4', 'warna' => 'orange'],
            (object) ['id' => 5, 'nama' => 'Kelas 5', 'warna' => 'cyan'],
            (object) ['id' => 6, 'nama' => 'Kelas 6', 'warna' => 'slate'],
        ];

        // Kirim data manual ini ke view
        return view('dashboard', compact('kelas'));        
    }
}