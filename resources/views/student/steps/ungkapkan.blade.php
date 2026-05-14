@extends('layouts.app')

@section('title', 'Ungkapkan - ' . $module->title)

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
        <div class="text-center space-y-2">
            <div class="inline-block bg-primary text-white rounded-full px-4 py-1 font-label text-[10px] uppercase tracking-widest font-bold shadow-md">
                Fase 4: Ungkapkan (U)
            </div>
            <h1 class="font-headline text-headline-lg text-primary">Jurnal Empati Digital</h1>
            <p class="text-body-md text-on-surface-variant">
                {{ $module->content['U']['task'] ?? 'Bagaimana perasaanmu setelah mempelajari isu ini? Ungkapkan dalam jurnalmu!' }}
            </p>
        </div>

        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Emotional Selection -->
            <section class="space-y-4">
                <h2 class="font-headline text-on-surface font-bold">Pilih Perasaanmu:</h2>
                <div class="flex overflow-x-auto no-scrollbar gap-4 pb-4 -mx-container-padding px-container-padding">
                    @php
                        $emotions = [
                            ['😊', 'Senang'], ['🤔', 'Peduli'], ['😢', 'Sedih'], 
                            ['😟', 'Khawatir'], ['😠', 'Marah'], ['💪', 'Semangat']
                        ];
                    @endphp
                    @foreach($emotions as $emotion)
                        <label class="flex-shrink-0 cursor-pointer">
                            <input type="radio" name="emotion" value="{{ $emotion[1] }}" class="hidden peer">
                            <div class="w-24 h-28 bg-white rounded-3xl shadow-sm border-2 border-transparent peer-checked:border-primary peer-checked:bg-primary/5 flex flex-col items-center justify-center gap-2 transition-all">
                                <span class="text-4xl">{{ $emotion[0] }}</span>
                                <span class="text-xs font-bold text-on-surface-variant peer-checked:text-primary">{{ $emotion[1] }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </section>

            <!-- Writing Area (Book Style) -->
            <section class="bg-white rounded-[2.5rem] shadow-soft border border-outline-variant/30 p-8 relative overflow-hidden">
                <!-- Binding effect left side -->
                <div class="absolute left-0 top-0 bottom-0 w-4 bg-gradient-to-r from-surface-variant/20 to-transparent"></div>
                
                <div class="space-y-4">
                    <textarea name="content" 
                              class="w-full min-h-[250px] bg-transparent border-none resize-none focus:ring-0 text-body-lg text-on-surface p-0 leading-[32px] placeholder:text-outline-variant" 
                              placeholder="Mulai menulis jurnalmu di sini..."
                              style="background-image: repeating-linear-gradient(transparent, transparent 31px, #e2bfb9 32px); background-attachment: local;"></textarea>
                    
                    <div class="flex justify-center pt-4">
                        <button type="button" class="flex items-center gap-2 bg-surface-container-low text-primary px-6 py-3 rounded-full border border-outline-variant/30 active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">mic</span>
                            <span class="text-sm font-bold">Rekam Suara</span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Action Button -->
            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Simpan & Lanjut ke Lakukan</span>
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
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">menu_book</span>
            <span class="text-[10px] font-bold">Modul</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">forum</span>
            <span class="text-[10px] font-bold">Diskusi</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">edit_square</span>
            <span class="text-[10px] font-bold">Jurnal</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </nav>
</div>
@endsection
