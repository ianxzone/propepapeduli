@extends('layouts.app')

@section('title', 'Peringkat - ProPePa PEDULI')

@section('content')
<div class="pb-24">
    <!-- Header -->
    <header class="bg-primary px-container-padding pt-10 pb-16 rounded-b-[3rem] shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <span class="material-symbols-outlined text-[200px] absolute -right-10 -bottom-10 rotate-12">leaderboard</span>
        </div>
        
        <div class="relative z-10 flex flex-col items-center text-center space-y-2">
            <h1 class="font-headline text-headline-lg text-white">Papan Peringkat</h1>
            <p class="text-white/80 text-sm italic">Jadilah agen perubahan terbaik!</p>
            
            <!-- User Current Rank Card -->
            <div class="mt-6 bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-3xl flex items-center gap-4 shadow-xl">
                <div class="w-12 h-12 bg-secondary rounded-2xl flex items-center justify-center text-white font-headline text-xl font-bold shadow-soft">
                    #{{ $rank }}
                </div>
                <div class="text-left">
                    <p class="text-[10px] font-bold text-white/70 uppercase tracking-widest">Peringkat Kamu</p>
                    <p class="text-white font-bold">{{ Auth::user()->points }} Poin</p>
                </div>
            </div>
        </div>
    </header>

    <main class="px-container-padding -mt-8 relative z-10">
        <div class="bg-white rounded-[2.5rem] shadow-soft border border-outline-variant/30 overflow-hidden">
            @foreach($topStudents as $index => $student)
                @php $isUser = $student->id === Auth::id(); @endphp
                <div class="flex items-center justify-between p-5 {{ !$loop->last ? 'border-b border-outline-variant/30' : '' }} {{ $isUser ? 'bg-primary/5' : '' }}">
                    <div class="flex items-center gap-4">
                        <div class="w-8 flex justify-center">
                            @if($index === 0)
                                <span class="material-symbols-outlined text-yellow-500 text-3xl" style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                            @elseif($index === 1)
                                <span class="material-symbols-outlined text-slate-400 text-2xl" style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                            @elseif($index === 2)
                                <span class="material-symbols-outlined text-amber-600 text-xl" style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                            @else
                                <span class="text-on-surface-variant font-bold">{{ $index + 1 }}</span>
                            @endif
                        </div>
                        
                        <div class="w-10 h-10 rounded-full {{ $isUser ? 'bg-primary text-white' : 'bg-surface-container-low text-on-surface' }} flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        
                        <div>
                            <p class="text-sm font-bold {{ $isUser ? 'text-primary' : 'text-on-surface' }}">
                                {{ $student->name }} {{ $isUser ? '(Kamu)' : '' }}
                            </p>
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest">{{ $student->class?->name ?? 'Siswa Mandiri' }}</p>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="font-headline font-bold text-secondary">{{ number_format($student->points) }}</p>
                        <p class="text-[8px] font-bold text-outline uppercase">Poin</p>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <!-- Bottom Nav -->
    <x-student-nav active="leaderboard" />
</div>
@endsection
