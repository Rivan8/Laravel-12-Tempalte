<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Equip Discipleship | Elshaddai Learning Center</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800|inter:400,500,600,700&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Poppins', sans-serif; }
        
        @keyframes upDown {
            0%, 100% { transform: translateY(-5px); }
            50% { transform: translateY(5px); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        .animate-up-down {
            animation: upDown 3s ease-in-out infinite;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .glass-nav {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-800">

    <!-- Navbar -->
    <header class="fixed w-full top-0 z-50 glass-nav border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white font-heading font-bold text-xl shadow-lg shadow-indigo-500/30">
                        ESC
                    </div>
                    <div>
                        <span class="font-heading font-bold text-2xl tracking-tight text-slate-900 block leading-none">Equip</span>
                        <span class="font-medium text-sm text-indigo-600 tracking-wide uppercase">Discipleship</span>
                    </div>
                </div>

                <!-- Navigation -->
                @if (Route::has('login'))
                <nav class="hidden md:flex items-center gap-6 font-medium">
                    <a href="#program" class="text-slate-600 hover:text-indigo-600 transition-colors">Program</a>
                    
                    <div class="h-6 w-px bg-slate-200"></div>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full text-indigo-700 bg-indigo-50 hover:bg-indigo-100 font-semibold transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-semibold transition-colors">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-full bg-indigo-600 text-white font-semibold hover:bg-indigo-700 shadow-md hover:shadow-xl hover:shadow-indigo-600/20 transition-all transform hover:-translate-y-0.5">Daftar Sekarang</a>
                        @endif
                    @endauth
                </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="pt-20">
        <section class="relative overflow-hidden bg-white min-h-[90vh] flex items-center">
            <!-- Background Ornaments -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
                <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-indigo-50 blur-3xl opacity-60"></div>
                <div class="absolute top-1/2 -left-24 w-72 h-72 rounded-full bg-amber-500/10 blur-3xl opacity-60"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 lg:py-0 w-full">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                    
                    <!-- Left Copy -->
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 font-medium text-sm mb-6 shadow-sm">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            Platform Pembelajaran Rohani
                        </div>
                        
                        <h1 class="text-5xl lg:text-6xl xl:text-7xl font-heading font-extrabold text-slate-900 leading-[1.15] mb-6">
                            Bertumbuh Lebih <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-teal-500">Dalam & Berdampak</span>
                        </h1>
                        
                        <p class="text-lg lg:text-xl text-slate-600 mb-8 leading-relaxed max-w-lg">
                            Mulai perjalanan kedewasaan rohani Anda melalui sistem edukasi terstruktur, dari <strong>Foundation Class</strong> hingga <strong>Leadership Class</strong>.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 rounded-full bg-indigo-600 text-white font-semibold text-lg hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all transform hover:-translate-y-1">
                                Mulai Belajar
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="#program" class="inline-flex justify-center items-center px-8 py-4 rounded-full bg-white border-2 border-slate-200 text-slate-700 font-semibold text-lg hover:border-indigo-600 hover:text-indigo-600 transition-all">
                                Lihat Program
                            </a>
                        </div>
                        
                        <!-- Mini Stats -->
                        <div class="mt-10 flex flex-wrap items-center gap-6 text-sm text-slate-500 font-medium">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                Kurikulum Standar
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                Materi Terstruktur
                            </div>
                        </div>
                    </div>

                    <!-- Right Image Grid / Abstract Concept -->
                    <div class="relative w-full h-[500px] lg:h-[600px] hidden lg:block">
                        <!-- Main Image / Illustration Card -->
                        <div class="absolute top-1/2 right-4 transform -translate-y-1/2 w-[85%] h-[400px] bg-white rounded-[2rem] shadow-2xl p-4 z-20 animate-float">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Students learning" class="w-full h-full object-cover rounded-2xl" />
                            
                            <!-- Floating Badge 1 -->
                            <div class="absolute -bottom-6 -left-10 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-up-down" style="animation-delay: 1s;">
                                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="pr-2">
                                    <p class="text-sm text-slate-500 font-medium">Tingkat Kelulusan</p>
                                    <p class="font-heading font-bold text-slate-900 text-xl">98%</p>
                                </div>
                            </div>

                            <!-- Floating Badge 2 -->
                            <div class="absolute -top-6 -right-6 bg-white px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3 animate-up-down">
                                <div class="flex -space-x-3">
                                    <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Student">
                                    <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Student">
                                    <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">+1k</div>
                                </div>
                                <div class="text-sm font-bold text-slate-800">Siswa Aktif</div>
                            </div>
                        </div>

                        <!-- Accent Blob -->
                        <div class="absolute top-[20%] right-[10%] w-64 h-64 bg-amber-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
                        <div class="absolute bottom-[10%] left-[20%] w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 3s;"></div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Stats Divider Sections -->
        <div class="py-12 bg-slate-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-slate-800">
                    <div class="px-4">
                        <p class="text-4xl md:text-5xl font-heading font-bold text-indigo-400 mb-2">3+</p>
                        <p class="text-slate-400 font-medium text-sm md:text-base">Jenjang Kelas</p>
                    </div>
                    <div class="px-4">
                        <p class="text-4xl md:text-5xl font-heading font-bold text-indigo-400 mb-2">100%</p>
                        <p class="text-slate-400 font-medium text-sm md:text-base">Akses Online</p>
                    </div>
                    <div class="px-4">
                        <p class="text-4xl md:text-5xl font-heading font-bold text-indigo-400 mb-2">Materi</p>
                        <p class="text-slate-400 font-medium text-sm md:text-base">Eksklusif Terbaru</p>
                    </div>
                    <div class="px-4">
                        <p class="text-4xl md:text-5xl font-heading font-bold text-indigo-400 mb-2">24/7</p>
                        <p class="text-slate-400 font-medium text-sm md:text-base">Platform Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Section (Jenjang Pembelajaran) -->
        <section id="program" class="py-24 bg-slate-50 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-100 rounded-full blur-[120px] opacity-50 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <h2 class="text-indigo-600 font-bold tracking-widest uppercase mb-3 text-sm flex items-center justify-center gap-2">
                        <span class="w-8 h-px bg-indigo-600"></span> Kurikulum Kami <span class="w-8 h-px bg-indigo-600"></span>
                    </h2>
                    <h3 class="text-3xl md:text-4xl lg:text-5xl font-heading font-extrabold text-slate-900 mb-6">
                        Sistem Edukasi Terstruktur
                    </h3>
                    <p class="text-lg text-slate-600">
                        Disusun secara sistematis agar setiap individu dapat bertumbuh dari dasar keyakinan hingga menjadi pemimpin kelompok sel.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 xl:gap-12 relative">
                    <!-- Card 1 -->
                    <div class="relative bg-white rounded-[2rem] p-8 lg:p-10 shadow-xl shadow-slate-200/50 border border-slate-100 z-10 transition-all duration-300 hover:-translate-y-3 group hover:shadow-2xl hover:shadow-indigo-600/10">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 border border-blue-100 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-4 group-hover:text-blue-600 transition-colors">Equip - New</h4>
                        <p class="text-slate-600 leading-relaxed mb-6">
                            Membangun pondasi rohani lewat <strong>Membership Class</strong> dan <strong>Foundation Class</strong>. Memahami dasar keselamatan.
                        </p>
                        <div class="inline-flex py-1.5 px-4 rounded-full bg-blue-50 text-blue-700 font-semibold text-sm">
                            Tahap 1 | Dasar
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="relative bg-white rounded-[2rem] p-8 lg:p-10 shadow-xl shadow-slate-200/50 border border-slate-100 z-10 transition-all duration-300 hover:-translate-y-3 group hover:shadow-2xl hover:shadow-indigo-600/10">
                        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-8 border border-indigo-100 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-4 group-hover:text-indigo-600 transition-colors">Equip - Grow / Plant</h4>
                        <p class="text-slate-600 leading-relaxed mb-6">
                            Pendalaman rohani melalui <strong>Grade 1 (The Cross)</strong>, <strong>Grade 2 (The Power)</strong>, dan persiapan pernikahan.
                        </p>
                        <div class="inline-flex py-1.5 px-4 rounded-full bg-indigo-50 text-indigo-700 font-semibold text-sm">
                            Tahap 2 | Pertumbuhan
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="relative bg-white rounded-[2rem] p-8 lg:p-10 shadow-xl shadow-slate-200/50 border border-slate-100 z-10 transition-all duration-300 hover:-translate-y-3 group hover:shadow-2xl hover:shadow-indigo-600/10">
                        <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-8 border border-amber-100 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="text-2xl font-heading font-bold text-slate-900 mb-4 group-hover:text-amber-600 transition-colors">Equip - Serve & Lead</h4>
                        <p class="text-slate-600 leading-relaxed mb-6">
                            Berakar untuk berbuah lewat <strong>Volunteer Class</strong>, <strong>Leadership Class</strong>, dan <strong>Disciple Maker</strong>.
                        </p>
                        <div class="inline-flex py-1.5 px-4 rounded-full bg-amber-50 text-amber-700 font-semibold text-sm">
                            Tahap 3 | Dampak
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic CTA -->
        <section class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative bg-indigo-700 rounded-[3rem] overflow-hidden shadow-2xl">
                    <!-- Dynamic BG -->
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1557683316-973673baf926?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-center opacity-30 mix-blend-overlay"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-900 to-indigo-600/80"></div>
                    
                    <!-- Decorative Circles -->
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-[400px] h-[400px] bg-white opacity-10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-[300px] h-[300px] bg-amber-400 opacity-20 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 p-12 lg:p-20 flex flex-col lg:flex-row items-center justify-between text-center lg:text-left gap-10">
                        <div class="max-w-3xl">
                            <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-white mb-6 leading-tight">
                                Siap Untuk Bertumbuh?
                            </h2>
                            <p class="text-indigo-100 text-lg md:text-xl mb-0 max-w-2xl">
                                Bergabunglah bersama ratusan jemaat lainnya dan mulailah perjalanan kedewasaan rohani Anda hari ini.
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-8 py-5 bg-white text-indigo-700 font-bold text-xl rounded-full hover:bg-slate-50 hover:scale-105 transition-all shadow-xl hover:shadow-2xl shadow-indigo-900/50">
                                Buat Akun Sekarang
                                <svg class="ml-2 w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white pt-16 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 lg:gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white font-heading font-bold text-xl shadow-md">
                            ESC
                        </div>
                        <span class="font-heading font-bold text-2xl text-slate-900">Equip <span class="text-indigo-600">Discipleship</span></span>
                    </div>
                    <p class="text-slate-500 leading-relaxed max-w-sm">
                        Platform edukasi dan pemuridan terpadu dari Elshaddai Church, memampukan setiap jemaat untuk bertumbuh dari anggota menjadi pembuat murid.
                    </p>
                </div>
                <div>
                    <h4 class="font-heading font-bold text-slate-900 mb-6 uppercase text-sm tracking-wider">Tautan Cepat</h4>
                    <ul class="space-y-4">
                        <li><a href="#program" class="text-slate-500 hover:text-indigo-600 font-medium transition-colors">Program Kelas</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-indigo-600 font-medium transition-colors">Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-500 hover:text-indigo-600 font-medium transition-colors">Daftar Baru</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-heading font-bold text-slate-900 mb-6 uppercase text-sm tracking-wider">Kontak</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-slate-500 font-medium">
                            <svg class="w-5 h-5 text-indigo-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Gedung Elshaddai<br/>Kalimantan Barat, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between">
                <p class="text-slate-500 text-sm font-medium">
                    &copy; {{ date('Y') }} Elshaddai Church. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>