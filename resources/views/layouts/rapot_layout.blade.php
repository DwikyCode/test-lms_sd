<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Rapor Siswa - {{ config('app.name') }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .card { border-radius: 15px; border: none; }
        .table-header-custom { background-color: #8c52ff; color: white; } /* Warna Ungu sesuai tema */
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #8c52ff;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>
                <span>E-Learning SD</span>
            </a>
            <a href="{{ url('/') }}" class="btn btn-light btn-sm rounded-pill text-primary fw-bold px-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0 text-muted small">&copy; {{ date('Y') }} Sistem Informasi Sekolah Dasar.</p>
        </div>
    </footer>

</body>
</html>