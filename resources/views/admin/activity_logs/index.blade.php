@extends('layouts.admin')

@section('title', 'Log Aktivitas - Admin ProPePa')
@section('header_title', 'Log Aktivitas Sistem')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-on-surface">Riwayat Aktivitas</h2>
            <p class="text-sm text-on-surface-variant">Pantau perubahan data dan aktivitas penting di sistem.</p>
        </div>
        <form action="{{ route('admin.activity-logs.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membersihkan semua log? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center gap-2 bg-error-container text-on-error-container px-4 py-2 rounded-xl font-bold text-sm hover:bg-error/20 transition-all border border-error/10">
                <span class="material-symbols-outlined text-sm">delete_sweep</span>
                Bersihkan Log
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-6 py-4 font-bold text-sm text-on-surface uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 font-bold text-sm text-on-surface uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 font-bold text-sm text-on-surface uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-4 font-bold text-sm text-on-surface uppercase tracking-wider">Modul</th>
                        <th class="px-6 py-4 font-bold text-sm text-on-surface uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-4 font-bold text-sm text-on-surface uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse($logs as $log)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="px-6 py-4 text-sm text-on-surface-variant whitespace-nowrap">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                        {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-on-surface">{{ $log->user->name ?? 'Guest/System' }}</div>
                                        <div class="text-[10px] text-on-surface-variant uppercase">{{ $log->user->role ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $actionClass = match($log->action) {
                                        'created' => 'bg-primary/10 text-primary',
                                        'updated' => 'bg-secondary/10 text-secondary',
                                        'deleted' => 'bg-error/10 text-error',
                                        'login' => 'bg-tertiary/10 text-tertiary',
                                        default => 'bg-outline-variant/10 text-on-surface-variant'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $actionClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-on-surface">
                                {{ $log->module }}
                            </td>
                            <td class="px-6 py-4 text-xs text-on-surface-variant max-w-xs truncate">
                                {{ $log->details }}
                            </td>
                            <td class="px-6 py-4 text-xs text-on-surface-variant font-mono">
                                {{ $log->ip_address }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-20">history</span>
                                <p>Belum ada log aktivitas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
