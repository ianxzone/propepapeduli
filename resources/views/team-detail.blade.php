<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $team->name }} - {{ $site_settings['site_name'] ?? 'ProPePa PEDULI' }}</title>
    
    @if(isset($site_settings['site_favicon']))
    <link rel="icon" type="image/x-icon" href="{{ asset($site_settings['site_favicon']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#570000',
                        secondary: '#410000',
                        'on-surface': '#1D1B20',
                        'on-surface-variant': '#49454F',
                        'surface-container-low': '#F7F2FA',
                        'outline-variant': '#CAC4D0',
                    },
                    fontFamily: {
                        headline: ['"Plus Jakarta Sans"', 'sans-serif'],
                        body: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-[#FDF7F7] font-body text-on-surface">

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-outline-variant/20 px-6 py-4">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <span class="material-symbols-outlined text-primary group-hover:-translate-x-1 transition-transform">arrow_back</span>
                <span class="font-bold text-sm text-primary uppercase tracking-widest">Kembali ke Beranda</span>
            </a>
            <div class="hidden md:flex items-center gap-3">
                <div class="bg-primary/5 px-4 py-2 rounded-full">
                    <span class="text-[10px] font-bold text-primary uppercase tracking-tighter">Profil Pengembang ProPePa</span>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-12 md:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Column: Image & Quick Info -->
            <div class="lg:col-span-4 space-y-8 sticky top-28">
                <div class="relative aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl shadow-primary/10 border-4 border-white">
                    <img src="{{ $team->image ?: 'https://ui-avatars.com/api/?name='.urlencode($team->name).'&size=500&background=F9DEDC&color=410002' }}" 
                         class="w-full h-full object-cover" alt="{{ $team->name }}">
                </div>

                <!-- Scholarly Links -->
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-outline-variant/20 space-y-4">
                    <h4 class="text-xs font-bold text-outline uppercase tracking-widest text-center">Tautan Akademik</h4>
                    <div class="flex flex-wrap justify-center gap-4">
                        @if($team->google_scholar)
                        <a href="{{ $team->google_scholar }}" target="_blank" title="Google Scholar" class="w-12 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center hover:bg-primary/5 transition-all group">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Google_Scholar_logo.svg" class="w-7 h-7 grayscale group-hover:grayscale-0" alt="">
                        </a>
                        @endif
                        @if($team->sinta_link)
                        <a href="{{ $team->sinta_link }}" target="_blank" title="SINTA" class="px-4 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center hover:bg-primary/5 transition-all group">
                            <img src="{{ asset('assets/img/icons/sinta.png') }}" class="h-6 grayscale group-hover:grayscale-0" alt="SINTA">
                        </a>
                        @endif
                        @if($team->scopus_link)
                        <a href="{{ $team->scopus_link }}" target="_blank" title="Scopus" class="px-4 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center hover:bg-primary/5 transition-all group">
                            <img src="{{ asset('assets/img/icons/scopus.png') }}" class="h-6 grayscale group-hover:grayscale-0" alt="Scopus">
                        </a>
                        @endif
                        @if($team->orcid_link)
                        <a href="{{ $team->orcid_link }}" target="_blank" title="ORCID" class="w-12 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center hover:bg-primary/5 transition-all group">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/06/ORCID_logo.svg" class="w-7 h-7 grayscale group-hover:grayscale-0" alt="">
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="lg:col-span-8 space-y-10">
                <!-- Header Info -->
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/10 text-primary rounded-full">
                        <span class="material-symbols-outlined text-sm">workspace_premium</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider">{{ $team->academic_rank ?: 'Tenaga Ahli' }}</span>
                    </div>
                    <h1 class="font-headline text-4xl md:text-5xl font-extrabold text-on-surface leading-tight">{{ $team->name }}</h1>
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-on-surface-variant">
                        <p class="font-bold text-lg text-primary">{{ $team->position }}</p>
                        @if($team->nip || $team->nidn)
                        <div class="w-1.5 h-1.5 rounded-full bg-outline-variant hidden md:block"></div>
                        <p class="text-sm font-medium">
                            @if($team->nip) NIP. {{ $team->nip }} @endif
                            @if($team->nip && $team->nidn) | @endif
                            @if($team->nidn) NIDN. {{ $team->nidn }} @endif
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Bio / Introduction -->
                @if($team->bio)
                <section class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-1 bg-primary rounded-full"></div>
                        <h2 class="font-headline font-bold text-xl">Tentang Profil</h2>
                    </div>
                    <div class="prose prose-sm max-w-none text-on-surface-variant leading-loose">
                        {!! nl2br(e($team->bio)) !!}
                    </div>
                </section>
                @endif

                <!-- Education & Expertise Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @if($team->education && count($team->education) > 0)
                    <section class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-1 bg-primary rounded-full"></div>
                            <h2 class="font-headline font-bold text-xl">Riwayat Pendidikan</h2>
                        </div>
                        <ul class="space-y-4">
                            @foreach($team->education as $edu)
                            <li class="flex gap-4">
                                <div class="shrink-0 w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-xl">school</span>
                                </div>
                                <p class="text-sm font-medium leading-relaxed">{{ $edu }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </section>
                    @endif

                    @if($team->expertise)
                    <section class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-1 bg-primary rounded-full"></div>
                            <h2 class="font-headline font-bold text-xl">Bidang Keahlian</h2>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $team->expertise) as $skill)
                            <span class="px-4 py-2 bg-white border border-outline-variant/30 rounded-xl text-xs font-bold text-on-surface shadow-sm">
                                {{ trim($skill) }}
                            </span>
                            @endforeach
                        </div>
                    </section>
                    @endif
                </div>

                <!-- Journal Links -->
                @if($team->journal_links && count($team->journal_links) > 0)
                <section class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-1 bg-primary rounded-full"></div>
                        <h2 class="font-headline font-bold text-xl">Publikasi & Jurnal Lainnya</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($team->journal_links as $link)
                        <a href="{{ $link }}" target="_blank" class="group flex items-center justify-between p-5 bg-white border border-outline-variant/30 rounded-3xl hover:border-primary hover:shadow-lg hover:shadow-primary/5 transition-all">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-10 h-10 rounded-2xl bg-surface-container-low flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined">link</span>
                                </div>
                                <span class="text-sm font-medium text-on-surface truncate pr-4">{{ $link }}</span>
                            </div>
                            <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">open_in_new</span>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-outline-variant/20 text-center text-[10px] font-bold text-outline uppercase tracking-[0.3em]">
        &copy; {{ date('Y') }} ProPePa PEDULI LMS
    </footer>

</body>
</html>
