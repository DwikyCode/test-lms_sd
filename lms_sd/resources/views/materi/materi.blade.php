@extends('layouts.kelas')

@section('content_kelas')

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-video text-purple-500 mr-3"></i> Materi & Video Pembelajaran
            </h2>
            <p class="text-gray-500 mt-1">Tonton video pembelajaran untuk memperdalam pemahaman.</p>
        </div>

        {{-- TOMBOL TAMBAH (Hanya Admin) --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('materi.create', $id_kelas) }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-full shadow-lg transition-all transform hover:-translate-y-1 font-bold flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Video Baru
            </a>
        @endif
    </div>

    {{-- EMPTY STATE (Jika belum ada materi) --}}
    @if($materis->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
            <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-film text-black text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Belum ada materi video</h3>
            <p class="text-gray-500 mt-2">Admin belum mengunggah materi untuk kelas ini.</p>
        </div>
    @else

        {{-- GRID MATERI --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($materis as $materi)
                
                {{-- LOGIKA CONVERT LINK YOUTUBE KE EMBED --}}
                @php
                    $url = $materi->link_video;
                    // Ubah 'watch?v=' menjadi 'embed/' agar bisa diputar di iframe
                    $url = str_replace("watch?v=", "embed/", $url);
                    // Handle short link (youtu.be)
                    $url = str_replace("youtu.be/", "www.youtube.com/embed/", $url);
                @endphp

                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 group flex flex-col h-full">
                    
                    {{-- VIDEO PLAYER FRAME --}}
                    <div class="relative w-full aspect-video bg-black">
                        <iframe src="{{ $url }}" 
                                title="{{ $materi->judul }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="absolute top-0 left-0 w-full h-full">
                        </iframe>
                    </div>

                    {{-- KONTEN TEKS --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                            {{ $materi->judul }}
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-3 mb-4 flex-1">
                            {{ $materi->deskripsi }}
                        </p>
                        
                        {{-- TOMBOL AKSI ADMIN (Edit/Hapus) --}}
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="border-t border-gray-100 pt-4 flex justify-end gap-2 mt-auto">
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('materi.destroy', $materi->id) }}" method="POST" onsubmit="return confirm('Yakin hapus video ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold px-3 py-1 bg-red-50 rounded-lg hover:bg-red-100 transition">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    @endif

@endsection