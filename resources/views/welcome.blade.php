<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elshaddai Learning Center</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Include basic tailwind via CDN fallback -->
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    <!-- Navbar -->
    <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- Logo Placehoder -->
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-lg flex justify-center items-center font-bold text-white shadow-md">
                    <span>EL</span>
                </div>
                <span class="font-bold text-xl tracking-tight text-gray-900">Elshaddai <span class="text-indigo-600">LMS</span></span>
            </div>
            
            @if (Route::has('login'))
                <nav class="-mx-3 flex flex-1 justify-end font-medium">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md px-4 py-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-4 py-2 text-gray-600 hover:text-indigo-600 transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md px-4 py-2 ml-2 bg-indigo-600 text-white hover:bg-indigo-700 shadow flex items-center transition-transform hover:-translate-y-0.5">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow">
        <div class="relative overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto md:min-h-[500px] flex items-center">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10 sm:pt-16 lg:pt-20">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:text-center lg:text-left">
                            <span class="inline-block py-1.5 px-4 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold mb-5 border border-indigo-100 shadow-sm">
                                🌟 Fasilitas Pembelajaran Online
                            </span>
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-5xl lg:text-6xl">
                                <span class="block xl:inline">Bertumbuh Dalam</span>
                                <span class="block text-indigo-600 xl:inline leading-tight">Iman & Pengetahuan</span>
                            </h1>
                            <p class="mt-4 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 leading-relaxed">
                                Selamat datang di ruang kelas Elshaddai Church. Persiapkan diri Anda untuk menempuh jenjang kedewasaan rohani melalui <strong>Foundation Class</strong>, <strong>Equip Series</strong>, hingga <strong>Leadership Class</strong>!
                            </p>
                            <div class="mt-6 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-lg shadow-lg">
                                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg md:px-10 transition-all hover:shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-0.5">
                                        Mulai Belajar
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-4">
                                    <a href="#program" class="w-full flex items-center justify-center px-8 py-3.5 border text-base font-semibold rounded-lg text-gray-700 bg-white border-gray-200 hover:bg-gray-50 hover:border-gray-300 md:text-lg md:px-10 transition-colors">
                                        Lihat Program
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gray-50 hidden lg:block overflow-hidden">
                <img class="h-full w-full object-cover object-center transform scale-105" src="https://images.unsplash.com/photo-1491841550275-ad7854e35ca6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1400&q=80" alt="People studying learning">
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/40 to-transparent"></div>
            </div>
        </div>

        <!-- System/Features Section -->
        <div id="program" class="py-16 bg-gray-50 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-indigo-600 font-bold tracking-widest uppercase">Jenjang Pembelajaran</h2>
                    <p class="mt-2 text-3xl leading-snug font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Sistem Edukasi Terstruktur
                    </p>
                    <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto">
                        Materi yang dirancang khusus untuk memastikan setiap jemaat bertumbuh secara bertahap, terukur, dan berdampak bagi sesama.
                    </p>
                </div>

                <div class="mt-16">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                        <!-- Card 1 -->
                        <div class="relative bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                            <dt>
                                <div class="absolute flex items-center justify-center h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <p class="ml-20 text-xl leading-6 font-bold text-gray-900">Equip - New</p>
                            </dt>
                            <dd class="mt-4 ml-20 text-base text-gray-500 leading-relaxed">
                                Kelas fondasi awal seperti <strong>Membership Class</strong> dan <strong>Foundation Class</strong> untuk membangun dasar keselamatan dan gaya hidup Ilahi.
                            </dd>
                        </div>
                        
                        <!-- Card 2 -->
                        <div class="relative bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                            <dt>
                                <div class="absolute flex items-center justify-center h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <p class="ml-20 text-xl leading-6 font-bold text-gray-900">Equip - Grow / Plant</p>
                            </dt>
                            <dd class="mt-4 ml-20 text-base text-gray-500 leading-relaxed">
                                Pendalaman rohani melalui kelas <strong>Grade 1 (The Cross)</strong>, <strong>Grade 2 (The Power)</strong>, serta persiapan masa depan dalam <strong>Married Class</strong>.
                            </dd>
                        </div>

                        <!-- Card 3 -->
                        <div class="relative bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
                            <dt>
                                <div class="absolute flex items-center justify-center h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="ml-20 text-xl leading-6 font-bold text-gray-900">Equip - Serve & Lead</p>
                            </dt>
                            <dd class="mt-4 ml-20 text-base text-gray-500 leading-relaxed">
                                Berakar untuk berbuah lewat <strong>Volunteer Class</strong>, <strong>Leadership Class</strong>, dan <strong>Disciple Maker Training (DMT)</strong>.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        
        <!-- CTA -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="bg-indigo-700 rounded-[2rem] shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-700 to-indigo-900"></div>
                <!-- Decorative Circles -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-indigo-500 opacity-20 rounded-full blur-2xl"></div>
                
                <div class="py-12 px-6 sm:px-12 lg:py-16 lg:px-16 lg:flex lg:items-center lg:justify-between relative z-10">
                    <div class="max-w-xl">
                        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            <span class="block">Siap untuk bertumbuh?</span>
                        </h2>
                        <p class="mt-4 text-lg text-indigo-100">
                            Bergabunglah bersama ratusan jemaat lainnya dan mulailah perjalanan kedewasaan rohani Anda hari ini.
                        </p>
                    </div>
                    <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                        <div class="inline-flex rounded-lg shadow">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-4 border border-transparent text-lg font-bold rounded-lg text-indigo-700 bg-white hover:bg-gray-50 hover:scale-105 transition-transform shadow-lg">
                                Buat Akun Sekarang &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center gap-2 mb-4 md:mb-0">
                <span class="font-bold text-lg text-gray-900">Elshaddai <span class="text-indigo-600">LMS</span></span>
            </div>
            <p class="text-sm text-gray-500 font-medium">
                &copy; {{ date('Y') }} Elshaddai Church. Hak Cipta Dilindungi.
            </p>
        </div>
    </footer>
</body>
</html>
