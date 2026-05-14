@extends('layouts.app')

@section('title', 'Pelajari - ' . $module->title)

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
        <!-- Step Indicator & Title -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-xl">menu_book</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Fase 1: Pelajari (P)</span>
            </div>
            <h1 class="font-headline text-headline-lg text-on-surface leading-tight">{{ $module->title }}</h1>
            <p class="text-body-md text-on-surface-variant">Tonton video di bawah ini untuk memahami materi.</p>
        </div>

        <!-- Video Player Section -->
        <section>
            @php
                $videoUrl = $module->content['P']['video_url'] ?? '';
                $videoId = '';
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match)) {
                    $videoId = $match[1];
                }
            @endphp

            @if($videoId)
            <div class="relative w-full rounded-3xl overflow-hidden shadow-lg bg-black aspect-video border-4 border-white">
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            @else
            <div class="relative w-full rounded-3xl overflow-hidden shadow-lg bg-black aspect-video group border-4 border-white">
                <img src="{{ $module->thumbnail }}" 
                     alt="Video Thumbnail" class="w-full h-full object-cover opacity-80">
                <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                    <div class="bg-white/20 backdrop-blur-md px-6 py-3 rounded-full text-white font-bold">
                        Video Materi Belum Tersedia
                    </div>
                </div>
            </div>
            @endif
            
            <div class="mt-4 space-y-3">
                <div class="flex items-center gap-3 bg-surface-container-low p-4 rounded-2xl border border-outline-variant/30">
                    <div class="w-10 h-10 bg-secondary-container/20 rounded-full flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-xl">lightbulb</span>
                    </div>
                    <p class="text-sm text-on-surface font-medium italic">
                        {{ $module->content['P']['text'] ?? 'Perhatikan materi dalam video untuk memahami topik ini dengan baik.' }}
                    </p>
                </div>

                @if(!empty($module->content['P']['file_url']))
                <a href="{{ $module->content['P']['file_url'] }}" target="_blank" 
                   class="flex items-center justify-between bg-primary/5 p-4 rounded-2xl border border-primary/10 group hover:bg-primary transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 group-hover:bg-white/20 rounded-xl flex items-center justify-center text-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-xl">description</span>
                        </div>
                        <span class="text-sm font-bold text-on-surface group-hover:text-white transition-colors">Lihat Materi Tambahan (PDF/Slide)</span>
                    </div>
                    <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors">open_in_new</span>
                </a>
                @endif
            </div>
        </section>

        <!-- Informational Section -->
        <section class="space-y-4">
            <h2 class="font-headline text-headline-md text-on-surface">Apa yang akan kamu pelajari?</h2>
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-white p-5 rounded-3xl border border-outline-variant/30 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">science</span>
                    </div>
                    <div>
                        <h3 class="font-headline text-on-surface font-bold">Konsep Dasar</h3>
                        <p class="text-sm text-on-surface-variant mt-1">Memahami latar belakang dan pentingnya topik ini bagi lingkungan.</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-3xl border border-outline-variant/30 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 bg-secondary-container/10 text-secondary rounded-2xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">volunteer_activism</span>
                    </div>
                    <div>
                        <h3 class="font-headline text-on-surface font-bold">Nilai Pancasila</h3>
                        <p class="text-sm text-on-surface-variant mt-1">Bagaimana topik ini berhubungan dengan karakter kita sebagai pelajar Pancasila.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Action Button -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Lanjut ke Eksplorasi</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>
    </main>

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-lg border-t border-outline-variant/30 px-6 py-3 flex justify-between items-center z-50">
        <a href="{{ route('student.dashboard') }}" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">menu_book</span>
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
