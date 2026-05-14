@extends('layouts.app')

@section('title', 'Beranda - ProPePa')

@section('content')
<div class="pb-24">
    <!-- Top Header -->
    <header class="bg-white px-container-padding py-4 shadow-sm flex items-center justify-between sticky top-0 z-50">
        <x-logo variant="pill" />
        
        <div class="flex items-center gap-3">
            <div class="bg-secondary-container/10 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-secondary-container/20">
                <span class="material-symbols-outlined text-secondary text-lg" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="font-headline text-secondary font-bold">{{ $user->points }}</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold border-2 border-white shadow-sm">
                {{ substr($user->name, 0, 1) }}
            </div>
        </div>
    </header>

    <main class="px-container-padding pt-6 space-y-8">
        <!-- Welcome Section -->
        <section>
            <h2 class="font-headline text-headline-md text-on-surface">Halo, {{ explode(' ', $user->name)[0] }}!</h2>
            <p class="text-body-md text-on-surface-variant mt-1">Ayo lanjut belajar hari ini.</p>
        </section>

        <!-- Module Progress List -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-headline text-lg text-on-surface">Modul Belajarmu</h3>
                <a href="#" class="text-primary font-label text-sm">Lihat Semua</a>
            </div>

            @foreach($modules as $module)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-outline-variant/30 group active:scale-[0.98] transition-all">
                <div class="h-40 relative">
                    <img src="{{ $module->thumbnail }}" 
                         alt="{{ $module->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Aktif</span>
                        <h4 class="text-white font-headline text-headline-md mt-1">{{ $module->title }}</h4>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant font-medium">Progres Belajar</span>
                        <span class="text-primary font-bold">{{ $module->current_step_index }}/6 Tahap</span>
                    </div>
                    <div class="w-full bg-surface h-3 rounded-full overflow-hidden border border-outline-variant/10">
                        <div class="bg-primary h-full rounded-full transition-all duration-500 shadow-[0_0_12px_rgba(87,0,0,0.2)]" 
                             style="width: {{ ($module->current_step_index / 6) * 100 }}%"></div>
                    </div>
                    
                    <!-- Steps Indicator -->
                    <div class="flex justify-between items-center pt-2">
                        @php
                            $stepLabels = ['P', 'E', 'D', 'U', 'L', 'I'];
                            $stepMap = ['P' => 1, 'E' => 2, 'D' => 3, 'U' => 4, 'L' => 5, 'I' => 6];
                        @endphp
                        @foreach($stepLabels as $label)
                            @php 
                                $isCompleted = $module->current_step_index >= $stepMap[$label];
                                $isCurrent = $module->current_step_index == $stepMap[$label];
                            @endphp
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold transition-all
                                    {{ $isCompleted ? 'bg-primary text-white shadow-sm' : 'bg-surface text-outline border border-outline-variant/30' }}
                                    {{ $isCurrent ? 'ring-2 ring-primary ring-offset-2' : '' }}">
                                    {{ $label }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($module->is_completed)
                        <div class="block w-full py-4 bg-green-100 text-green-700 text-center rounded-2xl font-headline font-bold flex items-center justify-center gap-2 border border-green-200">
                            <span class="material-symbols-outlined">verified</span>
                            <span>Sudah Selesai</span>
                        </div>
                    @else
                        <a href="{{ route('student.module.show', $module->id) }}" class="block w-full py-4 bg-primary text-white text-center rounded-2xl font-headline text-button-text shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000]">
                            Lanjutkan Belajar
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </section>

        <!-- Badge Collection Section -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-headline text-lg text-on-surface">Koleksi Lencanamu</h3>
                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold">{{ $completedModules->count() }} Lencana</span>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-outline-variant/30">
                <div class="grid grid-cols-3 gap-6">
                    @forelse($completedModules as $module)
                        <div class="flex flex-col items-center gap-2 group">
                            <div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container shadow-inner border-2 border-white group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">{{ $module->badge_icon ?? 'workspace_premium' }}</span>
                            </div>
                            <span class="text-[10px] font-bold text-center text-on-surface leading-tight">{{ $module->badge_name ?? $module->title }}</span>
                        </div>
                    @empty
                        <div class="col-span-3 py-8 text-center">
                            <div class="w-16 h-16 bg-surface rounded-full flex items-center justify-center mx-auto mb-3 border border-dashed border-outline-variant">
                                <span class="material-symbols-outlined text-outline">lock</span>
                            </div>
                            <p class="text-xs text-on-surface-variant font-medium">Selesaikan modul untuk <br>mendapatkan lencana!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <!-- Bottom Navigation Bar -->
    <x-student-nav active="home" />
</div>
@endsection
