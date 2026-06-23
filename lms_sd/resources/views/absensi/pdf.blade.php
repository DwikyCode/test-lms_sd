<!DOCTYPE html>
<html>
<head>
    <title>Absensi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <center>
        <h3>Laporan Absensi Kelas {{ $kelas }}</h3>
        <p>Tanggal: {{ $tanggal }}</p>
    </center>
    <table>
        <thead>
            <tr>
                <th>No</th> <th>Nama</th> <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_absensi as $idx => $row)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $row->siswa->nama }}</td>
                <td>{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>