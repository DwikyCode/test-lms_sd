@extends('layouts.kelas')

@section('content_kelas')

    {{-- CARD CONTAINER --}}
    <div class="bg-white border border-gray-100 shadow-xl rounded-3xl overflow-hidden mt-6">

        {{-- HEADER: Title & Actions --}}
        <div
            class="bg-gray-50 px-6 py-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h5 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-clipboard-list text-blue-600 mr-3"></i> Rekapitulasi Rapor Siswa
                </h5>
                <p class="text-gray-500 mt-1">Data akademik & kehadiran kelas {{ $id_kelas }}</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('nilai.mapel', $id_kelas) }}"
                    class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-full text-sm font-bold shadow-sm hover:bg-gray-50 transition-all flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                <a href="{{ route('rapot.pdf', $id_kelas) }}"
                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center transform hover:-translate-y-0.5">
                    <i class="fas fa-file-pdf mr-2"></i> Download PDF
                </a>
            </div>
        </div>

        {{-- BODY: Scrollable Table --}}
        <div class="p-0 overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-left">

                {{-- TABLE HEAD --}}
                <thead>
                    <tr class="bg-blue-600 text-white uppercase tracking-wider text-xs font-semibold">
                        <th rowspan="2"
                            class="px-4 py-3 border-r border-blue-500 text-center w-12 sticky left-0 bg-blue-600 z-10">No
                        </th>
                        <th rowspan="2"
                            class="px-4 py-3 border-r border-blue-500 text-left min-w-[200px] sticky left-12 bg-blue-600 z-10">
                            Nama Siswa</th>

                        {{-- Group Header: Nilai Mapel --}}
                        <th colspan="{{ count($mapels) }}"
                            class="px-4 py-2 border-b border-blue-500 text-center bg-blue-700">
                            Nilai Rata-rata / Akhir
                        </th>

                        {{-- Group Header: Kehadiran --}}
                        <th colspan="4" class="px-4 py-2 border-b border-blue-500 text-center bg-gray-800">
                            Kehadiran
                        </th>
                    </tr>

                    {{-- Sub-Header: Nama Mapel & Status Absen --}}
                    <tr class="bg-blue-500 text-white text-xs">
                        @foreach($mapels as $mp)
                            <th class="px-2 py-2 border-r border-blue-400 text-center min-w-[60px]" title="{{ $mp }}">
                                {{ substr($mp, 0, 3) }} {{-- Singkat nama mapel jadi 3 huruf --}}
                            </th>
                        @endforeach

                        {{-- Kolom Absensi --}}
                        <th class="px-2 py-2 border-l border-blue-500 bg-gray-700 text-center w-10">H</th>
                        <th class="px-2 py-2 bg-gray-700 text-center w-10">S</th>
                        <th class="px-2 py-2 bg-gray-700 text-center w-10">I</th>
                        <th class="px-2 py-2 bg-gray-700 text-center w-10">A</th>
                    </tr>
                </thead>

                {{-- TABLE BODY --}}
                <tbody class="bg-white divide-y divide-gray-100 text-gray-700">
                    @foreach($siswas as $idx => $siswa)
                        <tr class="hover:bg-blue-50/30 transition-colors group">

                            {{-- No --}}
                            <td
                                class="px-4 py-3 text-center font-medium text-gray-500 bg-gray-50 sticky left-0 border-r border-gray-200 group-hover:bg-blue-50">
                                {{ $idx + 1 }}
                            </td>

                            {{-- Nama Siswa --}}
                            <td
                                class="px-4 py-3 font-bold text-gray-800 whitespace-nowrap bg-gray-50 sticky left-12 border-r border-gray-200 group-hover:bg-blue-50">
                                {{ $siswa->nama }}
                            </td>

                            {{-- Nilai Mapel Loop --}}
                            @foreach($mapels as $mp)
                                            @php
                                                $nilai = $data_nilai[$siswa->id][$mp] ?? 0;
                                                $isLow = $nilai < 70; // Highlight merah jika < 70
                                            @endphp
                                 <td
                                                class="px-2 py-3 text-center border-r border-gray-100 {{ $isLow ? 'text-red-600 font-bold bg-red-50' : '' }}">
                                                {{ $nilai }}
                                            </td>
                            @endforeach

                            {{-- Data Absensi --}}
                            @php
                                $absen = $data_absensi[$siswa->id] ?? ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpha' => 0];
                            @endphp
                            <td class="px-2 py-3 text-center border-l border-gray-200 font-medium text-green-600 bg-gray-50">
                                {{ $absen['Hadir'] }}
                            </td>
                            <td class="px-2 py-3 text-center text-blue-600 bg-gray-50">
                                {{ $absen['Sakit'] }}
                            </td>
                            <td class="px-2 py-3 text-center text-yellow-600 bg-gray-50">
                                {{ $absen['Izin'] }}
                            </td>
                            <td class="px-2 py-3 text-center text-red-600 font-bold bg-red-50">
                                {{ $absen['Alpha'] }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- FOOTER LEGEND --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-wrap gap-4 text-xs text-gray-500">
            <div class="flex items-center"><span class="w-3 h-3 bg-red-100 border border-red-200 mr-1 block"></span> Nilai <
                    70 (Remedial)</div>
                    <div class="flex items-center"><span class="w-3 h-3 bg-gray-800 mr-1 block"></span> Kolom Absensi
                        (H=Hadir, S=Sakit, I=Izin, A=Alpha)</div>
            </div>

        </div>

@endsection