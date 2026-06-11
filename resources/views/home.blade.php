@extends('layouts.app') 
{{-- Pastikan nama filenya app.blade.php ada di folder resources/views/layouts --}}

@section('content')

<div class="w-full h-64 md:h-80 bg-gradient-to-r from-slate-500 to-slate-700 rounded-3xl relative overflow-hidden shadow-lg mb-12 flex items-end p-8 md:p-12 text-white">
    <div class="absolute inset-0 bg-black/20"></div>
    
    <div class="relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold mb-2">Belajar Bersama</h2>
        <p class="text-lg opacity-90">Kolaborasi dan kerja sama antar siswa</p>
        
        <div class="flex gap-2 mt-4">
            <span class="w-3 h-3 bg-white rounded-full"></span>
            <span class="w-3 h-3 bg-white/50 rounded-full"></span>
            <span class="w-3 h-3 bg-white/50 rounded-full"></span>
        </div>
    </div>

    <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 w-10 h-10 rounded-full flex items-center justify-center transition">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 w-10 h-10 rounded-full flex items-center justify-center transition">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</div>

<div class="text-center mb-10">
    <h3 class="text-2xl font-bold text-slate-800">Dashboard Pembelajaran</h3>
    <p class="text-slate-500">Silahkan pilih Kelas yang ingin Anda tekuni hari ini</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    @forelse($kelas as $k)
        {{-- Logic Warna --}}
        @php
            // Mapping warna dari database (string) ke class Tailwind
            $colorMap = [
                'blue' => ['bg' => 'bg-blue-600', 'btn' => 'bg-blue-600 hover:bg-blue-700'],
                'green' => ['bg' => 'bg-emerald-500', 'btn' => 'bg-emerald-500 hover:bg-emerald-600'],
                'red' => ['bg' => 'bg-red-600', 'btn' => 'bg-red-600 hover:bg-red-700'],
                'orange' => ['bg' => 'bg-orange-500', 'btn' => 'bg-orange-500 hover:bg-orange-600'],
                'cyan' => ['bg' => 'bg-cyan-500', 'btn' => 'bg-cyan-500 hover:bg-cyan-600'],
                'slate' => ['bg' => 'bg-slate-500', 'btn' => 'bg-slate-500 hover:bg-slate-600'],
            ];
            // Default ke blue jika warna tidak ditemukan
            $theme = $colorMap[$k->warna] ?? $colorMap['blue'];
        @endphp

        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-6 flex flex-col items-center text-center border border-slate-100">
            <div class="{{ $theme['bg'] }} w-16 h-16 rounded-2xl flex items-center justify-center text-white text-3xl font-bold mb-4 shadow-lg shadow-gray-200 relative">
                {{ $k->id }}
                <span class="absolute -top-2 -right-2 bg-white text-slate-400 text-xs w-6 h-6 rounded-full flex items-center justify-center border border-slate-200 shadow-sm">
                    <i class="fa-solid fa-book-open"></i>
                </span>
            </div>

            <h4 class="text-lg font-bold text-slate-800">{{ $k->nama }}</h4>
            <p class="text-xs text-slate-400 mb-6">Kelola Siswa, Materi & Nilai</p>

            <a href="{{ route('kelas.show', $k->id) }}" class="{{ $theme['btn'] }} text-white text-sm font-medium py-2.5 px-6 rounded-lg w-full transition flex items-center justify-center gap-2">
                Masuk Kelas <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    @empty
        <div class="col-span-3 text-center py-10 text-slate-400">
            <p>Belum ada data kelas. Silahkan jalankan Seeder.</p>
        </div>
    @endforelse
</div>

<div class="bg-blue-600 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between text-white shadow-xl shadow-blue-200 mb-8">
    <div class="flex items-center gap-6 mb-4 md:mb-0">
        <div class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center text-2xl">
            <i class="fa-regular fa-circle-question"></i>
        </div>
        <div>
            <h4 class="text-lg font-bold">Butuh bantuan dari kami?</h4>
            <p class="text-sm text-blue-100 opacity-90">Jika tidak dapat melihat kelas hubungi admin.</p>
        </div>
    </div>
    
    <button class="bg-white text-blue-600 font-semibold py-2.5 px-6 rounded-lg hover:bg-blue-50 transition shadow-sm whitespace-nowrap">
        <i class="fa-regular fa-comments mr-2"></i> Hubungi Kami
    </button>
</div>

@endsection