<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Learning SD') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <nav class="bg-purple-500 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold leading-none">E-Learning SD</h1>
                    <p class="text-xs text-blue-100">Platform Pembelajaran Digital</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <div class="hidden md:flex items-center bg-blue-700/50 px-4 py-2 rounded-full gap-3">
                        <div class="bg-gray-400 w-8 h-8 rounded-full flex items-center justify-center text-blue-900 font-bold">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="text-sm text-right">
                            <p class="font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-blue-200">
                                {{ Auth::user()->role == 'admin' ? 'Administrator' : 'Guru Pembimbing' }}
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 text-sm px-4 py-2 rounded-lg font-bold">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-300 py-12 mt-auto">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <i class="fa-solid fa-graduation-cap text-xl text-blue-500"></i>
                        <span class="font-bold text-lg">E-Learning SD</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-4">
                        Platform pembelajaran digital terpadu untuk sekolah dasar.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Menu Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">• Dashboard</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">• Hubungi Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Kontak Kami</h3>
                    <p class="text-sm text-slate-400">info@sekolah.id</p>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} E-Learning SD. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>