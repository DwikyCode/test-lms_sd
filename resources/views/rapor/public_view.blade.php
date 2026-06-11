@extends('layouts.rapot_layout')

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center">
            <div class="d-flex justify-content-center align-items-center rounded-circle text-white fw-bold me-3" 
                 style="width: 60px; height: 60px; background-color: #8c52ff; font-size: 24px;">
                {{ substr($siswa->nama, 0, 1) }}
            </div>
            
            <div>
                <h4 class="fw-bold mb-1">{{ $siswa->nama }}</h4>
                <div class="text-muted">
                    <span class="me-3"><i class="bi bi-card-heading me-1"></i> NIS: <strong>{{ $siswa->nis }}</strong></span>
                    <span><i class="bi bi-building me-1"></i> Kelas: <strong>{{ $siswa->kelas }}</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0" style="color: #8c52ff;">📊 Capaian Kompetensi</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">Mata Pelajaran / Tema</th>
                                <th class="text-center">Nilai Akhir</th>
                                <th class="text-center">Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mapels as $mp)
                                @php 
                                    // Ambil nilai, default 0 jika kosong
                                    $skor = $nilai[$mp] ?? 0; 
                                    
                                    // Logika Predikat Sederhana
                                    if ($skor >= 90) { $predikat = 'A'; $badge = 'bg-success'; }
                                    elseif ($skor >= 80) { $predikat = 'B'; $badge = 'bg-primary'; }
                                    elseif ($skor >= 70) { $predikat = 'C'; $badge = 'bg-warning text-dark'; }
                                    else { $predikat = 'D'; $badge = 'bg-danger'; }
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary">{{ $mp }}</td>
                                    <td class="text-center fs-5 fw-bold">{{ $skor }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $badge }} rounded-pill px-3" style="width: 50px;">
                                            {{ $predikat }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-success">📅 Rekap Kehadiran</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                        <span><i class="bi bi-check-circle-fill text-success me-2"></i> Hadir</span>
                        <span class="fw-bold">{{ $absen['Hadir'] }} Hari</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                        <span><i class="bi bi-thermometer-half text-primary me-2"></i> Sakit</span>
                        <span class="fw-bold">{{ $absen['Sakit'] }} Hari</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                        <span><i class="bi bi-info-circle-fill text-warning me-2"></i> Izin</span>
                        <span class="fw-bold">{{ $absen['Izin'] }} Hari</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                        <span><i class="bi bi-x-circle-fill text-danger me-2"></i> Alpha</span>
                        <span class="fw-bold text-danger">{{ $absen['Alpha'] }} Hari</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <small class="text-muted">Data kehadiran semester ini</small>
            </div>
        </div>
    </div>
</div>

@endsection