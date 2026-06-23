@extends('layouts.kelas')

@section('content_kelas')

    {{-- 1. HEADER SECTION (JUDUL) --}}
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-black mb-2">Input Nilai & Asesmen</h2>
        <p class="text-gray-500 text-lg">
            Pilih <strong class="text-gray-900">Tema</strong> atau <strong class="text-gray-900">   Muatan Pelajaran</strong> untuk memasukkan nilai.
        </p>
    </div>

    {{-- 2. ACTION SECTION (TOMBOL RAPOR & TAMBAH BARU) --}}
    <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-12">
        
        {{-- A. TOMBOL LIHAT REKAPITULASI (RAPOR) --}}
        <a href="{{ route('rapot.show', $id_kelas) }}" 
           class="bg-purple-500 hover:bg-gray-600 text-white px-8 py-4 rounded-full shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center font-bold text-lg">
            <i class="fas fa-table mr-3"></i> Lihat Rekapitulasi (Rapor)
        </a>

    </div>

    {{-- 3. GRID MAPEL LIST (DARI DATABASE) --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($mapels as $mp)
            
            {{-- LOGIKA CEK JENIS: Apakah Tema atau Mapel Biasa? --}}
            @php
                // Cek kolom 'jenis' jika ada, atau cek dari namanya
                $isTema = (isset($mp->jenis) && $mp->jenis == 'Tema') || str_contains($mp->nama, 'Tema');
            @endphp
        
            <a href="{{ route('nilai.input', ['id' => $id_kelas, 'mapel' => $mp->nama]) }}" 
               class="group h-full bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-2 p-6 flex flex-col items-center justify-center text-center relative overflow-hidden">
                
                {{-- Dekorasi Garis Atas --}}
                <div class="absolute top-0 left-0 w-full h-2 {{ $isTema ? 'bg-green-500' : 'bg-purple-500' }}"></div>

                {{-- Ikon Bulat --}}
                <div class="mb-4 p-4 rounded-full {{ $isTema ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-purple-600' }}">
                    @if($isTema)
                        <i class="fas fa-puzzle-piece text-3xl"></i>
                    @else
                        <i class="fas fa-book text-3xl"></i>
                    @endif
                </div>
                
                {{-- Judul Mapel (Ambil dari Database) --}}
                <h5 class="font-bold text-gray-800 text-lg mb-1 group-hover:text-blue-600 transition-colors">
                    {{ $mp->nama }}
                </h5>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Input Asesmen</p>
            
            </a>

        @endforeach
                {{-- B. KOTAK TAMBAH BARU (ADMIN ONLY) --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('mapel.create', $id_kelas) }}" 
               class="group w-40 h-40 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-[2rem] hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 cursor-pointer">
                
                {{-- Ikon Plus --}}
                <div class="mb-2 transition-transform group-hover:scale-110">
                    <i class="fas fa-plus text-3xl text-gray-400 group-hover:text-blue-600"></i>
                </div>
                
                {{-- Teks --}}
                <span class="text-gray-400 font-bold group-hover:text-blue-700">Tambah Baru</span>
            </a>
        @endif
    </div>

@endsection