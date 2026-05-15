@extends('layouts.teacher')

@section('title', 'Forum Diskusi - ProPePa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-headline text-headline-md text-on-surface">Forum Diskusi Siswa</h2>
            <p class="text-on-surface-variant text-sm">Pantau interaksi siswa di setiap modul pada {{ $class->name }}.</p>
        </div>
        
        <!-- Selectors -->
        <form action="{{ route('teacher.forum.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-outline uppercase tracking-widest whitespace-nowrap">Modul:</label>
                <select name="module_id" onchange="this.form.submit()" class="bg-white border border-outline-variant/30 rounded-xl px-4 py-2 text-xs font-bold focus:border-primary focus:ring-0">
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ $selectedModuleId == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-outline uppercase tracking-widest whitespace-nowrap">Kelompok:</label>
                <select name="group_id" onchange="this.form.submit()" class="bg-white border border-outline-variant/30 rounded-xl px-4 py-2 text-xs font-bold focus:border-primary focus:ring-0">
                    <option value="">Semua Kelompok</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ $selectedGroupId == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Chat Monitoring Area -->
    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col h-[600px]">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">forum</span>
                <span class="font-bold">Diskusi Kelas</span>
            </div>
            <span class="text-xs font-medium text-on-surface-variant">{{ count($messages) }} Pesan Terkirim</span>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-surface-container-lowest">
            @forelse($messages as $msg)
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-primary-container text-white flex items-center justify-center font-bold shrink-0">
                        {{ substr($msg->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-baseline gap-2 mb-1">
                            <span class="font-bold text-sm text-on-surface">{{ $msg->user->name }}</span>
                            @if($msg->group)
                                <span class="bg-secondary/10 text-secondary text-[8px] font-bold px-2 py-0.5 rounded-full border border-secondary/20">{{ $msg->group->name }}</span>
                            @endif
                            <span class="text-[10px] text-on-surface-variant">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                        <div class="bg-white border border-outline-variant/20 p-4 rounded-2xl rounded-tl-none shadow-sm inline-block max-w-[80%]">
                            <p class="text-sm text-on-surface leading-relaxed">{{ $msg->content }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center text-on-surface-variant italic">
                    <span class="material-symbols-outlined text-5xl mb-3 opacity-20">chat_bubble</span>
                    <p>Belum ada diskusi di modul ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
