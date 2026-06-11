@extends('layouts.kelas')

@section('content_kelas')

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

    <div class="bg-white border border-gray-100 shadow-xl rounded-3xl overflow-hidden">
        <div class="bg-gray-50 px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h5 class="text-xl font-bold {{ str_contains($mapel, 'Tema') ? 'text-green-600' : 'text-blue-600' }} flex items-center">
                    @if(str_contains($mapel, 'Tema')) 
                        <i class="fas fa-puzzle-piece mr-2"></i>
                    @else 
                        <i class="fas fa-book mr-2"></i> 
                    @endif
                    Input Nilai: {{ $mapel }}
                </h5>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('nilai.pdf_detail', ['id' => $id_kelas, 'mapel' => $mapel]) }}" 
                   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow transition-all flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i> PDF
                </a>

                <a href="{{ route('nilai.mapel', $id_kelas) }}" 
                   class="bg-white  border-gray-300 text-purple-600 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium shadow-sm transition-all flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="p-0">
            <form action="{{ route('nilai.store', $id_kelas) }}" method="POST">
                @csrf
                <input type="hidden" name="mapel" value="{{ $mapel }}">

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th rowspan="2" class="px-4 py-3 border border-gray-200 w-12 text-center align-middle font-bold uppercase text-xs">No</th>
                                <th rowspan="2" class="px-4 py-3 border border-gray-200 text-left align-middle font-bold uppercase text-xs min-w-[200px]">Nama Siswa</th>
                                
                                @if($mapel == 'STS' || $mapel == 'SAS')
                                    <th class="px-4 py-3 border border-gray-200 text-center font-bold uppercase text-xs {{ $mapel == 'STS' ? 'bg-green-50 text-green-700' : 'bg-blue-50 text-blue-700' }}">
                                        Nilai Ujian
                                    </th>
                                @else
                                    <th colspan="4" class="px-2 py-2 border border-blue-200 bg-blue-50 text-blue-700 text-center font-bold text-xs uppercase">
                                        Tugas (Formatif)
                                    </th>
                                    <th colspan="2" class="px-2 py-2 border border-yellow-200 bg-yellow-50 text-yellow-700 text-center font-bold text-xs uppercase">
                                        Kuis
                                    </th>
                                    <th rowspan="2" class="px-2 py-2 border border-gray-200 bg-gray-100 text-gray-600 text-center align-middle font-bold text-xs uppercase w-20">
                                        Rata-rata
                                    </th>
                                @endif
                            </tr>
                            
                            @if($mapel != 'STS' && $mapel != 'SAS')
                            <tr>
                                <th class="px-2 py-2 border border-gray-200 bg-white text-center text-xs font-semibold w-20">Tugas 1</th>
                                <th class="px-2 py-2 border border-gray-200 bg-white text-center text-xs font-semibold w-20">Tugas 2</th>
                                <th class="px-2 py-2 border border-gray-200 bg-white text-center text-xs font-semibold w-20">Tugas 3</th>
                                <th class="px-2 py-2 border border-gray-200 bg-white text-center text-xs font-semibold w-20">Tugas 4</th>
                                <th class="px-2 py-2 border border-gray-200 bg-white text-center text-xs font-semibold w-20">Kuis 1</th>
                                <th class="px-2 py-2 border border-gray-200 bg-white text-center text-xs font-semibold w-20">Kuis 2</th>
                            </tr>
                            @endif

                        </thead>
                        <tbody class="bg-white text-gray-700">
                            @foreach($siswas as $idx => $siswa)
                            @php
                                $n = $nilai[$siswa->id] ?? null;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
                                <td class="px-4 py-3 text-center border-r border-gray-100">{{ $idx + 1 }}</td>
                                <td class="px-4 py-3 font-bold border-r border-gray-100 whitespace-nowrap">{{ $siswa->nama }}</td>

                                @if($mapel == 'STS')
                                    <td class="p-2 text-center bg-green-50/30">
                                        <input type="number" name="nilai[{{ $siswa->id }}][nilai_akhir]" 
                                                class="w-24 text-center font-bold text-green-700 bg-white border border-green-300 rounded focus:ring-2 focus:ring-green-400 focus:border-green-400 p-2 shadow-sm"
                                                value="{{ $n ? $n->uts : 0 }}" min="0" max="100">
                                    </td>
                                @elseif($mapel == 'SAS')
                                    <td class="p-2 text-center bg-blue-50/30">
                                        <input type="number" name="nilai[{{ $siswa->id }}][nilai_akhir]" 
                                                class="w-24 text-center font-bold text-blue-700 bg-white border border-blue-300 rounded focus:ring-2 focus:ring-blue-400 focus:border-blue-400 p-2 shadow-sm"
                                                value="{{ $n ? $n->uas : 0 }}" min="0" max="100">
                                    </td>

                                @else
                                    @php
                                        $t1 = $n ? $n->tugas1 : 0;
                                        $t2 = $n ? $n->tugas2 : 0;
                                        $t3 = $n ? $n->tugas3 : 0;
                                        $t4 = $n ? $n->tugas4 : 0;
                                        $k1 = $n ? $n->kuis1 : 0;
                                        $k2 = $n ? $n->kuis2 : 0;
                                        $rata = ($t1+$t2+$t3+$t4+$k1+$k2) / 6;
                                    @endphp

                                    <td class="p-2"><input type="number" name="nilai[{{ $siswa->id }}][tugas1]" class="w-full text-center border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm p-1.5" value="{{ $t1 }}"></td>
                                    <td class="p-2"><input type="number" name="nilai[{{ $siswa->id }}][tugas2]" class="w-full text-center border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm p-1.5" value="{{ $t2 }}"></td>
                                    <td class="p-2"><input type="number" name="nilai[{{ $siswa->id }}][tugas3]" class="w-full text-center border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm p-1.5" value="{{ $t3 }}"></td>
                                    <td class="p-2 border-r border-gray-100"><input type="number" name="nilai[{{ $siswa->id }}][tugas4]" class="w-full text-center border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm p-1.5" value="{{ $t4 }}"></td>
                                    
                                    <td class="p-2 bg-yellow-50/30"><input type="number" name="nilai[{{ $siswa->id }}][kuis1]" class="w-full text-center border-yellow-300 rounded focus:ring-yellow-500 focus:border-yellow-500 text-sm p-1.5" value="{{ $k1 }}"></td>
                                    <td class="p-2 bg-yellow-50/30 border-r border-gray-100"><input type="number" name="nilai[{{ $siswa->id }}][kuis2]" class="w-full text-center border-yellow-300 rounded focus:ring-yellow-500 focus:border-yellow-500 text-sm p-1.5" value="{{ $k2 }}"></td>
                                    
                                    <td class="text-center font-bold text-gray-800 bg-gray-50">
                                        {{ round($rata) }}
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 px-6 py-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="w-full md:w-auto bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition duration-300 transform hover:-translate-y-1 flex justify-center items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Nilai {{ $mapel }}
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection