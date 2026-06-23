<!DOCTYPE html>
<html>
<head>
    <title>Laporan Nilai {{ $mapel }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11pt; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h3>DAFTAR NILAI - {{ strtoupper($mapel) }}</h3>
        <p>Kelas: {{ $id_kelas }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" rowspan="2">No</th>
                <th width="25%" rowspan="2">Nama Siswa</th>
                
                @if($mapel == 'STS' || $mapel == 'SAS')
                    <th rowspan="2">Nilai Ujian</th>
                @else
                    <th colspan="4">Tugas (Formatif)</th>
                    <th colspan="2">Kuis</th>
                    <th rowspan="2" width="10%">Rata-rata</th>
                @endif
            </tr>

            @if($mapel != 'STS' && $mapel != 'SAS')
            <tr>
                <th>T1</th> <th>T2</th> <th>T3</th> <th>T4</th>
                <th>K1</th> <th>K2</th>
            </tr>
            @endif
        </thead>
        <tbody>
            @foreach($siswas as $idx => $siswa)
            @php $n = $nilai[$siswa->id] ?? null; @endphp
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td class="text-left" style="padding-left: 10px;">{{ $siswa->nama }}</td>

                @if($mapel == 'STS')
                    <td>{{ $n ? $n->uts : 0 }}</td>
                @elseif($mapel == 'SAS')
                    <td>{{ $n ? $n->uas : 0 }}</td>
                @else
                    <td>{{ $n ? $n->tugas1 : 0 }}</td>
                    <td>{{ $n ? $n->tugas2 : 0 }}</td>
                    <td>{{ $n ? $n->tugas3 : 0 }}</td>
                    <td>{{ $n ? $n->tugas4 : 0 }}</td>
                    <td>{{ $n ? $n->kuis1 : 0 }}</td>
                    <td>{{ $n ? $n->kuis2 : 0 }}</td>
                    
                    @php
                        $t1 = $n ? $n->tugas1 : 0; $t2 = $n ? $n->tugas2 : 0;
                        $t3 = $n ? $n->tugas3 : 0; $t4 = $n ? $n->tugas4 : 0;
                        $k1 = $n ? $n->kuis1 : 0;  $k2 = $n ? $n->kuis2 : 0;
                        $rata = ($t1+$t2+$t3+$t4+$k1+$k2) / 6;
                    @endphp
                    <td><strong>{{ round($rata) }}</strong></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>