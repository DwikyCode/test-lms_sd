@extends('layouts.kelas')

@section('content_kelas')

    <div class="flex justify-center py-6">
        <div class="w-full max-w-lg">

            {{-- CARD CONTAINER --}}
            <div class="bg-white border border-gray-100 shadow-xl rounded-3xl overflow-hidden">

                {{-- Header Form (Nuansa Kuning untuk Edit) --}}
                <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex items-center">
                    <div class="bg-purple-100 text-purple-600 w-10 h-10 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-pencil-alt"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 leading-tight">
                            Edit Siswa
                        </h2>
                        <p class="text-sm text-gray-500">Perbarui data siswa kelas {{ $siswa->kelas }}</p>
                    </div>
                </div>

                {{-- Body Form --}}
                <div class="p-8">
                    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- INPUT NIS --}}
                        <div class="mb-5">
                            <label for="nis" class="block text-sm font-bold text-gray-700 mb-2">
                                Nomor Induk Siswa (NIS)
                            </label>
                            <input type="number" name="nis" id="nis"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition duration-200 @error('nis') border-red-500 focus:ring-red-100 @enderror"
                                value="{{ old('nis', $siswa->nis) }}" required>

                            @error('nis')
                                <p class="text-red-500 text-xs mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- INPUT NAMA --}}
                        <div class="mb-8">
                            <label for="nama" class="block text-sm font-bold text-gray-700 mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text" name="nama" id="nama"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition duration-200"
                                value="{{ old('nama', $siswa->nama) }}" required>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="flex flex-col gap-3">
                            <button type="submit"
                                class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3.5 rounded-xl shadow-md transition duration-300 transform hover:-translate-y-1 flex justify-center items-center">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>

                            <a href="{{ route('kelas.show', $siswa->kelas) }}"
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3.5 rounded-xl text-center transition duration-300">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection