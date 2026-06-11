<!DOCTYPE html>
<html>
<head>
    <title>Rekap Nilai</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; }
        th { background-color: #ddd; }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <center>
        <h3>REKAPITULASI NILAI KELAS {{ $id_kelas }}</h3>
    </center>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                @foreach($mapels as $mp)
                    <th>{{ substr($mp, 0, 3) }}</th>
                @endforeach
                <th>Rata2</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $idx => $siswa)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td class="text-left">{{ $siswa->nama }}</td>
                
                @php $total_skor = 0; @endphp
                
                @foreach($mapels as $mp)
                    @php
                        $nilai = $data_nilai[$siswa->id][$mp] ?? 0;
                        $total_skor += $nilai;
                    @endphp
                    <td>{{ $nilai }}</td>
                @endforeach

                <td><strong>{{ round($total_skor / count($mapels)) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>