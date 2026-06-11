@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

@vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="bg-white shadow-sm border-b border-gray-200 mb-6 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center py-3 gap-4">

                <div class="flex items-center w-full md:w-auto">
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('dashboard') }}" 
                       class="group flex items-center px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text--600 transition-colors mr-5">
                        <i class="fas fa-arrow-left mr-2 text-xs group-hover:-translate-x-1 transition-transform"></i> 
                        Kembali
                    </a>

                    {{-- Info Kelas --}}
                    <div>
                        <span class="block text-[10px] uppercase tracking-wider text-gray-400 font-bold">Kelas</span>
                        <h1 class="text-2xl font-bold text-gray-800 leading-none">
                            {{ $id_kelas ?? '-' }}
                        </h1>
                    </div>
                </div>

                {{-- BAGIAN KANAN: Menu Navigasi (Pills) --}}
                <div class="w-full md:w-auto overflow-x-auto pb-1 md:pb-0">
                    <nav class="flex space-x-1 bg-gray-100/50 p-1 rounded-full">
                        
                        {{-- 1. Dashboard --}}
                        <a href="{{ route('kelas.show', $id_kelas) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium flex items-center transition-all whitespace-nowrap
                           {{ Request::routeIs('kelas.show') || Request::is('kelas/*/dashboard')
                              ? 'bg-white text-purple-600 shadow-sm ring-1 ring-black/5' 
                              : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                            <i class="fas fa-tachometer-alt mr-2 {{ Request::routeIs('kelas.show') ? 'text-purple-500' : 'text-gray-400' }}"></i> 
                            Dashboard
                        </a>

                        {{-- 2. Absensi --}}
                        <a href="{{ route('absensi.index', $id_kelas) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium flex items-center transition-all whitespace-nowrap
                           {{ Request::is('kelas/*/absensi*') 
                              ? 'bg-white text-purple-500 shadow-sm ring-1 ring-black/5' 
                              : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                            <i class="fas fa-calendar-check mr-2 {{ Request::is('kelas/*/absensi*') ? 'text-purple-500' : 'text-gray-400' }}"></i> 
                            Absensi
                        </a>

                        {{-- 3. Materi --}}
                        <a href="{{ route('materi.index', request()->segment(2)) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium flex items-center transition-all whitespace-nowrap
                           {{ Request::is('kelas/*/materi*') 
                              ? 'bg-white text-purple-600 shadow-sm ring-1 ring-black/5' 
                              : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                            <i class="fas fa-book mr-2 {{ Request::is('kelas/*/materi*') ? 'text-purple-500' : 'text-gray-400' }}"></i> 
                            Materi
                        </a>

                        {{-- 4. Nilai --}}
                        <a href="{{ route('nilai.mapel', $id_kelas) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium flex items-center transition-all whitespace-nowrap
                           {{ Request::is('kelas/*/nilai*') 
                              ? 'bg-white text-purple-600 shadow-sm ring-1 ring-black/5' 
                              : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}">
                            <i class="fas fa-trophy mr-2 {{ Request::is('kelas/*/nilai*') ? 'text-purple-500' : 'text-gray-400' }}"></i> 
                            Nilai
                        </a>

                    </nav>
                </div>

            </div>
        </div>
    </div>

    {{-- KONTEN DINAMIS (Dashboard/Absensi/dll akan muncul di sini) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in min-h-screen pb-10">
        @yield('content_kelas')
    </div>

@endsection