@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="relative w-full rounded-3xl overflow-hidden shadow-lg mb-12 h-80 flex items-end p-8 sm:p-12">

            <img src="{{ asset('gambarSD/gambarSD1.jpeg') }}" alt="Belajar Bersama"
                class="absolute inset-0 w-full h-full object-cover -z-10">

            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
            <div class="relative z-10 text-white w-full">
                <h1 class="text-4xl md:text-5xl font-bold mb-2">Belajar Bersama</h1>
                <p class="text-lg md:text-xl text-white/90 font-medium">Kolaborasi dan kerja sama antar siswa</p>
            </div>

        </div>

        {{-- 2. JUDUL DASHBOARD --}}
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Pembelajaran</h2>
            <p class="text-gray-500">Silahkan pilih <span class="text-blue-600 font-semibold">Kelas</span> yang ingin Anda
                tekuni hari ini</p>
        </div>

        {{-- 3. GRID KELAS 1-6 --}}
        {{-- Grid Tailwind: grid-cols-1 (HP) -> grid-cols-2 (Tablet) -> grid-cols-3 (Laptop) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @php
                $kelas_list = [
                    ['id' => 1, 'color' => '#2563eb', 'shadow' => 'rgba(37, 99, 235, 0.4)'], // Biru
                    ['id' => 2, 'color' => '#10b981', 'shadow' => 'rgba(16, 185, 129, 0.4)'], // Hijau
                    ['id' => 3, 'color' => '#ef4444', 'shadow' => 'rgba(239, 68, 68, 0.4)'], // Merah
                    ['id' => 4, 'color' => '#f59e0b', 'shadow' => 'rgba(245, 158, 11, 0.4)'], // Orange
                    ['id' => 5, 'color' => '#06b6d4', 'shadow' => 'rgba(6, 182, 212, 0.4)'], // Cyan
                    ['id' => 6, 'color' => '#64748b', 'shadow' => 'rgba(100, 116, 139, 0.4)'], // Abu
                ];
            @endphp

            @foreach($kelas_list as $kelas)
                <div
                    class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 p-6 flex flex-col items-center text-center border border-gray-100">

                    {{-- Kotak Angka --}}
                    <div class="relative w-24 h-24 rounded-2xl flex items-center justify-center text-white text-5xl font-bold mb-4 shadow-lg"
                        style="background-color: {{ $kelas['color'] }}; box-shadow: 0 10px 15px -3px {{ $kelas['shadow'] }};">

                        {{ $kelas['id'] }}

                        {{-- Badge Icon Buku --}}
                        <div
                            class="absolute -top-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md border border-gray-100">
                            <i class="fas fa-book text-gray-400 text-xs"></i>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-1">Kelas</h3>
                    <p class="text-sm text-gray-500 mb-6">Kelola Siswa, Materi & Nilai</p>

                    {{-- Tombol Masuk --}}
                    <a href="{{ route('kelas.show', $kelas['id']) }}"
                        class="w-full py-3 rounded-xl text-white font-semibold shadow-md flex items-center justify-center gap-2 hover:opacity-90 transition"
                        style="background-color: {{ $kelas['color'] }};">
                        Masuk Kelas <i class="fas fa-arrow-right text-sm"></i>
                    </a>

                </div>
            @endforeach

        </div>

        {{-- 4. BANNER BANTUAN (BIRU) --}}
        <div
            class="mt-16 bg-gradient-to-r bg-purple-500 rounded-3xl p-6 md:p-10 flex flex-col md:flex-row items-center justify-between shadow-lg text-white">

            <div class="flex items-center gap-6 mb-6 md:mb-0">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-question text-3xl"></i>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-xl font-bold mb-1">Butuh bantuan dari kami?</h4>
                    <p class="text-white/80 text-sm md:text-base">Jika tidak dapat melihat kelas di atas maka mohon
                        menghubungi kami.</p>
                </div>
            </div>

            <a href="https://wa.me/081357653791" <button
                class="bg-white text-indigo-600 px-8 py-3 rounded-xl font-bold shadow-md hover:bg-gray-50 transition flex items-center gap-2">
                <i class="far fa-comment-alt"></i> Hubungi

                </button>
            </a>
        </div>

    </div>
@endsection