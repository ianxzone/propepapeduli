@extends('layouts.app')

@section('title', 'Profil Saya - ProPePa PEDULI')

@section('content')
<div class="pb-24">
    <!-- Header with Background Gradient -->
    <header class="relative h-64 bg-primary overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        
        <div class="absolute inset-0 flex flex-col items-center justify-center pt-8">
            <div class="relative">
                <div class="w-24 h-24 rounded-[2rem] bg-white p-1 shadow-xl rotate-3">
                    <div class="w-full h-full rounded-[1.8rem] bg-primary-container flex items-center justify-center text-white text-4xl font-bold -rotate-3">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-secondary text-white w-10 h-10 rounded-2xl flex items-center justify-center border-4 border-white shadow-lg">
                    <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">verified</span>
                </div>
            </div>
            <h1 class="mt-4 font-headline text-headline-md text-white">{{ $user->name }}</h1>
            <p class="text-white/80 text-sm font-bold uppercase tracking-widest">{{ $user->class->name }} &bull; {{ $user->class->school->name }}</p>
        </div>
    </header>

    <main class="px-container-padding -mt-8 relative z-10 space-y-6">
        <!-- Stats Row -->
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-white p-4 rounded-3xl shadow-soft border border-outline-variant/30 text-center space-y-1">
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Peringkat</p>
                <p class="font-headline text-2xl font-bold text-primary">#{{ $rank }}</p>
            </div>
            <div class="bg-white p-4 rounded-3xl shadow-soft border border-outline-variant/30 text-center space-y-1">
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Total Poin</p>
                <p class="font-headline text-2xl font-bold text-secondary">{{ number_format($totalPoints) }}</p>
            </div>
            <div class="bg-white p-4 rounded-3xl shadow-soft border border-outline-variant/30 text-center space-y-1">
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Modul</p>
                <p class="font-headline text-2xl font-bold text-on-surface">{{ $completedModules }}/{{ $totalModules }}</p>
            </div>
        </div>

        <!-- Earned Badges -->
        <section class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h2 class="font-headline text-headline-sm text-on-surface">Koleksi Lencana</h2>
                <span class="text-xs text-primary font-bold">{{ count($earnedBadges) }} Didapat</span>
            </div>
            <div class="bg-white p-6 rounded-[2.5rem] border border-outline-variant/30 shadow-soft">
                <div class="flex flex-wrap gap-6 justify-center">
                    @forelse($earnedBadges as $badge)
                        <div class="flex flex-col items-center gap-2 group">
                            <div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-secondary shadow-md border-2 border-white group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">{{ $badge->badge_icon ?? 'workspace_premium' }}</span>
                            </div>
                            <span class="text-[10px] font-bold text-on-surface text-center leading-tight max-w-[80px]">{{ $badge->badge_name }}</span>
                        </div>
                    @empty
                        <div class="py-6 text-center opacity-40">
                            <span class="material-symbols-outlined text-4xl mb-2">lock</span>
                            <p class="text-xs font-bold">Selesaikan modul untuk <br>mendapatkan lencana!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Points History -->
        <section class="space-y-4">
            <h2 class="font-headline text-headline-sm text-on-surface px-2">Aktivitas Terbaru</h2>
            <div class="bg-white rounded-[2.5rem] border border-outline-variant/30 shadow-soft overflow-hidden">
                @forelse($logs as $log)
                    <div class="flex items-center justify-between p-5 {{ !$loop->last ? 'border-b border-outline-variant/30' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-surface-container-low flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[20px]">
                                    {{ str_contains($log->activity_type, 'Bonus') ? 'redeem' : 'task_alt' }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface">{{ $log->activity_type }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ $log->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-secondary font-headline font-bold">
                            +{{ $log->points }}
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-on-surface-variant italic text-sm">
                        Belum ada riwayat poin.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full h-14 rounded-2xl border-2 border-error/20 text-error font-bold flex items-center justify-center gap-2 hover:bg-error/5 transition-all">
                <span class="material-symbols-outlined">logout</span>
                Keluar Aplikasi
            </button>
        </form>
    </main>

    <!-- Bottom Nav -->
    <x-student-nav active="profil" />
</div>
@endsection
