@extends('layouts.kelas')

@section('content_kelas')

    <div class="flex justify-center py-6">
        <div class="w-full max-w-2xl">

            {{-- CARD CONTAINER --}}
            <div class="bg-white border border-gray-100 shadow-xl rounded-3xl overflow-hidden">

                {{-- HEADER --}}
                <div class="bg-red-50 px-8 py-6 border-b border-red-100 flex items-center">
                    {{-- Icon Wrapper --}}
                    <div
                        class="bg-white text-red-600 w-12 h-12 rounded-full flex items-center justify-center mr-4 shadow-sm">
                        <i class="fab fa-youtube text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 leading-tight">Tambah Video Materi</h2>
                        <p class="text-sm text-black font-medium">Masukkan link YouTube pembelajaran</p>
                    </div>
                </div>

                {{-- FORM BODY --}}
                <div class="p-8">
                    <form action="{{ route('materi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">

                        {{-- JUDUL --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Materi</label>
                            <input type="text" name="judul" required placeholder="Contoh: Matematika Perkalian Dasar"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 transition outline-none text-gray-700">
                        </div>

                        {{-- LINK VIDEO --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Link Video (YouTube)</label>
                            <div class="relative">
                                {{-- Icon Absolute di Kiri --}}
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-link"></i>
                                </div>
                                <input type="url" name="link_video" required
                                    placeholder="https://www.youtube.com/watch?v=..."
                                    class="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 transition outline-none text-gray-700">
                            </div>
                            <p class="text-xs text-gray-400 mt-2 ml-1">
                                *Salin link langsung dari browser YouTube.
                            </p>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="4" placeholder="Jelaskan sedikit tentang isi video ini..."
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-100 transition outline-none text-gray-700"></textarea>
                        </div>

                        {{-- TOMBOL --}}
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ route('materi.index', $id_kelas) }}"
                                class="px-6 py-3.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-center transition duration-300">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-3.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Simpan Video
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection