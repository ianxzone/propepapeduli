<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - ' . ($site_settings['site_name'] ?? 'ProPePa'))</title>
    
    @if(isset($site_settings['site_favicon']))
    <link rel="icon" type="image/x-icon" href="{{ asset($site_settings['site_favicon']) }}">
    @endif
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-surface-container-lowest text-on-surface font-body-md antialiased flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-[#1e1e1e] text-white flex flex-col transition-all duration-300 shadow-xl z-20">
        <div class="h-16 flex items-center px-6 border-b border-white/10 shrink-0">
            <x-logo variant="pill" />
        </div>
        
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.dashboard') ? "font-variation-settings: 'FILL' 1;" : "" }}">dashboard</span>
                <span>Dasbor</span>
            </a>
            <a href="{{ route('admin.modules.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.modules.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.modules.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">library_books</span>
                <span>Modul Belajar</span>
            </a>
            <!-- Placeholders for future menus -->
            <a href="{{ route('admin.schools.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.schools.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.schools.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">domain</span>
                <span>Data Sekolah</span>
            </a>
            <a href="{{ route('admin.classes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.classes.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.classes.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">school</span>
                <span>Data Kelas</span>
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.teachers.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.teachers.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">badge</span>
                <span>Data Guru</span>
            </a>
            <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.students.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.students.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">group</span>
                <span>Data Siswa</span>
            </a>
            
            <div class="h-px bg-white/10 my-4 mx-3"></div>
            
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.users.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">manage_accounts</span>
                <span>Manajemen User</span>
            </a>
            <a href="{{ route('admin.teams.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.teams.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.teams.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">groups</span>
                <span>Manajemen Tim</span>
            </a>
            @endif
            <a href="{{ route('admin.media.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.media.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.media.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">perm_media</span>
                <span>Pustaka Media</span>
            </a>
            <a href="{{ route('teacher.forum.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.forum.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.forum.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">forum</span>
                <span>Monitor Forum</span>
            </a>
            <a href="{{ route('teacher.groups.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.groups.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.groups.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">groups</span>
                <span>Kelola Kelompok</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.backups.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.backups.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.backups.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">database</span>
                <span>Backup Data</span>
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.activity-logs.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.activity-logs.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">history</span>
                <span>Log Aktivitas</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.settings.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">settings</span>
                <span>Pengaturan Sistem</span>
            </a>
            @endif
        </div>
        
        <div class="p-4 border-t border-white/10 shrink-0">
            <a href="{{ route('admin.about-app') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.about-app') ? 'bg-primary-fixed/10 text-primary-fixed font-bold' : 'text-surface-variant hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.about-app') ? "font-variation-settings: 'FILL' 1;" : "" }}">info</span>
                <span>Tentang Aplikasi</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-xl w-full transition-colors text-error-container hover:bg-error/20">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-outline-variant/30 flex items-center justify-between px-6 shrink-0 z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <h1 class="font-headline text-lg font-bold text-on-surface">@yield('header_title', 'Admin ProPePa')</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-on-surface-variant uppercase font-bold">
                        {{ Auth::user()->role === 'admin' ? 'Super Admin' : 'Dosen Peneliti' }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-primary-fixed/20 text-primary-fixed flex items-center justify-center font-bold border border-primary-fixed/10 shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>
        
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
    @stack('scripts')

    <!-- Global Modal Cleanup & Navigation Fix -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('popstate', () => closeModalOverlays());
            const sidebarLinks = document.querySelectorAll('aside a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => closeModalOverlays());
            });

            function closeModalOverlays() {
                const modals = document.querySelectorAll('[id*="modal-"]');
                modals.forEach(modal => modal.classList.add('hidden'));
                const overlays = document.querySelectorAll('.modal-backdrop, .fixed.inset-0.bg-black');
                overlays.forEach(overlay => overlay.classList.add('hidden'));
            }
        });
        document.addEventListener('livewire:navigating', () => {
            const modals = document.querySelectorAll('[id*="modal-"]');
            modals.forEach(modal => modal.classList.add('hidden'));
        });
    </script>
</body>
</html>
