@extends('layouts.app')

@section('title', 'Eksplorasi - ' . $module->title)

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
            <h1 class="font-headline text-headline-md text-primary">Fase 2: Eksplorasi (E)</h1>
            <p class="text-body-md text-on-surface-variant">Gunakan kacamata perspektifmu! Bagaimana perasaan mereka tentang isu ini?</p>
        </div>

        <!-- Perspective Card -->
        <section class="bg-white rounded-[2.5rem] overflow-hidden shadow-soft border border-outline-variant/30">
            <!-- Image Area -->
            <div class="w-full h-56 relative">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDmvcALWxhlpmk_rVKHP9IGDHoUd8rvYqFVc60-xQjb_GfCCt6pQGY8vUWq6VnTpOtnTSh3dk0OYIAjEG7uQQkIZmQ4PK4aaG0k-__sXsROoykP4H__R9byXh6fe_TGKIUpLN9sw_ITiV0ynGhXqSfBC2S9jIT99DzPclyjenSl-AAERpJbdlnn6Lkb6HfJiK-Qor6vexvVy5GjI5W4NFeWShbl9AOMJj9hm0KMcphLEhBQtoFWt8DkpbNKEMpAJEtYnb5_gjpmZMZE" 
                     alt="Aktivis Lingkungan" class="w-full h-full object-cover">
                <div class="absolute top-4 left-4 bg-secondary text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg">
                    Perspektif
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="p-8 text-center space-y-6">
                <h2 class="font-headline text-headline-md text-primary">Aktivis Lingkungan</h2>
                <div class="bg-surface-container-low p-6 rounded-3xl relative">
                    <span class="material-symbols-outlined text-primary/10 absolute top-2 left-2 text-6xl">format_quote</span>
                    <p class="text-body-lg text-on-surface font-medium italic relative z-10 leading-relaxed">
                        {{ $module->content['E']['text'] ?? '"Sungai yang kotor merusak rumah ikan dan tanaman kita. Kita harus segera bertindak sebelum terlambat!"' }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Emotion Interaction Section -->
        <section class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-soft space-y-6">
            <h3 class="font-headline text-label-lg text-primary text-center uppercase tracking-widest">Bagaimana perasaanmu?</h3>
            <div class="flex justify-between items-center px-2">
                @foreach(['😢', '☹️', '😐', '🙂', '😄'] as $emoji)
                    <button class="w-14 h-14 rounded-2xl bg-surface-container-low flex items-center justify-center text-3xl border border-outline-variant/30 hover:border-primary hover:bg-primary/5 transition-all active:scale-90">
                        {{ $emoji }}
                    </button>
                @endforeach
            </div>
        </section>

        <!-- Action Button -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Lanjut ke Diskusi</span>
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
