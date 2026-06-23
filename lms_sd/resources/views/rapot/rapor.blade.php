@extends('layouts.kelas')

@section('content_kelas')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold text-purple-theme mb-1">
            <i class="bi bi-journal-bookmark-fill me-2"></i>Rekapitulasi Rapor
        </h4>
        <p class="text-secondary mb-0">
            Data akademik & kehadiran kelas <span class="fw-semibold text-dark">{{ $id_kelas }}</span>
        </p>
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('nilai.mapel', $id_kelas) }}" class="btn btn-outline-purple rounded-pill shadow-sm px-4 hover-shadow">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
        
        <a href="{{ route('rapot.pdf', $id_kelas) }}" class="btn btn-danger rounded-pill shadow-sm px-4 hover-lift">
            <i class="bi bi-file-earmark-pdf-fill me-2"></i> Download PDF
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom border-light">
        <div class="d-flex align-items-center">
            <span class="badge bg-purple-subtle rounded-pill me-2 px-3">
                <i class="bi bi-people-fill me-1"></i> {{ count($siswas) }} Siswa
            </span>
            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">
                <i class="bi bi-book-half me-1"></i> {{ count($mapels) }} Mapel
            </span>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 75vh;">
            <table class="table table-hover table-bordered mb-0 align-middle text-center text-nowrap" style="font-size: 0.9rem;">
                <thead class="sticky-top" style="z-index: 10;">
                    <tr>
                        <th rowspan="2" class="align-middle bg-light text-secondary" style="width: 50px;">No</th>
                        
                        <th rowspan="2" class="align-middle text-start ps-3 sticky-col bg-light text-dark">
                            Nama Siswa
                        </th>

                        <th colspan="{{ count($mapels) }}" class="bg-purple-gradient py-2 border-bottom-0 text-white">
                            Nilai Rata-rata / Akhir
                        </th>
                        <th colspan="4" class="bg-dark text-white py-2 border-bottom-0">
                            Kehadiran
                        </th>
                    </tr>
                    <tr>
                        @foreach($mapels as $mp)
                            @php 
                                $label = str_replace(['Tema ', 'Pendidikan ', 'Matematika', 'Seni Budaya', 'B. Inggris', 'Bahasa '], ['T', '', 'MTK', 'SB', 'ING', 'B.'], $mp);
                            @endphp
                            <th class="bg-white text-secondary small-header" data-bs-toggle="tooltip" title="{{ $mp }}">
                                {{ $label }}
                            </th>
                        @endforeach
                        
                        <th class="bg-success-subtle text-success small-header">H</th>
                        <th class="bg-purple-subtle text-purple-theme small-header">S</th> 
                        <th class="bg-warning-subtle text-warning small-header">I</th>
                        <th class="bg-danger-subtle text-danger small-header">A</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $idx => $siswa)
                    <tr>
                        <td class="text-secondary">{{ $idx + 1 }}</td>
                        <td class="text-start ps-3 fw-semibold text-dark sticky-col bg-white">
                            {{ $siswa->nama }}
                        </td>
                        
                        @foreach($mapels as $mp)
                            @php 
                                $nilai = $data_nilai[$siswa->id][$mp] ?? 0;
                                // Logic warna nilai
                                $textClass = $nilai < 70 ? 'text-danger fw-bold' : ($nilai >= 90 ? 'text-success fw-bold' : 'text-dark');
                                $bgClass = $nilai < 70 ? 'bg-danger-subtle' : ''; 
                            @endphp
                            <td class="{{ $textClass }} {{ $bgClass }} transition-cell">
                                {{ $nilai }}
                            </td>
                        @endforeach

                        @php $absen = $data_absensi[$siswa->id] ?? ['Hadir'=>0, 'Sakit'=>0, 'Izin'=>0, 'Alpha'=>0]; @endphp
                        
                        <td class="bg-light fw-bold text-dark">{{ $absen['Hadir'] }}</td>
                        <td>
                            @if($absen['Sakit'] > 0) 
                                <span class="badge bg-purple-subtle rounded-pill">{{ $absen['Sakit'] }}</span> 
                            @else - @endif
                        </td>
                        <td>
                            @if($absen['Izin'] > 0) <span class="badge bg-warning-subtle text-warning rounded-pill">{{ $absen['Izin'] }}</span> @else - @endif
                        </td>
                        <td>
                            @if($absen['Alpha'] > 0) <span class="badge bg-danger text-white rounded-pill">{{ $absen['Alpha'] }}</span> @else - @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($mapels) + 6 }}" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data siswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        <small class="text-muted fst-italic">
            <i class="bi bi-info-circle me-1"></i> Nilai di bawah 70 berwarna merah. Hover judul kolom untuk melihat nama mapel.
        </small>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

@endsection