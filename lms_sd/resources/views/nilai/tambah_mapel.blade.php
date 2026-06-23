@extends('layouts.kelas')

@section('content_kelas')


@if(Auth::check() && Auth::user()->role === 'admin')

    <div class="flex justify-center py-6 fade-in">
        <div class="w-full max-w-lg">
            <div class="bg-white border border-gray-100 shadow-xl rounded-3xl overflow-hidden">
                <div class="bg-indigo-50 px-8 py-6 border-b border-indigo-100 flex items-center">
                    <div class="bg-indigo-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center mr-4 shadow-sm">
                        <i class="fas fa-layer-group text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 leading-tight">
                            Tambah Mapel Baru
                        </h2>
                        <p class="text-sm text-gray-800 font-medium">Panel Administrator</p>
                    </div>
                </div>
                <div class="p-8">
                    <form action="{{ route('mapel.store') }}" method="POST">
                        @csrf 
                        <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
                        <div class="mb-6">
                            <label for="nama_mapel" class="block text-sm font-bold text-gray-700 mb-2">
                                Nama Mata Pelajaran / Tema
                            </label>
                            <input type="text" 
                                    name="nama_mapel" 
                                    id="nama_mapel"
                                    class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-indigo-100 transition duration-200"
                                    placeholder="Contoh: Matematika, Bahasa Jawa, Tema 5..."
                                    required>
                        </div>
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Jenis Pelajaran</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="jenis" value="Mapel" class="peer sr-only" checked>
                                    <div class="px-4 py-4 rounded-2xl border-2 border-gray-100 text-center transition-all hover:bg-gray-50 peer-checked:bg-indigo-50 peer-checked:border-purple-500 peer-checked:text-indigo-700">
                                        <i class="fas fa-book mb-2 text-2xl block opacity-80"></i>
                                        <span class="text-sm font-bold">Mapel Umum</span>
                                    </div>
                                    <div class="absolute top-2 right-2 text-indigo-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check-circle"></i> 
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="jenis" value="Tema" class="peer sr-only">
                                    <div class="px-4 py-4 rounded-2xl border-2 border-gray-100 text-center transition-all hover:bg-gray-50 peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-700">
                                        <i class="fas fa-puzzle-piece mb-2 text-2xl block opacity-80"></i>
                                        <span class="text-sm font-bold">Tematik</span>
                                    </div>
                                    <div class="absolute top-2 right-2 text-green-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3">
                            <button type="submit" 
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 rounded-xl shadow-md transition duration-300 transform hover:-translate-y-1 flex justify-center items-center">
                                <i class="fas fa-plus mr-2"></i> Tambahkan Sekarang
                            </button>
                            
                            <a href="{{ route('nilai.mapel', $id_kelas) }}" 
                               class="w-full bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-bold py-3.5 rounded-xl text-center transition duration-300">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
    </div>

@else
    <div class="min-h-[50vh] flex flex-col items-center justify-center text-center px-4">
        <div class="bg-red-50 p-6 rounded-full mb-6 animate-pulse">
            <i class="fas fa-user-lock text-5xl text-red-500"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Akses Dibatasi</h2>
        <p class="text-gray-500 max-w-md mx-auto mb-8">
            Halaman ini khusus untuk Administrator. Guru tidak memiliki izin untuk menambah mata pelajaran baru.
        </p>
        <a href="{{ route('nilai.mapel', $id_kelas) }}" class="bg-gray-800 text-white px-6 py-3 rounded-full font-bold hover:bg-gray-900 transition shadow-lg">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
@endif

@endsection