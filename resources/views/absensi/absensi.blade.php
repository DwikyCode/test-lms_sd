@extends('layouts.kelas')

@section('content_kelas')

    {{-- 1. ALERT MESSAGES --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex items-center justify-between" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm flex items-center">
            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- 2. CARD CONTAINER --}}
    <div class="bg-white border border-gray-100 shadow-xl rounded-3xl overflow-hidden">
        
        {{-- HEADER: Judul & Tanggal & Tombol PDF --}}
        <div class="bg-gray-50 px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h5 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-clipboard-list text-purple-500 mr-2"></i> Absensi Harian
                </h5>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="far fa-calendar-alt mr-1"></i> {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            
            <a href="{{ route('absensi.pdf', $id_kelas) }}" 
               class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-full text-sm font-medium shadow-md transition-all flex items-center transform hover:-translate-y-0.5">
                <i class="fas fa-file-pdf mr-2"></i> Download PDF
            </a>
        </div>
        
        {{-- BODY: Form Absensi --}}
        <div class="p-0">
            <form action="{{ route('absensi.store', $id_kelas) }}" method="POST">
                @csrf
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                @if($siswas->isEmpty())
                    {{-- State Kosong --}}
                    <div class="text-center py-12 px-4">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-slash text-gray-300 text-3xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada siswa di kelas ini.</p>
                        <p class="text-sm text-gray-400">Tambahkan siswa terlebih dahulu di menu Dashboard.</p>
                    </div>
                @else
                    {{-- Tabel Absensi --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-12">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($siswas as $index => $siswa)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                        {{ $siswa->nama }}
                                        <div class="text-xs text-blue-500 font-normal mt-0.5">{{ $siswa->nis }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- RADIO BUTTONS GROUP (Custom Tailwind) --}}
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 max-w-md mx-auto">
                                            
                                            {{-- 1. HADIR (Hijau) --}}
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Hadir" class="peer sr-only" checked>
                                                <div class="px-3 py-2 rounded-lg border border-gray-200 text-center text-sm font-medium text-gray-600 transition-all hover:bg-gray-50 peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500 shadow-sm">
                                                    Hadir
                                                </div>
                                            </label>

                                            {{-- 2. SAKIT (Biru) --}}
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Sakit" class="peer sr-only">
                                                <div class="px-3 py-2 rounded-lg border border-gray-200 text-center text-sm font-medium text-gray-600 transition-all hover:bg-gray-50 peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-500 shadow-sm">
                                                    Sakit
                                                </div>
                                            </label>

                                            {{-- 3. IZIN (Kuning/Orange) --}}
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Izin" class="peer sr-only">
                                                <div class="px-3 py-2 rounded-lg border border-gray-200 text-center text-sm font-medium text-gray-600 transition-all hover:bg-gray-50 peer-checked:bg-yellow-400 peer-checked:text-white peer-checked:border-yellow-400 shadow-sm">
                                                    Izin
                                                </div>
                                            </label>

                                            {{-- 4. ALPHA (Merah) --}}
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $siswa->id }}]" value="Alpha" class="peer sr-only">
                                                <div class="px-3 py-2 rounded-lg border border-gray-200 text-center text-sm font-medium text-gray-600 transition-all hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 shadow-sm">
                                                    Alpha
                                                </div>
                                            </label>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER: Tombol Simpan --}}
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <button type="submit" 
                                class="w-full bg-purple-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-md transition duration-300 transform hover:-translate-y-1 flex justify-center items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Absensi Hari Ini
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection