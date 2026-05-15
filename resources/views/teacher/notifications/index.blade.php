@extends('layouts.teacher')

@section('title', 'Notifikasi - ProPePa')
@section('header_title', 'Notifikasi Aktivitas')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-on-surface-variant text-sm">Pantau aktivitas terbaru dari siswa Anda.</h2>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-soft border border-outline-variant/30 overflow-hidden">
        <div class="divide-y divide-outline-variant/20">
            @forelse($notifications as $notif)
            <div class="p-6 flex gap-4 {{ $notif->read_at ? 'bg-white' : 'bg-primary/5' }} transition-colors hover:bg-surface-container-low/50">
                <div class="w-12 h-12 rounded-2xl {{ $notif->type === 'module_completed' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">
                        {{ $notif->type === 'module_completed' ? 'task_alt' : 'history_edu' }}
                    </span>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h4 class="font-bold text-on-surface">{{ $notif->title }}</h4>
                            <p class="text-sm text-on-surface-variant mt-1">{{ $notif->message }}</p>
                        </div>
                        <span class="text-[10px] text-on-surface-variant whitespace-nowrap bg-surface-container px-2 py-1 rounded-full">
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="mt-4 flex items-center gap-3">
                        <a href="{{ route('teacher.student.detail', ['student' => $notif->user_id, 'module_id' => $notif->module_id]) }}" class="text-primary text-xs font-bold hover:underline flex items-center gap-1">
                            Lihat Detail Siswa
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-on-surface-variant italic">
                <span class="material-symbols-outlined text-4xl mb-2 opacity-30">notifications_off</span>
                <p>Belum ada notifikasi baru.</p>
            </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
        <div class="p-4 border-t border-outline-variant/20">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
