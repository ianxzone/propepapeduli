<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Guru - ' . ($site_settings['site_name'] ?? 'ProPePa'))</title>
    
    @if(isset($site_settings['site_favicon']))
    <link rel="icon" type="image/x-icon" href="{{ $site_settings['site_favicon'] }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-surface-container-lowest text-on-surface font-body-md antialiased flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
    
    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden" style="display: none;"></div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white text-on-surface flex flex-col transition-all duration-300 shadow-xl z-50 border-r border-outline-variant/30 transform lg:translate-x-0 lg:static"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           @click.away="sidebarOpen = false">
        <div class="h-16 flex items-center px-6 border-b border-outline-variant/30 shrink-0">
            <x-logo variant="pill" />
        </div>
        
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.dashboard') ? "font-variation-settings: 'FILL' 1;" : "" }}">dashboard</span>
                <span>Dasbor</span>
            </a>
            <a href="{{ route('teacher.students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.students.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.students.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">person</span>
                <span>Data Siswa</span>
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
            <a href="{{ route('teacher.reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('teacher.reports.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('teacher.reports.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">assessment</span>
                <span>Laporan & Export</span>
            </a>

            @if(in_array(Auth::user()->role, ['admin', 'dosen']))
            <div class="h-px bg-outline-variant/30 my-4 mx-3"></div>
            <p class="px-6 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-2 opacity-50">Manajemen Sistem</p>
            <a href="{{ route('admin.schools.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.schools.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.schools.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">domain</span>
                <span>Data Sekolah</span>
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.teachers.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.teachers.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">badge</span>
                <span>Data Guru</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->routeIs('admin.users.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">manage_accounts</span>
                <span>Manajemen User</span>
            </a>
            @endif
        </div>
        
        <div class="p-4 border-t border-outline-variant/30 shrink-0">
            <div class="flex items-center gap-3 mb-4 px-3">
                <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold truncate text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-on-surface-variant">
                        @if(Auth::user()->role === 'dosen') Dosen / Pengawas @elseif(Auth::user()->role === 'admin') Administrator @else Guru Kelas @endif
                    </p>
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
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-outline-variant/30 flex items-center justify-between px-4 md:px-6 shrink-0 z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-on-surface-variant hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="font-headline text-lg font-bold text-on-surface truncate">@yield('header_title', 'Portal Guru')</h1>
            </div>
            <div class="flex items-center gap-4">
                @php
                    $unreadCount = \App\Models\Notification::where('read_at', null)
                        ->where(function($q) {
                            if (Auth::user()->role === 'teacher') {
                                $q->where('target_class_id', Auth::user()->class_id);
                            }
                        })->count();
                @endphp
                <a href="{{ route('teacher.notifications') }}" class="relative w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container transition-all">
                    <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                    @if($unreadCount > 0)
                        <span class="absolute top-2 right-2 w-4 h-4 bg-red-600 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-surface-container-low">
            @if(session('success'))
                <div class="flex items-center gap-4 bg-green-600 text-white px-6 py-4 rounded-2xl mb-8 shadow-lg animate-in slide-in-from-top duration-300">
                    <span class="material-symbols-outlined text-2xl">check_circle</span>
                    <div class="flex-1">
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-4 bg-red-600 text-white px-6 py-4 rounded-2xl mb-8 shadow-lg animate-in slide-in-from-top duration-300">
                    <span class="material-symbols-outlined text-2xl">error</span>
                    <div class="flex-1">
                        <p class="font-bold text-sm">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>

    <!-- Global Modal Cleanup & Navigation Fix -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tutup modal jika user menekan tombol Back/Forward di browser
            window.addEventListener('popstate', () => closeModalOverlays());

            // Tutup modal jika link sidebar diklik (mencegah overlay nyangkut di cache/SPA mode)
            const sidebarLinks = document.querySelectorAll('aside a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    closeModalOverlays();
                });
            });

            function closeModalOverlays() {
                // Cari semua elemen yang id-nya mengandung 'modal'
                const modals = document.querySelectorAll('[id*="modal-"]');
                modals.forEach(modal => {
                    modal.classList.add('hidden');
                });
                
                // Jika ada overlay backdrop manual dari library lain
                const overlays = document.querySelectorAll('.modal-backdrop, .fixed.inset-0.bg-black');
                overlays.forEach(overlay => {
                    overlay.classList.add('hidden');
                });
            }
        });
        
        // Dukungan untuk Livewire wire:navigate (jika diaktifkan di masa depan)
        document.addEventListener('livewire:navigating', () => {
            const modals = document.querySelectorAll('[id*="modal-"]');
            modals.forEach(modal => modal.classList.add('hidden'));
        });
    </script>
</body>
</html>
