@extends('layouts.kelas')

@section('content_kelas')

    {{-- 1. ALERT SUCCESS (Tailwind) --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex items-center justify-between" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            {{-- Tombol Close (JavaScript opsional untuk menutup alert) --}}
            <button onclick="this.parentElement.style.display='none'" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- 2. STATISTIC CARD (Total Siswa) --}}
    <div class="mb-8">
        
        <div class="relative rounded-3xl p-6 sm:p-8 text-white shadow-lg overflow-hidden z-0">
            <img src="{{ asset('gambarSD/gambarSD2.jpeg') }}"
             alt="Total Siswa Background"
             class="absolute inset-0 w-full h-full object-cover -z-20 opacity-70"> 
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h6 class="text-black text-xs font-bold uppercase tracking-wider mb-1">Total Siswa</h6>
                    <h1 class="text-5xl font-extrabold text-black mb-1">{{ $total_siswa }}</h1>
                    <p class="text-sm text-black ">Siswa Terdaftar di Kelas {{ $id_kelas }}</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 3. TABEL DAFTAR SISWA --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Header Card --}}
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h5 class="text-lg font-bold text-gray-800">Daftar Siswa</h5>
            
            <a href="{{ route('siswa.create', $id_kelas) }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-full text-sm font-medium shadow-md transition-all flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Siswa
            </a>
        </div>

        {{-- Body Card --}}
        <div class="p-0">
            @if($siswas->isEmpty())
                {{-- State Kosong (Jika tidak ada siswa) --}}
                <div class="text-center py-12 px-4">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-slash text-gray-300 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium mb-4">Belum ada data siswa di kelas ini.</p>
                    <a href="{{ route('siswa.create', $id_kelas) }}" class="text-purple-600 font-semibold hover:underline">
                        Tambah Siswa Sekarang &rarr;
                    </a>
                </div>
            @else
                {{-- Tabel Data --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">NIS</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($siswas as $index => $siswa)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                        {{ $siswa->nis }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $siswa->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('siswa.edit', $siswa->id) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition mr-2" 
                                           title="Edit">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="inline-block"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition" 
                                                    title="Hapus">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection