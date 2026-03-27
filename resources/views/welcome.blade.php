<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ESC Learning Center</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700,800|lato:300,400,700,900&display=swap" rel="stylesheet" />

    <!-- Laravel Vite -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Core CDNs (Force loaded to ensure landing page design stability) -->
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
                            50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74', 400: '#fb923c',
                            500: '#f97316', 600: '#ea580c', 700: '#c2410c', 800: '#9a3412', 900: '#7c2d12',
                        },
                    }
                }
            }
        }
    </script>

    <style>
        body { background-color: #fffcf8; }

        @keyframes gentleRise { 0%, 100% { transform: translateY(-3px); } 50% { transform: translateY(3px); } }
        @keyframes floatHeaven { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-15px) rotate(1deg); } }
        @keyframes glowSoft { 0%, 100% { opacity: 0.3; transform: scale(1); filter: blur(30px); } 50% { opacity: 0.5; transform: scale(1.05); filter: blur(40px); } }
        
        .animate-gentle-rise { animation: gentleRise 4s ease-in-out infinite; }
        .animate-float-heaven { animation: floatHeaven 8s ease-in-out infinite; }
        .animate-glow-soft { animation: glowSoft 5s ease-in-out infinite; }
        
        .verse-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #ffffff 0%, #fffaf5 100%);
            border: 1px solid #ffedd5;
        }
        .verse-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 20px 40px -10px rgba(234, 88, 12, 0.15); border-color: #fdba74; }
        
        .bg-spiritual-pattern {
            background-image: radial-gradient(#fb923c 0.5px, transparent 0.5px), radial-gradient(#fb923c 0.5px, #fffcf8 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
    </style>
</head>

<body class="antialiased text-slate-800" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <header class="fixed w-full top-0 z-50 transition-all duration-300 border-b bg-white/90 py-5 border-transparent"
        :class="scrolled ? '!bg-white !shadow-md !py-3 !border-orange-100' : 'bg-white/90 py-5 border-transparent'"
        style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
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
                    <a href="#profile" class="text-slate-600 hover:text-orange-600 transition-colors">Profil</a>
                    <a href="#program" class="text-slate-600 hover:text-orange-600 transition-colors">Program</a>

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

        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-b border-slate-200 absolute top-full left-0 w-full shadow-xl">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#profile" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition-all">Profil</a>
                <a href="#program" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition-all">Program</a>
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

    <main class="pt-24 sm:pt-28">
        
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-transparent min-h-screen sm:min-h-[90vh] flex items-center">
            <div class="absolute rounded-full bg-orange-100/60 pointer-events-none z-0" style="top: -8rem; right: -8rem; width: 500px; height: 500px; filter: blur(80px);"></div>
            <div class="absolute rounded-full bg-amber-200/40 pointer-events-none z-0" style="top: 50%; left: -8rem; width: 400px; height: 400px; filter: blur(80px);"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 lg:py-0 w-full">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                    <div class="max-w-2xl text-center lg:text-left mx-auto lg:mx-0">
                        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-orange-50 border border-orange-200 text-orange-700 font-medium text-sm mb-8 shadow-sm">
                            <span class="flex h-2.5 w-2.5 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-full w-full bg-orange-500"></span>
                            </span>
                            Selamat Datang di ESC Learning Center
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
                            <a href="#profile" class="inline-flex justify-center items-center px-8 py-4 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-bold text-lg hover:border-orange-500 hover:text-orange-600 transition-all">
                                Pelajari Sistem Kami
                            </a>
                        </div>
                    </div>

                    <div class="relative w-full h-96 sm:h-[500px] lg:h-[600px] hidden lg:block">
                        <div class="absolute top-1/2 right-4 transform -translate-y-1/2 w-4/5 h-[420px] bg-white rounded-3xl shadow-2xl p-3 z-20 animate-float-heaven border border-orange-50">
                            <div class="w-full h-full relative overflow-hidden rounded-2xl">
                                <img src="https://images.unsplash.com/photo-1490730141103-6cac27aaab94?auto=format&fit=crop&w=800&q=80" alt="Spiritual journey" class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            </div>

                            <div class="absolute -bottom-6 -left-8 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-gentle-rise" style="animation-delay: 1s;">
                                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-lg">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                </div>
                                <div class="pr-3">
                                    <p class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-1" style="font-size: 11px;">Pertumbuhan</p>
                                    <p class="font-heading font-bold text-slate-900 text-xl leading-none">Spiritual</p>
                                </div>
                            </div>
                        </div>
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
                <div class="space-y-12">
                    <!-- Section 1: Demografi Jemaat -->
                    <div>
                        <h3 class="text-lg font-semibold text-orange-300/80 uppercase tracking-widest mb-6 flex items-center justify-center gap-3">
                            <i class="fas fa-users text-orange-400"></i> Demografi Jemaat & Pemuridan
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition duration-300">
                                <p class="text-4xl font-heading font-bold text-white mb-1">{{ $stats['users_member'] }}</p>
                                <p class="text-orange-300 font-medium text-[10px] sm:text-xs uppercase tracking-widest">Total Member</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition duration-300">
                                <p class="text-4xl font-heading font-bold text-white mb-1">{{ $stats['users_ctt'] }}</p>
                                <p class="text-orange-300 font-medium text-[10px] sm:text-xs uppercase tracking-widest">Core Team (CTT)</p>
                            </div>
                            <div class="bg-orange-500/20 backdrop-blur-md border border-orange-500/30 rounded-2xl p-6 text-center shadow-[0_0_20px_rgba(249,115,22,0.15)] hover:bg-orange-500/30 transition duration-300 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-tr from-orange-500/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                                <p class="text-4xl font-heading font-bold text-orange-400 mb-1 drop-shadow-md position-relative z-10">{{ $stats['users_dm'] }}</p>
                                <p class="text-orange-200 font-medium text-[10px] sm:text-xs uppercase tracking-widest position-relative z-10">Disciple Maker</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition duration-300">
                                <p class="text-4xl font-heading font-bold text-white mb-1">{{ $stats['users_fasilitator'] }}</p>
                                <p class="text-orange-300 font-medium text-[10px] sm:text-xs uppercase tracking-widest">Fasilitator</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                        <!-- Section 2: Fase Pertumbuhan -->
                        <div class="bg-black/20 rounded-3xl p-6 border border-white/5">
                            <h3 class="text-sm font-semibold text-orange-300/80 uppercase tracking-widest mb-6 flex items-center justify-center lg:justify-start gap-3">
                                <i class="fas fa-seedling text-orange-400"></i> Distribusi Fase Equip
                            </h3>
                            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                                <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center hover:border-orange-500/30 transition-colors">
                                    <p class="text-2xl font-bold text-orange-400 mb-1">{{ $stats['users_new'] }}</p>
                                    <p class="text-slate-300 text-[10px] sm:text-xs uppercase tracking-wider">Fase New</p>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center hover:border-orange-500/30 transition-colors">
                                    <p class="text-2xl font-bold text-orange-400 mb-1">{{ $stats['users_plant'] }}</p>
                                    <p class="text-slate-300 text-[10px] sm:text-xs uppercase tracking-wider">Fase Plant</p>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center hover:border-orange-500/30 transition-colors">
                                    <p class="text-2xl font-bold text-orange-400 mb-1">{{ $stats['users_grow'] }}</p>
                                    <p class="text-slate-300 text-[10px] sm:text-xs uppercase tracking-wider">Fase Grow</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Modul Kelas -->
                        <div class="bg-black/20 rounded-3xl p-6 border border-white/5">
                            <h3 class="text-sm font-semibold text-orange-300/80 uppercase tracking-widest mb-6 flex items-center justify-center lg:justify-start gap-3">
                                <i class="fas fa-book-open text-orange-400"></i> Integrasi Kurikulum (Total: {{ $stats['total_kelas'] }})
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 md:gap-4">
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                                    <p class="text-xl font-bold text-white mb-0">{{ $stats['kelas_community'] }}</p>
                                    <p class="text-slate-400 text-[10px] uppercase">Community</p>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                                    <p class="text-xl font-bold text-white mb-0">{{ $stats['kelas_equip_new'] }}</p>
                                    <p class="text-slate-400 text-[10px] uppercase">Eq: New</p>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                                    <p class="text-xl font-bold text-white mb-0">{{ $stats['kelas_equip_plant'] }}</p>
                                    <p class="text-slate-400 text-[10px] uppercase">Eq: Plant</p>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                                    <p class="text-xl font-bold text-white mb-0">{{ $stats['kelas_equip_grow'] }}</p>
                                    <p class="text-slate-400 text-[10px] uppercase">Eq: Grow</p>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center sm:col-span-2">
                                    <p class="text-xl font-bold text-white mb-0">{{ $stats['kelas_equip_leadership'] }}</p>
                                    <p class="text-slate-400 text-[10px] uppercase">Leadership / DMT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW: Profil Learning Center & Metode Belajar -->
        <section id="profile" class="py-24 bg-white relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 bg-orange-50/80 rounded-full pointer-events-none" style="filter: blur(120px); width: 500px; height: 500px;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-4xl mx-auto mb-16">
                    <h2 class="text-orange-600 font-bold uppercase mb-4 text-sm flex items-center justify-center gap-3" style="letter-spacing: 0.2em;">
                        <span class="w-10 h-0.5 bg-orange-300"></span> Profil Learning Center <span class="w-10 h-0.5 bg-orange-300"></span>
                    </h2>
                    <h3 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 mb-6 leading-tight">
                        Dua Titik Fokus Pertumbuhan Kehidupan Keimanan Jemaat
                    </h3>
                    <p class="text-lg text-slate-500 font-light mb-8 max-w-3xl mx-auto">
                        Learning Center kami dirancang khusus sebagai sarana bagi jemaat yang ingin bertumbuh. Kami memfasilitasi Anda melalui dua jalur utama: menjadi pemimpin yang efektif atau memperdalam iman spiritual secara personal.
                    </p>
                </div>

                <!-- Two Growth Paths -->
                <div class="grid md:grid-cols-2 gap-8 mb-20 relative z-10">
                    <!-- Path 1: Kepemimpinan -->
                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-[2rem] p-8 md:p-10 border border-orange-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-white text-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-orange-200">
                            <!-- Leader Icon -->
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-3">Jalur Kepemimpinan Sel</h4>
                        <p class="text-slate-600 font-light leading-relaxed mb-6">
                            Bagi jemaat yang terpanggil untuk menjadi <strong>Pemimpin Kelompok Sel</strong> yang efektif. Anda akan diperlengkapi dengan kurikulum kepemimpinan dan teknik fasilitasi yang aplikatif.
                        </p>
                        <div class="flex gap-3 flex-wrap">
                            <span class="px-5 py-2 bg-orange-600 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-md">Kelas CTT</span>
                            <span class="px-5 py-2 bg-orange-600 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-md">Kelas DMT</span>
                        </div>
                    </div>

                    <!-- Path 2: Pertumbuhan Iman -->
                    <div class="bg-gradient-to-br from-amber-50 to-white rounded-[2rem] p-8 md:p-10 border border-amber-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-white text-amber-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-amber-200">
                            <!-- Spritual Icon -->
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-3">Jalur Pertumbuhan Iman</h4>
                        <p class="text-slate-600 font-light leading-relaxed mb-6">
                            Bagi seluruh jemaat yang rindu untuk mendalami kebenaran Firman, memulihkan kerohanian, dan bertumbuh dalam pengenalan akan Tuhan secara intensional.
                        </p>
                        <div class="flex gap-3 flex-wrap items-center">
                            <span class="px-5 py-2 bg-amber-500 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-md">Kelas FC 1</span>
                            <span class="px-5 py-2 bg-amber-500 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-md">Kelas FC 2</span>
                            <span class="px-4 text-amber-700 text-xs font-bold tracking-wider">& Seterusnya</span>
                        </div>
                    </div>
                </div>

                <!-- Explanation of Hybrid Approach -->
                <div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-14 border border-slate-800 shadow-2xl relative overflow-hidden" style="background-color: #1c1917;">
                    <!-- Light Glow -->
                    <div class="absolute top-0 right-0 rounded-full opacity-20 pointer-events-none" style="background-color: #f97316; filter: blur(100px); width: 400px; height: 400px; transform: translate(30%, -30%);"></div>
                    
                    <div class="flex flex-col lg:flex-row gap-12 items-center relative z-10">
                        <!-- Text -->
                        <div class="flex-1">
                            <span class="inline-block py-1.5 px-4 rounded-full bg-orange-500/20 text-orange-400 font-bold uppercase tracking-widest mb-4" style="font-size: 10px;">SISTEM KAMI</span>
                            <h4 class="text-3xl md:text-4xl font-heading font-bold text-white mb-6 leading-tight">Semua Dimulai Lewat Ruang Layar, Disempurnakan di <span class="text-orange-400">Ruang Pertemuan</span></h4>
                            <p class="text-slate-300 font-light leading-relaxed mb-6">
                                Pemuridan tidak sempurna jika hanya dilakukan secara mandiri. Untuk itu, setiap jemaat menggunakan sistem **Hybrid Learning** yang wajib diikuti.
                            </p>
                            <p class="text-slate-300 font-light leading-relaxed">
                                Setelah Anda menyelesaikan seluruh kurikulum video dan materi di <strong>Kelas Online</strong>, Anda DIHARUSKAN hadir pada pertemuan langsung (<strong>Kelas Onsite</strong>). Di sanalah fasilitator kami mendampingi diskusi mendalam agar kebenaran online menjadi aplikasi yang nyata.
                            </p>
                        </div>
                        
                        <!-- Visual representation of flow -->
                        <div class="flex-1 w-full flex flex-col gap-3">
                            <!-- Step 1 (Online) -->
                            <div class="bg-white/10 rounded-2xl p-6 border border-white/10 flex items-start gap-5 transform transition hover:-translate-y-1 backdrop-blur-sm">
                                <div class="w-12 h-12 rounded-xl bg-orange-500/20 text-orange-400 flex items-center justify-center font-bold text-xl flex-shrink-0 border border-orange-500/30">1</div>
                                <div>
                                    <h5 class="font-bold text-white text-lg mb-1">Eksplorasi Kelas Online</h5>
                                    <p class="text-sm text-slate-300 font-light leading-relaxed">Pahami panduan melalui video interaktif, kuis, dan jurnal pembelajaran mandiri. Selesaikan hingga tuntas 100%.</p>
                                </div>
                            </div>
                            
                            <!-- Down Arrow indicator -->
                            <div class="flex justify-center -my-3 opacity-60 relative z-20">
                                <div class="w-10 h-10 rounded-full bg-orange-600 flex items-center justify-center border-4 border-[#1c1917]">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                </div>
                            </div>
                            
                            <!-- Step 2 (Onsite) -->
                            <div class="bg-gradient-to-br from-orange-600 to-orange-500 rounded-2xl p-6 shadow-xl flex items-start gap-5 transform transition hover:-translate-y-1">
                                <div class="w-12 h-12 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold text-xl flex-shrink-0 border border-white/30 backdrop-blur-sm shadow-inner">2</div>
                                <div>
                                    <h5 class="font-bold text-white text-lg mb-1">Diskusi & Fasilitasi Onsite</h5>
                                    <p class="text-sm text-orange-100 font-light leading-relaxed">Akses ke kelas fisik akan terbuka. Bergabunglah untuk membahas, berbagi, dan di-fasilitasi dengan para mentor kami.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Program Section (Refactored to 4 Stages) -->
        <section id="program" class="py-28 relative overflow-hidden text-center md:text-left" style="background-color: #fffcf8;">
            <div class="absolute top-0 right-0 bg-orange-50/80 rounded-full pointer-events-none" style="filter: blur(120px); width: 600px; height: 600px;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <h2 class="text-orange-600 font-bold uppercase mb-4 text-sm flex items-center justify-center gap-3" style="letter-spacing: 0.2em;">
                        <span class="w-10 h-0.5 bg-orange-300"></span> Kurikulum Detail <span class="w-10 h-0.5 bg-orange-300"></span>
                    </h2>
                    <h3 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 mb-6 leading-tight">
                        Rincian Empat Tahap Pembelajaran
                    </h3>
                    <p class="text-lg text-slate-500 font-light">
                        Pembelajaran dibagi ke dalam empat level yang sistematis sesuai dengan kerinduan dan kesiapan tahapan Anda.
                    </p>
                </div>

                <!-- 4 Columns Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 xl:gap-8 relative">
                    <!-- Card 1: Dasar -->
                    <div class="relative bg-white p-8 shadow-xl border border-slate-100 z-10 transition-all duration-500 hover:-translate-y-3 group overflow-hidden flex flex-col h-full" style="border-radius: 2rem; box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.4);">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-50 rounded-bl-full -mr-12 -mt-12 transition-all duration-700 ease-out z-0" style="transform: scale(1);" onMouseOver="this.style.transform='scale(2)'" onMouseOut="this.style.transform='scale(1)'"></div>

                        <div class="w-14 h-14 bg-white text-orange-500 rounded-2xl flex items-center justify-center mb-6 border border-orange-100 transition-all duration-300 shadow-sm relative z-10 group-hover:bg-orange-500 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>

                        <h4 class="text-xl font-heading font-bold text-slate-900 mb-3 transition-colors relative z-10 group-hover:text-orange-600">Tahap Dasar</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 relative z-10 font-light flex-grow">
                            Membangun fondasi awal melalui <strong class="text-slate-700 font-semibold">Membership Class</strong> dan <strong class="text-slate-700 font-semibold">Foundation Class 1</strong>. Memahami dasar keselamatan & iman Kristen.
                        </p>

                        <div class="relative z-10 mt-auto">
                            <span class="inline-flex py-1.5 px-4 rounded-full bg-slate-50 text-slate-600 font-bold uppercase border border-slate-100 transition-colors group-hover:border-orange-200 group-hover:bg-orange-50 group-hover:text-orange-700" style="font-size: 10px; letter-spacing: 0.1em;">Level 1</span>
                        </div>
                    </div>

                    <!-- Card 2: Tertanam -->
                    <div class="relative bg-white p-8 shadow-xl border border-slate-100 z-10 transition-all duration-500 hover:-translate-y-3 group overflow-hidden flex flex-col h-full" style="border-radius: 2rem; box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.4);">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-100/50 rounded-bl-full -mr-12 -mt-12 transition-all duration-700 ease-out z-0" style="transform: scale(1);" onMouseOver="this.style.transform='scale(2)'" onMouseOut="this.style.transform='scale(1)'"></div>

                        <div class="w-14 h-14 bg-white text-orange-600 rounded-2xl flex items-center justify-center mb-6 border border-orange-200 transition-all duration-300 shadow-md relative z-10 group-hover:bg-orange-600 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>

                        <h4 class="text-xl font-heading font-bold text-slate-900 mb-3 transition-colors relative z-10 group-hover:text-orange-600">Tahap Tertanam</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 relative z-10 font-light flex-grow">
                            Pengakaran mendalam pada kebenaran firman Tuhan melalui <strong class="text-slate-700 font-semibold">Foundation Class 2</strong> dan <strong class="text-slate-700 font-semibold">Foundation Class 3</strong>.
                        </p>

                        <div class="relative z-10 mt-auto">
                            <span class="inline-flex py-1.5 px-4 rounded-full bg-slate-50 text-slate-600 font-bold uppercase border border-slate-100 transition-colors group-hover:border-orange-200 group-hover:bg-orange-50 group-hover:text-orange-700" style="font-size: 10px; letter-spacing: 0.1em;">Level 2</span>
                        </div>
                    </div>

                    <!-- Card 3: Pertumbuhan -->
                    <div class="relative bg-white p-8 shadow-xl border border-slate-100 z-10 transition-all duration-500 hover:-translate-y-3 group overflow-hidden flex flex-col h-full" style="border-radius: 2rem; box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.4);">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-12 -mt-12 transition-all duration-700 ease-out z-0" style="transform: scale(1);" onMouseOver="this.style.transform='scale(2)'" onMouseOut="this.style.transform='scale(1)'"></div>

                        <div class="w-14 h-14 bg-white text-amber-500 rounded-2xl flex items-center justify-center mb-6 border border-amber-100 transition-all duration-300 shadow-sm relative z-10 group-hover:bg-amber-500 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>

                        <h4 class="text-xl font-heading font-bold text-slate-900 mb-3 transition-colors relative z-10 group-hover:text-amber-600">Tahap Pertumbuhan</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 relative z-10 font-light flex-grow">
                            Pendalaman rohani intensional lewat <strong class="text-slate-700 font-semibold">Grade 1 & 2</strong> untuk melepaskan belenggu dan mengalami kuasa salib sepenuhnya.
                        </p>

                        <div class="relative z-10 mt-auto">
                            <span class="inline-flex py-1.5 px-4 rounded-full bg-slate-50 text-slate-600 font-bold uppercase border border-slate-100 transition-colors group-hover:border-amber-200 group-hover:bg-amber-50 group-hover:text-amber-700" style="font-size: 10px; letter-spacing: 0.1em;">Level 3</span>
                        </div>
                    </div>

                    <!-- Card 4: Dampak -->
                    <div class="relative bg-white p-8 shadow-xl border border-slate-100 z-10 transition-all duration-500 hover:-translate-y-3 group overflow-hidden flex flex-col h-full" style="border-radius: 2rem; box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.4);">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-100/50 rounded-bl-full -mr-12 -mt-12 transition-all duration-700 ease-out z-0" style="transform: scale(1);" onMouseOver="this.style.transform='scale(2)'" onMouseOut="this.style.transform='scale(1)'"></div>

                        <div class="w-14 h-14 bg-white text-amber-600 rounded-2xl flex items-center justify-center mb-6 border border-amber-200 transition-all duration-300 shadow-sm relative z-10 group-hover:bg-amber-600 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>

                        <h4 class="text-xl font-heading font-bold text-slate-900 mb-3 transition-colors relative z-10 group-hover:text-amber-700">Tahap Dampak</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 relative z-10 font-light flex-grow">
                            Berdampak bagi orang lain melalui partisipasi pelayanan dan kepemimpinan berkelipatan lewat <strong class="text-slate-700 font-semibold">Leadership Class (CTT & DMT)</strong>.
                        </p>

                        <div class="relative z-10 mt-auto">
                            <span class="inline-flex py-1.5 px-4 rounded-full bg-slate-50 text-slate-600 font-bold uppercase border border-slate-100 transition-colors group-hover:border-amber-200 group-hover:bg-amber-50 group-hover:text-amber-700" style="font-size: 10px; letter-spacing: 0.1em;">Level 4</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic CTA -->
        <section class="py-24 relative" style="background-color: #ffffff;">
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
                                Mulai Perjalanan Baru
                            </h2>
                            <p class="text-orange-100 text-lg md:text-xl mb-0 max-w-2xl font-light">
                                Bergabunglah bersama ratusan jemaat lainnya. Tingkatkan kualitas rohani dan jadilah saluran berkat melalui proses pemuridan ini.
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
                        <li><a href="#profile" class="text-slate-500 hover:text-orange-600 font-medium transition-colors">Profil Pembelajaran</a></li>
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
