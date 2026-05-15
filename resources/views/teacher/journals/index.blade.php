@extends('layouts.teacher')

@section('title', 'Penilaian Jurnal - ProPePa')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="font-headline text-headline-md text-on-surface">Penilaian Jurnal</h2>
                @if(in_array(Auth::user()->role, ['admin', 'dosen']))
                    <form action="{{ route('teacher.journals.index') }}" method="GET" id="class-selector-form">
                        <select name="class_id" onchange="this.form.submit()" class="bg-surface-container-low border-none rounded-full px-4 py-1 text-xs font-bold text-primary focus:ring-2 focus:ring-primary">
                            <option value="">Pilih Kelas...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ ($class?->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
            <p class="text-on-surface-variant text-sm">Lihat dan beri umpan balik pada jurnal harian siswa {{ $class?->name ?? '---' }}.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-[10px] uppercase tracking-wider border-b border-outline-variant/30">
                        <th class="p-4 font-bold">Waktu</th>
                        <th class="p-4 font-bold">Siswa</th>
                        <th class="p-4 font-bold">Fase & Modul</th>
                        <th class="p-4 font-bold">Respon Siswa</th>
                        <th class="p-4 font-bold text-center">Status</th>
                        <th class="p-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($journals as $journal)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="p-4 text-[10px] text-on-surface-variant whitespace-nowrap">
                            {{ $journal->created_at->format('d/m/y') }}<br>
                            <span class="opacity-50">{{ $journal->created_at->format('H:i') }}</span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold">
                                    {{ substr($journal->user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-xs text-on-surface">{{ $journal->user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            @php
                                $stepNames = [
                                    'P' => 'Pelajari', 'E' => 'Eksplorasi', 'D' => 'Diskusi',
                                    'U' => 'Ungkapkan', 'L' => 'Lakukan', 'I' => 'Introspeksi', 'S' => 'Evaluasi'
                                ];
                                $stepLabel = $stepNames[$journal->step] ?? $journal->step;
                            @endphp
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-surface-container text-on-surface-variant font-bold text-[9px] uppercase mb-1">
                                <span>Tahap {{ $journal->step }}: {{ $stepLabel }}</span>
                            </div>
                            <div class="text-[10px] text-on-surface-variant italic truncate max-w-[150px]">{{ $journal->module->title }}</div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-start gap-3">
                                @if($journal->image)
                                    <img src="{{ str_starts_with($journal->image, 'http') ? $journal->image : asset($journal->image) }}" 
                                         class="w-12 h-12 rounded-lg object-cover border border-outline-variant/30 shrink-0 shadow-sm">
                                @endif
                                    @if($journal->emotion_emoji)
                                        <span class="text-lg mr-1">{{ $journal->emotion_emoji }}</span>
                                    @endif
                                    @if($journal->step === 'S' && str_starts_with($journal->content, '{'))
                                        <span class="text-xs text-blue-600 font-bold italic flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">fact_check</span>
                                            Siswa telah mengisi 4 Dimensi Evaluasi Essay
                                        </span>
                                    @else
                                        <span class="text-xs text-on-surface leading-relaxed line-clamp-2 italic">"{{ $journal->content }}"</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            @if($journal->teacher_feedback)
                                <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2 py-1 rounded-full text-[9px] font-bold border border-green-100">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                    DINILAI
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-700 px-2 py-1 rounded-full text-[9px] font-bold border border-orange-100">
                                    <span class="material-symbols-outlined text-[14px]">pending</span>
                                    BELUM
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('teacher.student.detail', ['student' => $journal->user->id, 'module_id' => $journal->module_id]) }}#journal-{{ $journal->id }}" 
                               class="inline-flex items-center gap-1 bg-primary text-white px-4 py-2 rounded-xl text-[10px] font-bold shadow-sm hover:bg-primary/90 transition-all">
                                <span>Beri Nilai</span>
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-on-surface-variant italic text-sm">Belum ada jurnal yang masuk untuk dinilai.</td>
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
