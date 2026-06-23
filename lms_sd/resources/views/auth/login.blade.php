<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - E-Learning SD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="login-page">
<img src="{{ asset('gambarSD/gambarSD3.jpeg') }}" 
    alt="background" 
    class="position-fixed top-0 start-0 w-100 h-100 object-fit-cover z-n1 opacity-50"><div class="container">

    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card card-login bg-white border-0 shadow-lg">
                <div class="login-header">
                    <div style="font-size: 3rem; margin-bottom: 10px;">
                        🎓
                    </div>
                    <h4 class="fw-bold mb-1">E-Learning SD</h4>
                    <p class="mb-0 small opacity-75">Platform Pembelajaran Digital</p>
                </div>

                <div class="card-body p-4 p-md-5">

                    @if (session('status'))
                        <div class="alert alert-success small mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf 

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                            <input type="email" class="form-control py-2 rounded-3 @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" 
                                    required autofocus placeholder="Contoh: siswa@sekolah.id">
                            
                            @error('email')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold text-secondary">Kata Sandi</label>
                            <input type="password" class="form-control py-2 rounded-3 @error('password') is-invalid @enderror" 
                                    id="password" name="password" 
                                    required placeholder="••••••••">
                            
                            @error('password')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            {{-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label small text-muted" for="remember_me">Ingat Saya</label>
                            </div> --}}
                            {{-- @if (Route::has('password.request'))
                                <a class="text-decoration-none small text-muted" href="{{ route('password.request') }}">
                                    Lupa Sandi?
                                </a>
                            @endif --}}
                        </div>

                        <button type="submit" class="btn btn-login w-100 mb-3">
                            Masuk Kelas 🚀
                        </button>

                        {{-- <div class="text-center mt-4">
                            <p class="small text-muted mb-0">Belum punya akun?</p>
                            <a class="text-decoration-none fw-bold text-primary-custom" href="{{ route('register') }}">
                                Daftar Sebagai Orang Tua
                            </a>
                        </div> --}}
                    </form>
                </div>
            </div>

            <div class="text-center mt-3 text-muted small">
                &copy; {{ date('Y') }} E-Learning SD. Tim Pengembang.
            </div>

        </div>
    </div>
</div>

</body>
</html>