<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - {{ $site_settings['site_name'] ?? 'ProPePa PEDULI' }}</title>
    
    @if(isset($site_settings['site_favicon']))
    <link rel="icon" type="image/x-icon" href="{{ $site_settings['site_favicon'] }}">
    @endif
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-headline { font-family: 'Lexend', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .bg-gradient-soft { background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%); }
    </style>
</head>
<body class="bg-gradient-soft text-on-surface antialiased overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto glass rounded-2xl border border-white/40 shadow-lg px-6 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <x-logo variant="pill" />
                <span class="font-headline font-bold text-xl text-primary tracking-tight ml-2">PEDULI</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors">Beranda</a>
                <a href="{{ route('about') }}" class="text-sm font-bold text-primary transition-colors">Tentang</a>
                <a href="{{ url('/#siklus') }}" class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors">Siklus</a>
                <a href="{{ url('/#modul') }}" class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors">Modul</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="bg-primary text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md hover:bg-primary/90 transition-all">LMS Portal</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-primary/5 blur-3xl rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8 animate-in slide-in-from-left duration-700">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full font-bold text-sm">
                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                    Visi & Filosofi
                </div>
                <h1 class="font-headline text-5xl md:text-7xl font-bold leading-tight">
                    Transformasi <span class="text-primary">Pendidikan Digital</span> Menuju Indonesia Emas.
                </h1>
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    "Membangun generasi sekolah dasar yang tidak hanya cerdas secara akademik, tetapi juga memiliki empati tinggi dan tanggung jawab sosial yang kuat."
                </p>
            </div>
            <div class="relative animate-in zoom-in duration-1000">
                <div class="aspect-square rounded-[3rem] overflow-hidden shadow-2xl rotate-3 bg-white p-4">
                    <img src="https://cdn.pixabay.com/photo/2021/05/09/14/55/children-6241180_1280.jpg" alt="Education Innovation" class="w-full h-full object-cover rounded-[2.5rem] -rotate-3">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-3xl shadow-xl border border-outline-variant/30 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary font-bold">21</div>
                    <div class="text-xs font-bold leading-tight">Keterampilan<br>Abad 21</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto space-y-32">
            
            <!-- Innovation Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://cdn.pixabay.com/photo/2018/09/28/06/11/kids-3708586_1280.jpg" class="rounded-3xl shadow-lg mt-8" alt="Team">
                        <img src="https://cdn.pixabay.com/photo/2018/05/13/11/05/bali-3396031_1280.jpg" class="rounded-3xl shadow-lg" alt="Innovation">
                    </div>
                </div>
                <div class="space-y-6 order-1 lg:order-2">
                    <h2 class="font-headline text-3xl md:text-4xl font-bold text-on-surface">Inovasi Pembelajaran Digital Abad 21</h2>
                    <p class="text-on-surface-variant leading-relaxed">
                        ProPePa hadir sebagai inovasi pembelajaran digital yang dirancang untuk membangun generasi sekolah dasar yang tidak hanya cerdas secara akademik, tetapi juga memiliki empati tinggi dan tanggung jawab sosial yang kuat.
                    </p>
                    <p class="text-on-surface-variant leading-relaxed italic border-l-4 border-primary/30 pl-4 bg-primary/5 py-3 rounded-r-xl">
                        ProPePa lahir dari kebutuhan akan pembelajaran yang lebih kontekstual, bermakna, dan mampu menghubungkan pengetahuan dengan realitas sosial yang dihadapi siswa dalam kehidupan sehari-hari.
                    </p>
                </div>
            </div>

            <!-- Philosophy Section -->
            <div class="bg-white rounded-[4rem] p-12 md:p-20 shadow-xl border border-outline-variant/30 relative overflow-hidden">
                <div class="absolute bottom-0 right-0 opacity-5">
                    <span class="material-symbols-outlined text-[300px]">format_quote</span>
                </div>
                <div class="max-w-3xl mx-auto text-center space-y-8">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-6">
                        <span class="material-symbols-outlined text-3xl">school</span>
                    </div>
                    <h2 class="font-headline text-2xl md:text-3xl font-bold text-on-surface italic">
                        "Ing Ngarso Sung Tulodo, Ing Madya Mangun Karso, Tut Wuri Handayani"
                    </h2>
                    <p class="text-lg text-on-surface-variant leading-relaxed">
                        ProPePa terinspirasi dari filosofi pendidikan Ki Hadjar Dewantara yang menegaskan bahwa pendidikan harus menghadirkan keteladanan, membangun semangat, dan memberikan dorongan bagi tumbuhnya potensi peserta didik.
                    </p>
                    <p class="text-on-surface-variant">
                        Nilai tersebut menjadi ruh dalam pengembangan ProPePa, di mana pembelajaran tidak hanya berfokus pada transfer pengetahuan, tetapi juga pada pembentukan karakter dan kesadaran sosial secara holistik.
                    </p>
                </div>
            </div>

            <!-- Pillars Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-surface-container-low p-10 rounded-[3rem] border border-outline-variant/30 space-y-6 hover:translate-y-[-10px] transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center">
                        <span class="material-symbols-outlined">stars</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-on-surface">Nilai Pancasila</h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">Berfungsi sebagai kompas moral utama dalam setiap langkah pembelajaran dan pengembangan karakter siswa.</p>
                </div>
                <div class="bg-surface-container-low p-10 rounded-[3rem] border border-outline-variant/30 space-y-6 hover:translate-y-[-10px] transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-secondary text-white flex items-center justify-center">
                        <span class="material-symbols-outlined">psychology</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-on-surface">Konstruktivisme Sosial</h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">Mendorong siswa untuk belajar melalui interaksi dengan isu-isu nyata yang terjadi di lingkungan sekitar mereka.</p>
                </div>
                <div class="bg-surface-container-low p-10 rounded-[3rem] border border-outline-variant/30 space-y-6 hover:translate-y-[-10px] transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-tertiary text-white flex items-center justify-center">
                        <span class="material-symbols-outlined">diversity_3</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-on-surface">Humanisme Transformatif</h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">Memanusiakan siswa untuk menjadi agen perubahan sosial yang peduli dan bertanggung jawab.</p>
                </div>
            </div>

            <!-- RPJPN Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center pt-10">
                <div class="space-y-6">
                    <h2 class="font-headline text-3xl md:text-4xl font-bold text-on-surface">Visi Indonesia Emas 2045</h2>
                    <p class="text-on-surface-variant leading-relaxed">
                        Platform ini dirancang selaras dengan arah pembangunan pendidikan nasional dalam Rencana Pembangunan Jangka Panjang Nasional (RPJPN) 2025–2045 yang menekankan transformasi pendidikan sebagai fondasi utama menuju terwujudnya Indonesia Emas 2045.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">done_all</span>
                            <span class="text-sm font-bold text-on-surface">Penguatan Karakter & Kompetensi Abad 21</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">done_all</span>
                            <span class="text-sm font-bold text-on-surface">Transformasi Digital Pendidikan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">done_all</span>
                            <span class="text-sm font-bold text-on-surface">Sumber Daya Manusia Unggul & Adaptif</span>
                        </div>
                    </div>
                </div>
                <div class="bg-primary p-12 rounded-[4rem] text-white space-y-6 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 blur-2xl rounded-full"></div>
                    <p class="text-lg leading-relaxed opacity-90">
                        ProPePa hadir sebagai inovasi pembelajaran digital berbasis isu sosiosaintifik yang tidak hanya mengembangkan kemampuan berpikir kritis siswa, tetapi juga menumbuhkan empati, kepedulian sosial, serta kemampuan berkolaborasi dalam kehidupan nyata.
                    </p>
                    <div class="pt-4">
                        <div class="text-3xl font-headline font-bold">2045</div>
                        <div class="text-xs uppercase tracking-widest opacity-60">Target Indonesia Emas</div>
                    </div>
                </div>
            </div>

            <!-- Visual Gallery Section -->
            <div class="space-y-12">
                <div class="text-center space-y-4">
                    <h2 class="font-headline text-3xl md:text-4xl font-bold text-on-surface">Semangat Kebangsaan</h2>
                    <p class="text-on-surface-variant max-w-2xl mx-auto">Membangun identitas bangsa melalui pendidikan yang berakar pada nilai-nilai luhur Indonesia.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-xl hover:scale-[1.02] transition-all duration-500">
                        <img src="https://images.unsplash.com/photo-1600792174569-59e1e0be0619?q=80&w=1167&auto=format&fit=crop" class="w-full h-full object-cover" alt="Indonesian Heritage">
                    </div>
                    <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-xl translate-y-8 hover:scale-[1.02] transition-all duration-500">
                        <img src="https://images.unsplash.com/photo-1599717460927-8101594d1418?q=80&w=1170&auto=format&fit=crop" class="w-full h-full object-cover" alt="Indonesian Children">
                    </div>
                    <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-xl hover:scale-[1.02] transition-all duration-500">
                        <img src="https://images.unsplash.com/photo-1589104760192-ccab0ce0d90f?q=80&w=1167&auto=format&fit=crop" class="w-full h-full object-cover" alt="Indonesian Nature">
                    </div>
                </div>
            </div>

            <!-- IPS Section -->
            <div class="text-center max-w-4xl mx-auto space-y-8 pt-10 pb-20">
                <h2 class="font-headline text-3xl md:text-4xl font-bold text-on-surface">Menghidupkan Pembelajaran IPS</h2>
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    Melalui ProPePa, pembelajaran IPS menjadi lebih hidup, dekat dengan realitas, dan bermakna. Siswa tidak hanya belajar tentang dunia sosial, tetapi juga belajar menjadi manusia yang peduli, kritis, bertanggung jawab, dan siap memberikan kontribusi positif bagi masyarakat.
                </p>
                <div class="pt-6">
                    <a href="/#modul" class="bg-primary text-white font-bold px-10 py-4 rounded-2xl shadow-xl hover:scale-105 transition-all inline-flex items-center gap-3">
                        Eksplorasi Modul Sekarang
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-20 px-6 bg-[#1d1b20] text-white">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="text-center md:text-left space-y-4">
                <div class="flex items-center gap-3 justify-center md:justify-start">
                    <x-logo variant="pill" />
                    <span class="font-headline font-bold text-2xl tracking-tight ml-2">PEDULI</span>
                </div>
                <p class="text-white/50 text-sm max-w-sm">
                    Platform inovatif untuk mendukung implementasi Kurikulum Merdeka dan Proyek Penguatan Profil Pelajar Pancasila.
                </p>
            </div>
            <div class="flex gap-8">
                <a href="{{ route('login') }}" class="text-sm font-bold hover:text-primary transition-colors">Masuk Siswa</a>
                <a href="{{ route('teacher.login') }}" class="text-sm font-bold hover:text-primary transition-colors">Portal Guru</a>
                <a href="{{ route('admin.login') }}" class="text-sm font-bold hover:text-primary transition-colors">Admin</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-white/5 text-center text-white/30 text-xs">
            &copy; {{ date('Y') }} ProPePa PEDULI LMS. All Rights Reserved. Built with ❤️ by MATEK.
        </div>
    </footer>
</body>
</html>
