<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Sekolah - Administrasi Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">

    <nav class="navbar navbar-expand-lg landing-navbar">
        <div class="container">
            <a class="navbar-brand text-white fw-bold fs-4" href="#">
                {{-- 🏫 SIM Sekolah Dasar --}}
            </a>
        </div>
    </nav>

    <header class="hero-section d-flex align-items-center">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span
                        class="badge bg-white text-primary-custom px-3 py-2 rounded-pill mb-3 shadow-sm text-uppercase ls-1">
                        Sistem Manajemen Sekolah Terpadu
                    </span>
                    <h1 class="display-4 fw-bolder mb-4">
                        Digitalisasi Administrasi Sekolah<br>Lebih Efisien & Terdata
                    </h1>
                    <p class="lead opacity-75 mb-5 px-md-5">
                        Platform terintegrasi untuk Guru mengelola nilai dan absensi, serta kemudahan Orang Tua memantau
                        perkembangan siswa secara real-time.
                    </p>

                    <div class="d-flex gap-3 justify-content-center">
                        <button type="button"
                            class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold shadow text-primary-custom"
                            data-bs-toggle="modal" data-bs-target="#loginModal">
                            Akses Sistem Sekolah
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="fitur" class="container py-5">
    </section>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-body p-0">
                    <div class="row g-0">

                        <div class="col-md-6 bg-light p-5 text-center border-end">
                            <div class="mb-4">
                                <span style="font-size: 3rem;">👨‍🏫</span>
                            </div>
                            <h4 class="fw-bold mb-2">Guru & Admin</h4>
                            <p class="text-muted small mb-4">Masuk menggunakan akun yang telah terdaftar untuk mengelola
                                data sekolah.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 py-2 rounded-3 fw-bold"
                                style="background-color: #8c52ff; border:none;">
                                Login Guru
                            </a>
                        </div>

                        <div class="col-md-6 p-5 text-center bg-white">
                            <div class="mb-4">
                                <span style="font-size: 3rem;">👨‍👩‍👧‍👦</span>
                            </div>
                            <h4 class="fw-bold mb-2">Wali Murid</h4>
                            <p class="text-muted small mb-4">Masukkan NIS dan Nama Siswa untuk melihat Absensi & Nilai.
                            </p>

                            <form action="{{ route('cek.siswa') }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <input type="text" name="nis" class="form-control"
                                        placeholder="Nomor Induk Siswa (NIS)" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Siswa"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-outline-primary w-100 py-2 rounded-3 fw-bold"
                                    style="border-color: #8c52ff; color: #8c52ff;">
                                    Cek Data Anak 🔍
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon">📅</div>
                <h4 class="fw-bold mb-3">Rekap Absensi Digital</h4>
                <p class="text-muted">
                    Pencatatan kehadiran siswa dilakukan secara digital (Paperless). Data kehadiran tersimpan rapi dan
                    dapat direkap otomatis per semester.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon">📊</div>
                <h4 class="fw-bold mb-3">Input Nilai & E-Rapor</h4>
                <p class="text-muted">
                    Kelola nilai tugas, ulangan, dan ujian siswa dengan mudah. Sistem akan membantu kalkulasi rata-rata
                    untuk kebutuhan Rapor.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon">📂</div>
                <h4 class="fw-bold mb-3">Manajemen Materi Ajar</h4>
                <p class="text-muted">
                    Arsip digital untuk modul, silabus, dan bahan ajar. Guru dapat mengunggah materi agar
                    tersentralisasi dan mudah diakses kembali.
                </p>
            </div>
        </div>
    </div>
    </section>

    <footer class="bg-white py-4 border-top mt-5">
        <div class="container text-center">
            <p class="mb-0 text-muted small">
                &copy; {{ date('Y') }} <strong>Sistem Informasi Manajemen Sekolah Dasar</strong>. <br>
                Mendukung Transformasi Pendidikan Digital Indonesia.
            </p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>