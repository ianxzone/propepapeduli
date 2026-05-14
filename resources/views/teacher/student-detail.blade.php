@extends('layouts.teacher')

@section('title', 'Detail Siswa: ' . $student->name)

@section('content')
<div class="min-h-screen bg-surface-container-low pb-8">
    <main class="pt-2 space-y-8">
        
        <!-- Student Profile Card -->
        <section class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-outline-variant/30 flex flex-col md:flex-row items-center gap-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full pointer-events-none"></div>
            
            <div class="w-24 h-24 rounded-full bg-primary-container text-white flex items-center justify-center text-4xl font-headline font-bold shrink-0 shadow-soft">
                {{ substr($student->name, 0, 1) }}
            </div>
            
            <div class="text-center md:text-left flex-1">
                <h2 class="font-headline text-headline-lg text-on-surface mb-1">{{ $student->name }}</h2>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-3">
                    <span class="inline-flex items-center gap-1 bg-secondary-container/20 text-secondary px-3 py-1.5 rounded-full text-sm font-bold">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">stars</span>
                        {{ $student->points }} Poin
                    </span>
                    <span class="inline-flex items-center gap-1 bg-surface-container-high text-on-surface-variant px-3 py-1.5 rounded-full text-sm font-bold">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">school</span>
                        Kelas {{ $student->class->name }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Modul Progress Summary -->
        <section>
            <h3 class="font-headline text-headline-md text-on-surface mb-4">Progres Modul</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($modules as $module)
                    @php
                        $progress = $student->progress()->where('module_id', $module->id)->first();
                        $stepMap = ['P' => 1, 'E' => 2, 'D' => 3, 'U' => 4, 'L' => 5, 'I' => 6];
                        $currentIndex = $progress ? $stepMap[$progress->current_step] : 0;
                        if($progress && $progress->is_completed) $currentIndex = 6;
                    @endphp
                    <div class="bg-white rounded-2xl p-5 border border-outline-variant/30 shadow-sm flex items-center gap-4">
                        <img src="{{ $module->thumbnail }}" alt="{{ $module->title }}" class="w-16 h-16 rounded-xl object-cover shrink-0">
                        <div class="flex-1">
                            <h4 class="font-bold text-on-surface text-sm">{{ $module->title }}</h4>
                            <div class="flex items-center justify-between text-xs mt-2 mb-1">
                                <span class="text-on-surface-variant">{{ $currentIndex }}/6 Tahap</span>
                                <span class="text-primary font-bold">{{ round(($currentIndex/6)*100) }}%</span>
                            </div>
                            <div class="w-full bg-surface h-1.5 rounded-full overflow-hidden">
                                <div class="bg-primary h-full rounded-full" style="width: {{ ($currentIndex/6)*100 }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Journals & Feedback -->
        <section>
            <h3 class="font-headline text-headline-md text-on-surface mb-4">Jurnal & Refleksi Siswa</h3>
            
            @if(session('success'))
                <div class="bg-[#d4edda] text-[#155724] p-4 rounded-xl text-sm font-bold mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($journals as $journal)
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 border border-outline-variant/30 shadow-sm relative">
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
                            @else
                                <div class="w-12 h-12 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">psychology</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">Refleksi Akhir (Introspeksi)</h4>
                                </div>
                            @endif
                        </div>

                        <!-- Student's Writing -->
                        <div class="bg-surface-container-low p-5 rounded-2xl mb-6 border border-outline-variant/20 relative">
                            <span class="material-symbols-outlined absolute top-4 left-4 text-outline-variant/30 text-4xl">format_quote</span>
                            <p class="text-body-md text-on-surface italic relative z-10 pl-8">{{ $journal->content ?? 'Siswa belum menuliskan apa-apa.' }}</p>
                        </div>

                        <!-- Teacher Feedback Form -->
                        <form action="{{ route('teacher.journal.feedback', $journal->id) }}" method="POST" class="space-y-4 pt-4 border-t border-outline-variant/30">
                            @csrf
                            <div>
                                <label class="block font-bold text-sm text-on-surface mb-2">Umpan Balik Guru</label>
                                <textarea name="teacher_feedback" rows="3" 
                                          class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 text-sm p-3 bg-white"
                                          placeholder="Tulis pujian atau saran untuk siswa...">{{ $journal->teacher_feedback }}</textarea>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4 justify-between">
                                <div class="flex items-center gap-3">
                                    <label class="font-bold text-sm text-on-surface">Poin Bonus (+):</label>
                                    <input type="number" name="teacher_points" min="0" max="50" value="{{ $journal->teacher_points }}" 
                                           class="w-24 rounded-lg border border-outline-variant/50 p-2 text-center text-sm font-bold focus:border-secondary focus:ring-0">
                                </div>
                                <button type="submit" class="bg-primary text-white font-bold text-sm px-6 py-2.5 rounded-xl hover:bg-primary/90 transition-colors shadow-sm active:scale-95">
                                    Simpan Umpan Balik
                                </button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-12 bg-surface-container-low rounded-3xl border border-outline-variant/30">
                        <span class="material-symbols-outlined text-4xl text-outline-variant mb-2">auto_stories</span>
                        <p class="text-on-surface-variant font-medium">Siswa belum menulis jurnal apapun.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>
</div>
@endsection
