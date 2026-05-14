@extends('layouts.app')

@section('title', 'Jurnal Saya - ProPePa PEDULI')

@section('content')
<div class="pb-24">
    <!-- Header -->
    <header class="bg-secondary px-container-padding pt-10 pb-16 rounded-b-[3rem] shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <span class="material-symbols-outlined text-[200px] absolute -right-10 -bottom-10 rotate-12">edit_square</span>
        </div>
        
        <div class="relative z-10 space-y-2">
            <h1 class="font-headline text-headline-lg text-white">Jurnal Saya</h1>
            <p class="text-white/80 text-sm italic">Kumpulan refleksi dan aksi nyatamu.</p>
        </div>
    </header>

    <main class="px-container-padding -mt-8 relative z-10">
        <div class="space-y-6">
            @forelse($journals as $journal)
                <div class="bg-white rounded-[2.5rem] p-6 shadow-soft border border-outline-variant/30 space-y-4">
                    <div class="flex items-center justify-between border-b border-outline-variant/30 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                                {{ $journal->step }}
                            </div>
                            <div>
                                <h3 class="font-bold text-on-surface text-sm">{{ $journal->module->title }}</h3>
                                <p class="text-[10px] text-on-surface-variant">{{ $journal->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @if($journal->emotion_emoji)
                            <div class="text-2xl" title="Perasaan saat menulis">{{ $journal->emotion_emoji }}</div>
                        @endif
                    </div>
                    
                    <div class="space-y-3">
                        <p class="text-sm text-on-surface leading-relaxed italic">
                            "{{ $journal->content }}"
                        </p>
                        
                        @if($journal->teacher_feedback)
                            <div class="bg-secondary-container/10 p-4 rounded-2xl border border-secondary-container/20 space-y-2">
                                <div class="flex items-center gap-2 text-secondary">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">chat_bubble</span>
                                    <span class="text-xs font-bold uppercase tracking-widest">Umpan Balik Guru</span>
                                </div>
                                <p class="text-xs text-on-surface">{{ $journal->teacher_feedback }}</p>
                                @if($journal->teacher_points > 0)
                                    <div class="inline-flex items-center gap-1 bg-secondary text-white px-2 py-0.5 rounded-full text-[10px] font-bold">
                                        +{{ $journal->teacher_points }} Poin
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white p-16 rounded-[2.5rem] shadow-soft border border-outline-variant/30 text-center space-y-4">
                    <span class="material-symbols-outlined text-6xl text-outline-variant">edit_off</span>
                    <p class="text-on-surface-variant font-bold">Belum ada jurnal yang ditulis.<br>Ayo mulai belajar!</p>
                    <a href="{{ route('student.dashboard') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-2xl font-bold shadow-soft">Cari Modul</a>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Bottom Nav -->
    <x-student-nav active="jurnal" />
</div>
@endsection
