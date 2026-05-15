@extends('layouts.admin')

@section('title', 'Detail Progres Siswa - Admin ProPePa')

@section('content')
<div class="min-h-screen bg-surface-container-low pb-8">
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.students.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container transition-colors shadow-sm">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="font-headline text-headline-md text-on-surface">Detail Progres Siswa</h1>
                <p class="text-sm text-on-surface-variant">Memantau aktivitas dan jurnal {{ $student->name }}</p>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Student Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-8 border border-outline-variant/30 shadow-sm text-center">
                <div class="w-24 h-24 rounded-full bg-primary-container text-white flex items-center justify-center text-3xl font-bold mx-auto mb-6 shadow-soft">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <h2 class="font-headline text-2xl font-bold text-on-surface mb-1">{{ $student->name }}</h2>
                <p class="text-on-surface-variant text-sm mb-6">{{ $student->class->name }} &bull; {{ $student->class->school->name }}</p>
                
                <div class="grid grid-cols-1 gap-4 text-left">
                    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/20">
                        <p class="text-[10px] uppercase font-bold text-outline mb-1">Total Poin</p>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-yellow-600">stars</span>
                            <span class="text-xl font-bold text-on-surface">{{ number_format($student->points) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Activity Timeline -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-headline text-xl text-on-surface">Timeline Aktivitas</h3>
                <span class="text-xs text-on-surface-variant bg-surface-container px-3 py-1 rounded-full font-bold">{{ $journals->count() }} Aktivitas</span>
            </div>

            <div class="space-y-6">
                @forelse($journals as $journal)
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 border border-outline-variant/30 shadow-sm relative" id="journal-{{ $journal->id }}">
                        <!-- Module Tag -->
                        <div class="absolute top-6 right-6 text-right">
                            <span class="text-xs text-on-surface-variant font-bold bg-surface-container px-3 py-1 rounded-full">Modul: {{ $journal->module->title }}</span>
                            <div class="text-[10px] text-on-surface-variant mt-1">{{ $journal->created_at->format('d M Y, H:i') }}</div>
                        </div>

                        <div class="flex items-center gap-3 mb-4">
                            @if($journal->step == 'U')
                                <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">edit_square</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Jurnal Empati (Ungkapkan)</h4>
                                    <p class="text-sm text-on-surface-variant flex items-center gap-1">
                                        Perasaan: <span class="font-bold text-on-surface">{{ $journal->emotion_emoji }}</span>
                                    </p>
                                </div>
                            @elseif($journal->step == 'P')
                                <div class="w-12 h-12 rounded-full bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">menu_book</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Tahap Pelajari (P)</h4>
                                </div>
                            @elseif($journal->step == 'E')
                                <div class="w-12 h-12 rounded-full bg-teal-500/10 text-teal-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">explore</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Tahap Eksplorasi (E)</h4>
                                </div>
                            @elseif($journal->step == 'D')
                                <div class="w-12 h-12 rounded-full bg-purple-500/10 text-purple-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">forum</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Tahap Diskusi (D)</h4>
                                </div>
                            @elseif($journal->step == 'L')
                                <div class="w-12 h-12 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Aksi Nyata (Lakukan)</h4>
                                </div>
                            @elseif($journal->step == 'S')
                                <div class="w-12 h-12 rounded-full bg-blue-500/10 text-blue-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">assignment</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Evaluasi Akhir (Essay Empati)</h4>
                                    <p class="text-xs text-blue-600 font-bold">Rubrik Skala 1-4</p>
                                </div>
                            @elseif($journal->step == 'I')
                                <div class="w-12 h-12 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">psychology</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Refleksi Akhir (Introspeksi)</h4>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 p-6 bg-surface-container-lowest rounded-3xl border border-outline-variant/20 relative">
                            <span class="material-symbols-outlined absolute -top-3 -left-3 bg-white text-primary rounded-full p-1 border border-outline-variant/30 text-sm">format_quote</span>
                            <div class="text-on-surface leading-relaxed whitespace-pre-wrap italic">{{ $journal->content }}</div>
                            
                            @if($journal->image)
                                <div class="mt-4">
                                    <img src="{{ asset('storage/' . $journal->image) }}" alt="Lampiran" class="rounded-2xl max-h-64 object-contain border border-outline-variant/30">
                                </div>
                            @endif
                        </div>

                        @if($journal->step == 'S')
                            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <div class="p-3 bg-blue-50 rounded-2xl border border-blue-100 text-center">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">Emosional</p>
                                    <p class="text-lg font-bold text-blue-700">{{ $journal->score_emotional ?? '-' }}</p>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-2xl border border-blue-100 text-center">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">Perspektif</p>
                                    <p class="text-lg font-bold text-blue-700">{{ $journal->score_perspective ?? '-' }}</p>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-2xl border border-blue-100 text-center">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">Kepedulian</p>
                                    <p class="text-lg font-bold text-blue-700">{{ $journal->score_care ?? '-' }}</p>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-2xl border border-blue-100 text-center">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">Tanggung Jawab</p>
                                    <p class="text-lg font-bold text-blue-700">{{ $journal->score_responsibility ?? '-' }}</p>
                                </div>
                            </div>
                        @endif

                        @if($journal->teacher_feedback)
                            <div class="mt-6 p-4 bg-primary/5 rounded-2xl border border-primary/10">
                                <p class="text-[10px] font-bold text-primary uppercase mb-2 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">comment</span>
                                    Umpan Balik Guru
                                </p>
                                <p class="text-sm text-on-surface italic">"{{ $journal->teacher_feedback }}"</p>
                                @if($journal->teacher_points)
                                    <p class="mt-2 text-[10px] font-bold text-secondary">Nilai: {{ $journal->teacher_points }} Poin</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-[2rem] p-12 border border-dashed border-outline-variant/50 text-center">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4">history</span>
                        <p class="text-on-surface-variant italic">Belum ada aktivitas yang tercatat untuk siswa ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
