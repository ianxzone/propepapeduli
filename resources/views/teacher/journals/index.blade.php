@extends('layouts.teacher')

@section('title', 'Penilaian Jurnal - ProPePa')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-headline text-headline-md text-on-surface">Penilaian Jurnal</h2>
            <p class="text-on-surface-variant text-sm">Lihat dan beri umpan balik pada jurnal harian siswa {{ $class->name }}.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-sm border-b border-outline-variant/30">
                        <th class="p-4 font-bold">Waktu</th>
                        <th class="p-4 font-bold">Siswa</th>
                        <th class="p-4 font-bold">Modul / Fase</th>
                        <th class="p-4 font-bold">Isi Jurnal</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($journals as $journal)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="p-4 text-xs text-on-surface-variant whitespace-nowrap">
                            {{ $journal->created_at->format('d/m/y H:i') }}
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-[10px] font-bold">
                                    {{ substr($journal->user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-sm">{{ $journal->user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-xs font-bold text-on-surface">{{ $journal->module->title }}</div>
                            <div class="text-[10px] text-on-surface-variant">Fase: {{ $journal->step }}</div>
                        </td>
                        <td class="p-4">
                            <p class="text-xs text-on-surface line-clamp-1 max-w-xs italic">"{{ $journal->content }}"</p>
                        </td>
                        <td class="p-4">
                            @if($journal->teacher_feedback)
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                    Dinilai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full text-[10px] font-bold">
                                    <span class="material-symbols-outlined text-[12px]">pending</span>
                                    Belum
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('teacher.student.detail', $journal->user->id) }}#journal-{{ $journal->id }}" class="text-primary hover:bg-primary/10 p-2 rounded-lg transition-colors text-xs font-bold">
                                Beri Umpan Balik
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-on-surface-variant italic">Belum ada jurnal yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($journals->hasPages())
        <div class="p-4 border-t border-outline-variant/30 bg-surface-container-low">
            {{ $journals->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
