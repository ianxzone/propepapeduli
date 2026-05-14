@extends('layouts.app')

@section('title', 'Introspeksi - ' . $module->title)

@section('content')
<div class="pb-24">
    <!-- Top Header -->
    <header class="bg-white px-container-padding py-4 shadow-sm flex items-center justify-between sticky top-0 z-50">
        <x-logo variant="pill" />
        
        <div class="flex items-center gap-3">
            <div class="bg-secondary-container/10 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-secondary-container/20">
                <span class="material-symbols-outlined text-secondary text-lg" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="font-headline text-secondary font-bold">{{ Auth::user()->points }}</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold border-2 border-white shadow-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </header>

    <main class="px-container-padding pt-6 space-y-8">
        <!-- Header -->
        <section class="text-center space-y-4">
            <div class="inline-flex items-center justify-center bg-primary/10 text-primary px-5 py-2 rounded-full shadow-sm border border-primary/10">
                <span class="material-symbols-outlined mr-2 text-xl" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Fase Akhir: Introspeksi (I)</span>
            </div>
            <h1 class="font-headline text-headline-lg text-primary leading-tight">Hebat, Kamu Berhasil!</h1>
            <p class="text-body-lg text-on-surface-variant px-4">Mari kita lihat kembali perjalanan belajarmu hari ini.</p>
        </section>

        <!-- Achievement Badge Card -->
        <section>
            <div class="bg-white rounded-[2.5rem] p-10 shadow-soft border border-outline-variant/30 flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-secondary-container/10 to-transparent pointer-events-none"></div>
                <div class="w-32 h-32 bg-secondary-container rounded-full flex items-center justify-center mb-6 shadow-lg border-4 border-white">
                    <span class="material-symbols-outlined text-6xl text-secondary" style="font-variation-settings: 'FILL' 1;">{{ $module->badge_icon ?? 'workspace_premium' }}</span>
                </div>
                <h2 class="font-headline text-headline-md text-on-surface">{{ $module->badge_name ?? 'Lencana Modul' }}</h2>
                <p class="text-sm text-on-surface-variant mt-2">Kamu berhasil menyelesaikan seluruh tantangan dalam modul ini!</p>
            </div>
        </section>

        <!-- Reflection Section -->
        <section class="bg-white p-8 rounded-[2rem] border border-outline-variant/30 shadow-soft space-y-4">
            <label class="block font-headline text-headline-md text-primary" for="reflection">
                {{ $module->content['I']['questions'] ?? 'Apa yang paling kamu pelajari hari ini?' }}
            </label>
            <textarea id="reflection" name="content" rows="4" 
                      class="w-full rounded-2xl border-2 border-outline-variant/30 focus:border-primary focus:ring-0 bg-surface-container-low p-4 text-sm text-on-surface placeholder:text-outline-variant transition-all" 
                      placeholder="Tuliskan pengalaman seru kamu di sini..."></textarea>
        </section>

        <!-- Final CTA -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Selesai & Kembali ke Beranda</span>
                <span class="material-symbols-outlined">home</span>
            </button>
        </form>
    </main>

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-lg border-t border-outline-variant/30 px-6 py-3 flex justify-between items-center z-50">
        <a href="{{ route('student.dashboard') }}" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">home</span>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">menu_book</span>
            <span class="text-[10px] font-bold">Modul</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">forum</span>
            <span class="text-[10px] font-bold">Diskusi</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">edit_square</span>
            <span class="text-[10px] font-bold">Jurnal</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </nav>
</div>
@endsection
