<!DOCTYPE html>
<html>
<head>
    <title>Rapor Kelas {{ $id_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        h3, p { text-align: center; margin: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 9pt; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #ddd; }
        .text-left { text-align: left; padding-left: 5px; }
    </style>
</head>
<body>
    <h3>REKAPITULASI RAPOR SISWA</h3>
    <p>Kelas: {{ $id_kelas }}</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th width="3%" rowspan="2">No</th>
                <th width="18%" rowspan="2">Nama Siswa</th>
                <th colspan="{{ count($mapels) }}">Mata Pelajaran</th>
                <th colspan="4">Absensi</th>
            </tr>
            <tr>
                @foreach($mapels as $mp)
                    @php 
                        $label = str_replace(['Tema ', 'Pendidikan ', 'Matematika', 'Seni Budaya', 'B. Inggris'], ['T', '', 'MTK', 'SB', 'ING'], $mp);
                    @endphp
                    <th>{{ $label }}</th>
                @endforeach
                <th>H</th> <th>S</th> <th>I</th> <th>A</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $idx => $siswa)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td class="text-left">{{ $siswa->nama }}</td>
                @foreach($mapels as $mp)
                    <td>{{ $data_nilai[$siswa->id][$mp] ?? 0 }}</td>
                @endforeach
                @php $absen = $data_absensi[$siswa->id] ?? ['Hadir'=>0, 'Sakit'=>0, 'Izin'=>0, 'Alpha'=>0]; @endphp
                <td>{{ $absen['Hadir'] }}</td>
                <td>{{ $absen['Sakit'] }}</td>
                <td>{{ $absen['Izin'] }}</td>
                <td>{{ $absen['Alpha'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>