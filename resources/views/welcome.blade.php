<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $site_settings['site_name'] ?? 'ProPePa PEDULI' }} - {{ $site_settings['site_description'] ?? 'LMS' }}</title>
    
    @if(isset($site_settings['site_favicon']))
    <link rel="icon" type="image/x-icon" href="{{ $site_settings['site_favicon'] }}">
    @endif
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-headline { font-family: 'Lexend', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .bg-gradient { background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%); }
        
        .hero-swiper { width: 100%; height: 100vh; }
        .hero-slide { position: relative; width: 100%; height: 100%; overflow: hidden; }
        .hero-slide img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6); }
        .hero-overlay { 
            position: absolute; inset: 0; 
            background: linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%);
            z-index: 2;
        }
    </style>
</head>
<body class="bg-gradient text-on-surface antialiased overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto glass rounded-2xl border border-white/40 shadow-lg px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <x-logo variant="pill" />
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm font-bold text-primary transition-colors">Beranda</a>
                <a href="{{ route('about') }}" class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors">Tentang</a>
                <a href="{{ url('/#siklus') }}" class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors">Siklus</a>
                <a href="{{ url('/#modul') }}" class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors">Modul</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-bold text-primary px-4 py-2 rounded-xl hover:bg-primary/5 transition-all">Masuk Siswa</a>
                <a href="{{ route('teacher.login') }}" class="bg-primary text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md hover:bg-primary/90 transition-all">Portal Guru</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Swiper -->
    <section class="relative min-h-screen">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide hero-slide">
                    <img src="https://cdn.pixabay.com/photo/2021/05/09/14/55/children-6241180_1280.jpg" alt="Education 1">
                    <div class="hero-overlay"></div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide hero-slide">
                    <img src="https://cdn.pixabay.com/photo/2018/09/28/06/11/kids-3708586_1280.jpg" alt="Education 2">
                    <div class="hero-overlay"></div>
                </div>
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination !bottom-10"></div>
        </div>

        <!-- Hero Content Overlay -->
        <div class="absolute inset-0 z-10 flex items-center px-6">
            <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 text-left text-white">
                    <div class="inline-flex items-center gap-2 bg-primary/20 backdrop-blur-md text-primary-fixed-dim px-4 py-2 rounded-full font-bold text-sm border border-white/10">
                        <span class="material-symbols-outlined text-sm">stars</span>
                        LMS Pembelajaran Berbasis Proyek
                    </div>
                    <h1 class="font-headline text-5xl md:text-7xl font-bold leading-tight">
                        Wujudkan <span class="text-primary-fixed-dim">Profil Pelajar</span> Pancasila.
                    </h1>
                    <p class="text-lg md:text-xl text-white/80 leading-relaxed max-w-xl">
                        Platform LMS modern yang dirancang khusus untuk mendukung Siklus PEDULI dalam pembelajaran berbasis proyek yang interaktif dan menyenangkan.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                        <a href="{{ route('login') }}" class="w-full sm:w-auto bg-primary text-white text-lg font-bold px-10 py-4 rounded-2xl shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-3">
                            Mulai Belajar Sekarang
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <div class="flex -space-x-3">
                            @for($i=1; $i<=4; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-white/20 bg-surface-container flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('assets/img/avatars/siswa-' . $i . '.png') }}" alt="siswa">
                            </div>
                            @endfor
                            <div class="pl-5 text-sm font-bold text-white/60 flex items-center">
                                +100 Siswa Terdaftar
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating Card in Hero -->
                <div class="hidden lg:block relative">
                    <div class="glass p-8 rounded-[3rem] border border-white/20 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full blur-3xl group-hover:bg-primary/20 transition-all"></div>
                        <div class="space-y-6 relative z-10">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg">
                                    <span class="material-symbols-outlined text-3xl">military_tech</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-xl text-on-surface">Papan Peringkat</h4>
                                    <p class="text-sm text-on-surface-variant">Update terbaru kelas 5A</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-primary">1</span>
                                        <span class="text-sm font-bold text-on-surface">Budi Darmawan</span>
                                    </div>
                                    <span class="text-xs font-bold text-primary">2.450 Poin</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-outline">2</span>
                                        <span class="text-sm font-bold text-on-surface">Siti Aminah</span>
                                    </div>
                                    <span class="text-xs font-bold text-outline">2.310 Poin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cycle PEDULI -->
    <section id="siklus" class="py-24 px-6 bg-white rounded-t-[5rem] shadow-[0_-20px_50px_rgba(0,0,0,0.02)] -mt-20 relative z-20">
        <div class="max-w-7xl mx-auto text-center space-y-4 mb-16">
            <h2 class="font-headline text-3xl md:text-5xl font-bold text-on-surface">Siklus Pembelajaran <span class="text-primary">PEDULI</span></h2>
            <p class="text-on-surface-variant max-w-2xl mx-auto">Metodologi pembelajaran terstruktur untuk mencetak generasi kreatif dan peduli lingkungan.</p>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
                $steps = [
                    ['P', 'Pelajari', 'menu_book', 'bg-blue-500'],
                    ['E', 'Eksplorasi', 'explore', 'bg-green-500'],
                    ['D', 'Diskusi', 'forum', 'bg-purple-500'],
                    ['U', 'Ungkapkan', 'edit_note', 'bg-orange-500'],
                    ['L', 'Lakukan', 'rocket_launch', 'bg-red-500'],
                    ['I', 'Introspeksi', 'psychology', 'bg-teal-500']
                ];
            @endphp

            @foreach($steps as $step)
            <div class="group p-6 rounded-[2.5rem] border border-outline-variant/30 hover:border-primary hover:shadow-xl hover:shadow-primary/10 transition-all text-center space-y-4 bg-surface-container-low">
                <div class="w-16 h-16 {{ $step[3] }} text-white rounded-2xl flex items-center justify-center mx-auto shadow-lg group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">{{ $step[2] }}</span>
                </div>
                <div>
                    <h4 class="font-headline font-bold text-lg">{{ $step[1] }}</h4>
                    <p class="text-[10px] text-outline font-bold uppercase tracking-widest mt-1">Fase {{ $step[0] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Features -->
    <section id="modul" class="py-24 px-6 bg-surface-container-lowest">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 space-y-6">
                <div class="w-14 h-14 bg-primary/10 text-primary rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">military_tech</span>
                </div>
                <h3 class="font-headline text-xl font-bold">Sistem Gamifikasi</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed">
                    Belajar jadi seru dengan sistem poin, level, dan koleksi lencana unik untuk setiap modul yang diselesaikan.
                </p>
            </div>
            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 space-y-6">
                <div class="w-14 h-14 bg-secondary-container/30 text-secondary rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">analytics</span>
                </div>
                <h3 class="font-headline text-xl font-bold">Pantauan Progres</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed">
                    Guru dapat memantau setiap langkah siswa secara real-time, memberikan umpan balik langsung, dan poin bonus.
                </p>
            </div>
            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 space-y-6">
                <div class="w-14 h-14 bg-error-container/30 text-error rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">description</span>
                </div>
                <h3 class="font-headline text-xl font-bold">Cloud Reporting</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed">
                    Admin dan Guru dapat mengunduh laporan perkembangan siswa dalam format CSV/Excel dengan sekali klik.
                </p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-24 px-6 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="text-center space-y-4 mb-16">
                <h2 class="font-headline text-3xl md:text-5xl font-bold text-on-surface">Tim Pengembang <span class="text-primary">ProPePa</span></h2>
                <p class="text-on-surface-variant max-w-2xl mx-auto">Dibalik platform inovatif ini, terdapat tim ahli yang berdedikasi tinggi.</p>
            </div>

            <div class="relative px-12">
                <div class="swiper team-swiper">
                    <div class="swiper-wrapper">
                        @forelse($teams as $member)
                        <div class="swiper-slide h-auto">
                            <div onclick="window.location.href='{{ route('team.show', $member->id) }}'" 
                                 class="bg-white p-6 rounded-[3rem] shadow-sm border border-outline-variant/20 text-center flex flex-col h-full cursor-pointer hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group">
                                <div class="relative mb-6 aspect-square overflow-hidden rounded-[2.5rem]">
                                    <img src="{{ $member->image ?: 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&size=200&background=F9DEDC&color=410002' }}" 
                                         alt="{{ $member->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>
                                <div class="flex-1 flex flex-col justify-center gap-2">
                                    <h4 class="font-headline font-bold text-xl text-on-surface leading-tight px-2">{{ $member->name }}</h4>
                                    <p class="text-[10px] font-bold text-primary/60 uppercase tracking-[0.2em]">{{ $member->position }}</p>
                                </div>
                                
                                <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-[9px] font-bold text-primary uppercase tracking-widest flex items-center justify-center gap-1">
                                        Lihat Profil <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <!-- Default Static Data if Database is Empty -->
                        <!-- Member 1 -->
                        <div class="swiper-slide h-auto">
                            <div class="bg-white p-6 rounded-[3rem] shadow-sm border border-outline-variant/20 text-center flex flex-col h-full group">
                                <div class="relative mb-6 aspect-square overflow-hidden rounded-[2.5rem]">
                                    <img src="https://propepapeduli.id/assets/img/team/farid.png" alt="Faridillah Fahmi N" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                         onerror="this.src='https://ui-avatars.com/api/?name=Faridillah+Fahmi+N&size=200&background=F9DEDC&color=410002'">
                                </div>
                                <div class="flex-1 flex flex-col justify-center gap-2">
                                    <h4 class="font-headline font-bold text-xl text-on-surface leading-tight px-2">Faridillah Fahmi Nurfurqon, M.Pd</h4>
                                    <p class="text-[10px] font-bold text-primary/60 uppercase tracking-[0.2em]">Peneliti Utama Disertasi</p>
                                </div>
                            </div>
                        </div>
                        <!-- Member 2 -->
                        <div class="swiper-slide h-auto">
                            <div class="bg-white p-6 rounded-[3rem] shadow-sm border border-outline-variant/20 text-center flex flex-col h-full group">
                                <div class="relative mb-6 aspect-square overflow-hidden rounded-[2.5rem]">
                                    <img src="https://propepapeduli.id/assets/img/team/bunyamin.png" alt="Prof. Dr. Bunyamin Maftuh" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                         onerror="this.src='https://ui-avatars.com/api/?name=Bunyamin+Maftuh&size=200&background=F9DEDC&color=410002'">
                                </div>
                                <div class="flex-1 flex flex-col justify-center gap-2">
                                    <h4 class="font-headline font-bold text-xl text-on-surface leading-tight px-2">Prof. Dr. Bunyamin Maftuh, M.Pd., M.A.</h4>
                                    <p class="text-[10px] font-bold text-primary/60 uppercase tracking-[0.2em]">Promotor</p>
                                </div>
                            </div>
                        </div>
                        <!-- Member 3 -->
                        <div class="swiper-slide h-auto">
                            <div class="bg-white p-6 rounded-[3rem] shadow-sm border border-outline-variant/20 text-center flex flex-col h-full group">
                                <div class="relative mb-6 aspect-square overflow-hidden rounded-[2.5rem]">
                                    <img src="https://propepapeduli.id/assets/img/team/mubiar.png" alt="Prof. Dr. Mubiar Agustin" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                         onerror="this.src='https://ui-avatars.com/api/?name=Mubiar+Agustin&size=200&background=F9DEDC&color=410002'">
                                </div>
                                <div class="flex-1 flex flex-col justify-center gap-2">
                                    <h4 class="font-headline font-bold text-xl text-on-surface leading-tight px-2">Prof. Dr. Mubiar Agustin, M.Pd.</h4>
                                    <p class="text-[10px] font-bold text-primary/60 uppercase tracking-[0.2em]">Co-Promotor</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- Navigation Arrows -->
                <button class="team-prev absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-primary hover:text-white transition-all z-10 shadow-sm">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button class="team-next absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-primary hover:text-white transition-all z-10 shadow-sm">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-20 px-6 bg-[#1d1b20] text-white">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="text-center md:text-left space-y-4">
                <div class="flex items-center gap-3 justify-center md:justify-start">
                    <x-logo variant="pill" />
                </div>
                <p class="text-white/50 text-sm max-w-sm">
                    {{ $site_settings['site_description'] ?? 'Platform inovatif untuk mendukung implementasi Kurikulum Merdeka.' }}
                </p>
            </div>
            <div class="flex gap-8">
                <a href="{{ route('login') }}" class="text-sm font-bold hover:text-primary transition-colors">Masuk Siswa</a>
                <a href="{{ route('teacher.login') }}" class="text-sm font-bold hover:text-primary transition-colors">Portal Guru</a>
                <a href="{{ route('admin.login') }}" class="text-sm font-bold hover:text-primary transition-colors">Admin</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-white/5 text-center text-white/30 text-xs">
            &copy; {{ date('Y') }} {{ $site_settings['site_name'] ?? 'ProPePa PEDULI LMS' }}. All Rights Reserved. Built with ❤️ by MATEK.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        new Swiper('.hero-swiper', {
            loop: true,
            effect: 'fade',
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        new Swiper('.team-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
            autoplay: {
                delay: 5000,
            }
        });
    </script>
</body>
</html>
