<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Guru - ProPePa')</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-surface-container-lowest text-on-surface font-body-md antialiased flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white text-on-surface flex flex-col transition-all duration-300 shadow-xl z-20 border-r border-outline-variant/30">
        <div class="h-16 flex items-center px-6 border-b border-outline-variant/30 shrink-0">
            <x-logo variant="pill" />
            <span class="ml-3 font-headline font-bold text-lg text-primary">ProPePa PEDULI</span>
        </div>
        
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.dashboard') ? "font-variation-settings: 'FILL' 1;" : "" }}">dashboard</span>
                <span>Dasbor</span>
            </a>
            <a href="{{ route('teacher.journals.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.journals.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.journals.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">edit_square</span>
                <span>Penilaian Jurnal</span>
            </a>
            <a href="{{ route('teacher.forum.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.forum.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.forum.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">forum</span>
                <span>Forum Diskusi</span>
            </a>
            <a href="{{ route('teacher.groups.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.groups.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.groups.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">groups</span>
                <span>Kelola Kelompok</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                <span>Pengaturan</span>
            </a>
        </div>
        
        <div class="p-4 border-t border-outline-variant/30 shrink-0">
            <div class="flex items-center gap-3 mb-4 px-3">
                <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold truncate text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-on-surface-variant">Guru Kelas</p>
                </div>
            </div>
            <form action="{{ route('teacher.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-xl w-full transition-colors text-error hover:bg-error-container/30">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-surface-container-low">
            @if(session('success'))
                <div class="bg-[#d4edda] text-[#155724] border border-[#c3e6cb] px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-error-container text-on-error-container border border-error/20 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
</body>
</html>
