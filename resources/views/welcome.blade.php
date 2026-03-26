<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Equip Discipleship | Elshaddai Learning Center</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700,800|lato:300,400,700,900&display=swap" rel="stylesheet" />

    <!-- Laravel Vite -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Core CDNs (Force loaded to ensure landing page design stability regardless of local Vite cache) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Lato', 'sans-serif'],
                        heading: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                    }
                }
            }
        }
    </script>

    <style>
        body { background-color: #fffcf8; }

        @keyframes gentleRise {
            0%, 100% { transform: translateY(-3px); }
            50% { transform: translateY(3px); }
        }
        @keyframes floatHeaven {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(1deg); }
        }
        @keyframes glowSoft {
            0%, 100% { opacity: 0.3; transform: scale(1); filter: blur(30px); }
            50% { opacity: 0.5; transform: scale(1.05); filter: blur(40px); }
        }
        
        .animate-gentle-rise { animation: gentleRise 4s ease-in-out infinite; }
        .animate-float-heaven { animation: floatHeaven 8s ease-in-out infinite; }
        .animate-glow-soft { animation: glowSoft 5s ease-in-out infinite; }
        
        .verse-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #ffffff 0%, #fffaf5 100%);
            border: 1px solid #ffedd5;
        }
        .verse-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px -10px rgba(234, 88, 12, 0.15);
            border-color: #fdba74;
        }
        
        .bg-spiritual-pattern {
            background-image: radial-gradient(#fb923c 0.5px, transparent 0.5px), radial-gradient(#fb923c 0.5px, #fffcf8 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
    </style>
</head>

<body class="antialiased text-slate-800" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <header
        class="fixed w-full top-0 z-50 transition-all duration-300 border-b bg-white/90 py-5 border-transparent"
        :class="scrolled ? '!bg-white !shadow-md !py-3 !border-orange-100' : 'bg-white/90 py-5 border-transparent'"
        style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-heading font-bold text-lg sm:text-xl shadow-lg shadow-orange-500/30">
                        ESC
                    </div>
                    <div>
                        <span class="font-heading font-bold text-xl sm:text-2xl tracking-tight text-slate-900 block leading-none">Equip</span>
                        <span class="font-medium text-xs sm:text-sm text-orange-600 tracking-widest uppercase" style="font-size: 10px;">Discipleship</span>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                @if (Route::has('login'))
                <nav class="hidden md:flex items-center gap-8 font-medium">
                    <a href="#program" class="text-slate-600 hover:text-orange-600 transition-colors">Program</a>
                    <a href="#verses" class="text-slate-600 hover:text-orange-600 transition-colors">Firman</a>

                    <div class="h-6 w-px bg-slate-200"></div>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full text-orange-700 bg-orange-50 hover:bg-orange-100 font-semibold transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-orange-600 font-semibold transition-colors">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-full bg-orange-600 text-white font-semibold hover:bg-orange-700 shadow-md transition-all transform hover:-translate-y-1">Daftar Sekarang</a>
                        @endif
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-600 hover:text-orange-600 focus:outline-none p-2">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden bg-white border-b border-slate-200 absolute top-full left-0 w-full shadow-xl"
        >
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#program" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition-all">Program</a>
                <a href="#verses" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition-all">Firman</a>

                <div class="h-px bg-slate-100 my-4 mx-4"></div>

                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-4 py-3 rounded-xl bg-orange-50 text-orange-700 font-bold text-center">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-600 font-medium text-center transition-all">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-4 py-4 rounded-xl bg-orange-600 text-white font-bold text-center shadow-lg shadow-orange-200 mt-2">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="pt-24 sm:pt-28">
        <section class="relative overflow-hidden bg-transparent min-h-screen sm:min-h-[90vh] flex items-center">
            <!-- Background Ornaments -->
            <div class="absolute rounded-full bg-orange-100/60 pointer-events-none z-0" style="top: -8rem; right: -8rem; width: 500px; height: 500px; filter: blur(80px);"></div>
            <div class="absolute rounded-full bg-amber-200/40 pointer-events-none z-0" style="top: 50%; left: -8rem; width: 400px; height: 400px; filter: blur(80px);"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 lg:py-0 w-full">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                    <!-- Left Copy -->
                    <div class="max-w-2xl text-center lg:text-left mx-auto lg:mx-0">
                        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-orange-50 border border-orange-200 text-orange-700 font-medium text-sm mb-8 shadow-sm">
                            <span class="flex h-2.5 w-2.5 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-full w-full bg-orange-500"></span>
                            </span>
                            Pusat Pembelajaran Rohani & Pemuridan
                        </div>

                        <h1 class="text-5xl lg:text-6xl xl:text-7xl font-heading font-extrabold text-slate-900 leading-tight mb-8">
                            Transformasi <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 via-orange-500 to-amber-500">Hati & Pikiran</span>
                        </h1>

                        <p class="text-lg lg:text-xl text-slate-600 mb-10 leading-relaxed max-w-lg mx-auto lg:mx-0 font-light">
                            Temukan panggilan Tuhan dalam hidup Anda melalui sistem pembelajaran yang terstruktur, alkitabiah, dan transformatif bersama Elshaddai Church.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 rounded-full bg-orange-600 text-white font-bold text-lg hover:bg-orange-700 shadow-xl shadow-orange-500/30 transition-all transform hover:-translate-y-1">
                                Mulai Perjalanan Baru
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                            <a href="#program" class="inline-flex justify-center items-center px-8 py-4 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-bold text-lg hover:border-orange-500 hover:text-orange-600 transition-all">
                                Jelajahi Kelas
                            </a>
                        </div>

                        <!-- Mini Stats -->
                        <div class="mt-14 flex flex-wrap items-center justify-center lg:justify-start gap-8 text-sm text-slate-500 font-bold tracking-widest uppercase">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                </div>
                                <span class="leading-tight">Alkitabiah<br/>& Murni</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 border border-amber-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="leading-tight">Sistem<br/>Terstruktur</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Image Grid -->
                    <div class="relative w-full h-96 sm:h-[500px] lg:h-[600px] hidden lg:block">
                        <!-- Main Image Card -->
                        <div class="absolute top-1/2 right-4 transform -translate-y-1/2 w-4/5 h-[420px] bg-white rounded-3xl shadow-2xl p-3 z-20 animate-float-heaven border border-orange-50">
                            <div class="w-full h-full relative overflow-hidden rounded-2xl">
                                <img src="https://images.unsplash.com/photo-1490730141103-6cac27aaab94?auto=format&fit=crop&w=800&q=80" alt="Spiritual journey" class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            </div>

                            <!-- Floating Badge 1 -->
                            <div class="absolute -bottom-6 -left-8 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-gentle-rise" style="animation-delay: 1s;">
                                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-lg">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                </div>
                                <div class="pr-3">
                                    <p class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-1" style="font-size: 11px;">Pertumbuhan</p>
                                    <p class="font-heading font-bold text-slate-900 text-xl leading-none">Spiritual</p>
                                </div>
                            </div>

                            <!-- Floating Badge 2 -->
                            <div class="absolute -top-6 -right-6 bg-white px-5 py-4 rounded-2xl shadow-xl flex flex-col gap-2 animate-gentle-rise border border-slate-50">
                                <p class="text-xs uppercase tracking-widest text-slate-500 font-bold" style="font-size: 10px;">Komunitas Kita</p>
                                <div class="flex items-center gap-3">
                                    <div class="flex -space-x-2">
                                        <img class="w-8 h-8 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1544281679-0524cb51b7eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Community">
                                        <img class="w-8 h-8 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Student">
                                        <div class="w-8 h-8 rounded-full border-2 border-white bg-orange-100 flex items-center justify-center text-xs font-bold text-orange-700" style="font-size: 10px;">+1k</div>
                                    </div>
                                    <div class="text-sm font-bold text-slate-800">Murid</div>
                                </div>
                            </div>
                        </div>

                        <!-- Accent Blobs -->
                        <div class="absolute top-1/4 right-0 w-72 h-72 bg-amber-400 rounded-full mix-blend-multiply opacity-30 animate-float-heaven" style="filter: blur(60px); animation-delay: 2s;"></div>
                        <div class="absolute bottom-10 left-10 w-80 h-80 bg-orange-400 rounded-full mix-blend-multiply opacity-30 animate-float-heaven" style="filter: blur(60px); animation-delay: 3s;"></div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Stats Divider Sections -->
        <div class="py-14 bg-slate-900 text-white relative overflow-hidden" style="background-color: #1c1917;">
            <div class="absolute inset-0 pointer-events-none" style="opacity: 0.15;">
                <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-orange-500 rounded-full animate-glow-soft" style="filter: blur(100px);"></div>
                <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-amber-600 rounded-full animate-glow-soft" style="filter: blur(100px); animation-delay: 2.5s;"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-y-12 md:gap-y-0 text-center md:divide-x divide-white/10" style="border-color: rgba(255,255,255,0.1);">
                    <div class="px-4 border-r border-white/10 md:border-r-0" style="border-color: rgba(255,255,255,0.1);">
                        <p class="text-3xl sm:text-4xl md:text-5xl font-heading font-bold text-orange-400 mb-3 shadow-orange-500/20 drop-shadow-lg">3+</p>
                        <p class="text-slate-300 font-medium text-xs md:text-sm uppercase" style="letter-spacing: 0.2em;">Jenjang Kelas</p>
                    </div>
                    <div class="px-4 md:border-r-0">
                        <p class="text-3xl sm:text-4xl md:text-5xl font-heading font-bold text-orange-400 mb-3 drop-shadow-lg">100%</p>
                        <p class="text-slate-300 font-medium text-xs md:text-sm uppercase" style="letter-spacing: 0.2em;">Akses Online</p>
                    </div>
                    <div class="px-4 border-r border-white/10 md:border-r-0 pt-8 md:pt-0 border-t md:border-t-0 border-white/10 md:border-l-0" style="border-color: rgba(255,255,255,0.1);">
                        <p class="text-3xl sm:text-4xl md:text-5xl font-heading font-bold text-orange-400 mb-3 drop-shadow-lg">Materi</p>
                        <p class="text-slate-300 font-medium text-xs md:text-sm uppercase" style="letter-spacing: 0.2em;">Eksklusif Terbaru</p>
                    </div>
                    <div class="px-4 pt-8 md:pt-0 border-t border-white/10 md:border-t-0" style="border-color: rgba(255,255,255,0.1);">
                        <p class="text-3xl sm:text-4xl md:text-5xl font-heading font-bold text-orange-400 mb-3 drop-shadow-lg">24/7</p>
                        <p class="text-slate-300 font-medium text-xs md:text-sm uppercase" style="letter-spacing: 0.2em;">Platform Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bible Verses Section -->
        <section id="verses" class="py-28 relative overflow-hidden bg-spiritual-pattern" style="opacity: 0.95;">
             <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                 <div class="flex flex-col md:flex-row items-center justify-between mb-20 gap-10">
                     <div class="max-w-xl text-center md:text-left">
                         <h2 class="text-orange-600 font-bold uppercase mb-5 text-sm flex items-center justify-center md:justify-start gap-4" style="letter-spacing: 0.25em;">
                             <span class="w-12 h-0.5 bg-orange-300 rounded-full"></span> Makanan Rohani <span class="w-12 h-0.5 bg-orange-300 rounded-full md:hidden"></span>
                         </h2>
                         <h3 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 leading-tight">
                             Fondasi Kita dalam <br/>
                             <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500">Belajar & Bertumbuh</span>
                         </h3>
                     </div>
                     <div class="relative group w-full md:w-auto">
                        <div class="absolute -inset-1 bg-gradient-to-r from-orange-400 to-amber-400 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative px-7 py-7 bg-white ring-1 ring-orange-100 rounded-2xl shadow-xl flex flex-col sm:flex-row items-center sm:divide-x divide-y sm:divide-y-0 divide-orange-100 gap-5 sm:gap-0">
                            <div class="flex items-center space-x-4 sm:pr-8 text-center sm:text-left">
                                <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="text-slate-700 italic font-heading text-lg">"Bertumbuh dalam pengenalan akan Tuhan."</span>
                            </div>
                            <div class="sm:pl-8 pt-5 sm:pt-0 text-orange-600 font-bold whitespace-nowrap tracking-wider">2 Petrus 3:18</div>
                        </div>
                     </div>
                 </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Verse Card 1 -->
                    <div class="verse-card p-10 rounded-3xl" style="border-radius: 2rem;">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-orange-500 shadow-md mb-8 border border-orange-50">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
                        </div>
                        <p class="text-slate-700 leading-relaxed mb-8 font-heading text-xl font-medium italic">
                            "Takut akan TUHAN adalah permulaan pengetahuan, tetapi orang bodoh menghina hikmat dan didikan."
                        </p>
                        <div class="pt-6 border-t border-orange-100 flex items-center gap-3">
                            <div class="w-8 h-0.5 bg-orange-400"></div>
                            <p class="font-bold text-orange-600 tracking-wider">Amsal 1:7</p>
                        </div>
                    </div>

                    <!-- Verse Card 2 -->
                    <div class="verse-card bg-gradient-to-br from-orange-600 to-amber-600 p-10 rounded-3xl text-white shadow-xl transform hover:-translate-y-2 transition-transform duration-500 border-none" style="border-radius: 2rem; box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.2);">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-white shadow-sm mb-8 backdrop-blur-md border border-white/30">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
                        </div>
                        <p class="text-white leading-relaxed mb-8 font-heading text-xl font-medium italic">
                            "Hati orang berpengertian memperoleh pengetahuan, dan telinga orang bijak menuntut pengetahuan."
                        </p>
                        <div class="pt-6 border-t border-white/20 flex items-center gap-3">
                            <div class="w-8 h-0.5 bg-white text-white"></div>
                            <p class="font-bold text-white tracking-wider">Amsal 18:15</p>
                        </div>
                    </div>

                    <!-- Verse Card 3 -->
                    <div class="verse-card p-10 rounded-3xl" style="border-radius: 2rem;">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-orange-500 shadow-md mb-8 border border-orange-50">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
                        </div>
                        <p class="text-slate-700 leading-relaxed mb-8 font-heading text-xl font-medium italic">
                            "Berilah orang bijak nasihat, maka ia akan menjadi lebih bijak, ajarilah orang benar..."
                        </p>
                        <div class="pt-6 border-t border-orange-100 flex items-center gap-3">
                            <div class="w-8 h-0.5 bg-orange-400"></div>
                            <p class="font-bold text-orange-600 tracking-wider">Amsal 9:9</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Program Section -->
        <section id="program" class="py-28 bg-white relative overflow-hidden text-center md:text-left">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 bg-orange-50/80 rounded-full pointer-events-none" style="filter: blur(120px); width: 600px; height: 600px;"></div>
            <div class="absolute bottom-0 left-0 bg-amber-50/50 rounded-full pointer-events-none" style="filter: blur(100px); width: 400px; height: 400px;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <h2 class="text-orange-600 font-bold uppercase mb-4 text-sm flex items-center justify-center gap-3" style="letter-spacing: 0.2em;">
                        <span class="w-10 h-0.5 bg-orange-300"></span> Kurikulum Kami <span class="w-10 h-0.5 bg-orange-300"></span>
                    </h2>
                    <h3 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 mb-6 leading-tight">
                        Sistem Edukasi Terstruktur
                    </h3>
                    <p class="text-lg text-slate-500 font-light">
                        Disusun secara sistematis agar setiap individu dapat bertumbuh dari dasar keyakinan hingga menjadi pemimpin di dalam Tuhan.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 xl:gap-10 relative">
                    <!-- Card 1 -->
                    <div class="relative bg-white p-10 shadow-xl border border-slate-100 z-10 transition-all duration-500 hover:-translate-y-4 group overflow-hidden" style="border-radius: 2.5rem; box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.4);">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-16 -mt-16 transition-all duration-700 ease-out z-0" style="transform: scale(1);" onMouseOver="this.style.transform='scale(2)'" onMouseOut="this.style.transform='scale(1)'"></div>

                        <div class="w-16 h-16 bg-white text-orange-500 rounded-2xl flex items-center justify-center mb-8 border border-orange-100 transition-all duration-300 shadow-sm relative z-10 hover:bg-orange-500 hover:text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>

                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-4 transition-colors relative z-10 hover:text-orange-600">Equip - New</h4>
                        <p class="text-slate-500 leading-relaxed mb-10 relative z-10 font-light">
                            Membangun pondasi rohani lewat <strong class="text-slate-700 font-semibold">Membership Class</strong> dan <strong class="text-slate-700 font-semibold">Foundation Class</strong>. Memahami dasar keselamatan dan iman Kristen.
                        </p>

                        <div class="relative z-10 mt-auto">
                            <span class="inline-flex py-2 px-5 rounded-full bg-slate-50 text-slate-600 font-bold uppercase border border-slate-100 transition-colors hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700" style="font-size: 10px; letter-spacing: 0.1em;">Tahap 1 | Dasar</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="relative bg-white p-10 shadow-xl border border-slate-100 z-10 transition-all duration-500 hover:-translate-y-4 group overflow-hidden" style="border-radius: 2.5rem; box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.4);">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-100/50 rounded-bl-full -mr-16 -mt-16 transition-all duration-700 ease-out z-0" style="transform: scale(1);" onMouseOver="this.style.transform='scale(2)'" onMouseOut="this.style.transform='scale(1)'"></div>

                        <div class="w-16 h-16 bg-white text-orange-600 rounded-2xl flex items-center justify-center mb-8 border border-orange-200 transition-all duration-300 shadow-md relative z-10 hover:bg-orange-600 hover:text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>

                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-4 transition-colors relative z-10 hover:text-orange-600">Equip - Grow</h4>
                        <p class="text-slate-500 leading-relaxed mb-10 relative z-10 font-light">
                            Pendalaman rohani melalui <strong class="text-slate-700 font-semibold">Grade 1 (The Cross)</strong> dan <strong class="text-slate-700 font-semibold">Grade 2 (The Power)</strong>. Mengalami kuasa salib dan Roh Kudus.
                        </p>

                        <div class="relative z-10 mt-auto">
                            <span class="inline-flex py-2 px-5 rounded-full bg-slate-50 text-slate-600 font-bold uppercase border border-slate-100 transition-colors hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700" style="font-size: 10px; letter-spacing: 0.1em;">Tahap 2 | Pertumbuhan</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="relative bg-white p-10 shadow-xl border border-slate-100 z-10 transition-all duration-500 hover:-translate-y-4 group overflow-hidden" style="border-radius: 2.5rem; box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.4);">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-full -mr-16 -mt-16 transition-all duration-700 ease-out z-0" style="transform: scale(1);" onMouseOver="this.style.transform='scale(2)'" onMouseOut="this.style.transform='scale(1)'"></div>

                        <div class="w-16 h-16 bg-white text-amber-500 rounded-2xl flex items-center justify-center mb-8 border border-amber-100 transition-all duration-300 shadow-sm relative z-10 hover:bg-amber-500 hover:text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>

                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-4 transition-colors relative z-10 hover:text-amber-600">Equip - Lead</h4>
                        <p class="text-slate-500 leading-relaxed mb-10 relative z-10 font-light">
                            Berakar untuk berbuah lewat <strong class="text-slate-700 font-semibold">Volunteer Class</strong> dan <strong class="text-slate-700 font-semibold">Leadership Class</strong>. Dipersiapkan menjadi pemimpin yang berdampak.
                        </p>

                        <div class="relative z-10 mt-auto">
                            <span class="inline-flex py-2 px-5 rounded-full bg-slate-50 text-slate-600 font-bold uppercase border border-slate-100 transition-colors hover:border-amber-200 hover:bg-amber-50 hover:text-amber-700" style="font-size: 10px; letter-spacing: 0.1em;">Tahap 3 | Dampak</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic CTA -->
        <section class="py-24 relative" style="background-color: #fffcf8;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative bg-orange-600 overflow-hidden shadow-2xl" style="border-radius: 3rem;">
                    <!-- Dynamic BG -->
                    <div class="absolute inset-0" style="background-image: url('https://images.unsplash.com/photo-1519750058913-94c6fbc4b256?auto=format&fit=crop&w=2000&q=80'); background-size: cover; background-position: center; opacity: 0.15; mix-blend-mode: overlay;"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-orange-800 to-orange-500/80"></div>

                    <!-- Decorative Light -->
                    <div class="absolute rounded-full bg-white opacity-20 pointer-events-none" style="top: -5rem; right: -5rem; width: 400px; height: 400px; filter: blur(80px);"></div>
                    <div class="absolute rounded-full pointer-events-none" style="bottom: -5rem; left: -5rem; width: 300px; height: 300px; background-color: rgba(253, 230, 138, 0.2); filter: blur(80px);"></div>

                    <div class="relative z-10 p-12 lg:p-20 flex flex-col lg:flex-row items-center justify-between text-center lg:text-left gap-10">
                        <div class="max-w-3xl">
                            <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-white mb-6 leading-tight">
                                Siap Untuk Bertumbuh?
                            </h2>
                            <p class="text-orange-100 text-lg md:text-xl mb-0 max-w-2xl font-light">
                                Bergabunglah bersama ratusan jemaat lainnya dan mulailah perjalanan kedewasaan rohani Anda hari ini.
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-9 py-5 bg-white text-orange-600 font-bold text-lg rounded-full hover:bg-orange-50 transition-all shadow-xl transform hover:scale-105" style="box-shadow: 0 20px 25px -5px rgba(124, 45, 18, 0.4);">
                                Buat Akun Sekarang
                                <svg class="ml-3 w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white pt-16 border-t border-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 lg:gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-heading font-bold text-xl shadow-md border border-orange-300/30">
                            ESC
                        </div>
                        <span class="font-heading font-bold text-2xl text-slate-900">Equip <span class="text-orange-600">Discipleship</span></span>
                    </div>
                    <p class="text-slate-500 leading-relaxed max-w-sm font-light">
                        Platform edukasi dan pemuridan terpadu dari Elshaddai Church, memampukan setiap jemaat untuk bertumbuh dari anggota menjadi pembuat murid.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase tracking-widest" style="font-size: 11px;">Tautan Cepat</h4>
                    <ul class="space-y-4">
                        <li><a href="#program" class="text-slate-500 hover:text-orange-600 font-medium transition-colors">Program Kelas</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-orange-600 font-medium transition-colors">Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-500 hover:text-orange-600 font-medium transition-colors">Daftar Baru</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase tracking-widest" style="font-size: 11px;">Kontak</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4 text-slate-500 font-medium">
                            <svg class="w-5 h-5 text-orange-400 flex-shrink-0" style="margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="leading-relaxed">Gedung Elshaddai<br/>Kalimantan Barat, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between">
                <p class="text-slate-400 text-sm font-light">
                    &copy; {{ date('Y') }} Elshaddai Church. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
