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
            
            @if(!empty($module->content['I']['teacher_instruction']))
            <div class="bg-primary/5 p-4 rounded-2xl border border-primary/10 flex gap-3 text-left">
                <span class="material-symbols-outlined text-primary">record_voice_over</span>
                <div class="prose prose-sm prose-primary max-w-none text-on-surface leading-relaxed">
                    {!! $module->content['I']['teacher_instruction'] !!}
                </div>
            </div>
            @endif

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

        <!-- Final CTA -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Reflection Section -->
            <section class="bg-white p-8 rounded-[2rem] border border-outline-variant/30 shadow-soft space-y-4 text-left">
                <div class="prose prose-primary max-w-none text-on-surface leading-relaxed">
                    {!! $module->content['I']['questions'] ?? 'Apa yang paling kamu pelajari hari ini?' !!}
                </div>
                <textarea id="reflection" name="content" rows="4" required
                          class="w-full rounded-2xl border-2 border-outline-variant/30 focus:border-primary focus:ring-0 bg-surface-container-low p-4 text-sm text-on-surface placeholder:text-outline-variant transition-all" 
                          placeholder="Tuliskan pengalaman seru kamu di sini..."></textarea>
            </section>

            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Lanjut ke Evaluasi Akhir</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>
    </main>

    <!-- Bottom Navigation Bar -->
    <x-student-nav active="modul" />
</div>
@endsection
