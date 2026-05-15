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
                        Kelas {{ $student->class?->name ?? 'Siswa Mandiri' }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Modul Progress Summary -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-headline text-headline-md text-on-surface">Progres Modul</h3>
                @if($selectedModuleId)
                    <a href="{{ route('teacher.student.detail', $student->id) }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">restart_alt</span>
                        Tampilkan Semua Modul
                    </a>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($modules as $module)
                    @php
                        $progress = $student->progress()->where('module_id', $module->id)->first();
                        $stepMap = ['P' => 1, 'E' => 2, 'D' => 3, 'U' => 4, 'L' => 5, 'I' => 6, 'S' => 7];
                        $currentIndex = $progress ? ($stepMap[$progress->current_step] ?? 0) : 0;
                        if($progress && $progress->is_completed) $currentIndex = 7;
                        $isSelected = $selectedModuleId == $module->id;
                    @endphp
                    <a href="{{ route('teacher.student.detail', ['student' => $student->id, 'module_id' => $module->id]) }}" 
                       class="bg-white rounded-2xl p-5 border {{ $isSelected ? 'border-primary ring-2 ring-primary/10' : 'border-outline-variant/30' }} shadow-sm flex items-center gap-4 transition-all hover:shadow-md hover:scale-[1.02]">
                        <img src="{{ $module->thumbnail }}" alt="{{ $module->title }}" class="w-16 h-16 rounded-xl object-cover shrink-0">
                        <div class="flex-1">
                            <h4 class="font-bold text-on-surface text-sm">{{ $module->title }}</h4>
                            <div class="flex items-center justify-between text-xs mt-2 mb-1">
                                <span class="text-on-surface-variant">{{ $currentIndex }}/7 Tahap</span>
                                <span class="text-primary font-bold">{{ round(($currentIndex/7)*100) }}%</span>
                            </div>
                            <div class="w-full bg-surface h-1.5 rounded-full overflow-hidden">
                                <div class="bg-primary h-full rounded-full" style="width: {{ ($currentIndex/7)*100 }}%"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Journals & Feedback -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-headline text-headline-md text-on-surface">Jurnal & Refleksi Siswa</h3>
                @if($selectedModuleId)
                    @php $selectedModule = $modules->where('id', $selectedModuleId)->first(); @endphp
                    <span class="text-xs bg-primary/10 text-primary px-3 py-1 rounded-full font-bold">Filter: {{ $selectedModule->title }}</span>
                @endif
            </div>
            
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

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $stepConfig = [
                                        'P' => ['icon' => 'menu_book', 'color' => 'bg-amber-500/10 text-amber-600', 'label' => 'Tahap Pelajari (P)'],
                                        'E' => ['icon' => 'explore', 'color' => 'bg-teal-500/10 text-teal-600', 'label' => 'Tahap Eksplorasi (E)'],
                                        'D' => ['icon' => 'forum', 'color' => 'bg-purple-500/10 text-purple-600', 'label' => 'Tahap Diskusi (D)'],
                                        'U' => ['icon' => 'edit_square', 'color' => 'bg-primary/10 text-primary', 'label' => 'Tahap Ungkapkan (U)'],
                                        'L' => ['icon' => 'rocket_launch', 'color' => 'bg-secondary-container/20 text-secondary', 'label' => 'Aksi Nyata (Lakukan - L)'],
                                        'I' => ['icon' => 'psychology', 'color' => 'bg-surface-container-high text-on-surface-variant', 'label' => 'Refleksi (Introspeksi - I)'],
                                        'S' => ['icon' => 'assignment', 'color' => 'bg-blue-500/10 text-blue-600', 'label' => 'Evaluasi (Essay - S)'],
                                    ];
                                    $cfg = $stepConfig[$journal->step] ?? ['icon' => 'info', 'color' => 'bg-gray-100', 'label' => 'Tahap ' . $journal->step];
                                @endphp
                                <div class="w-12 h-12 rounded-full {{ $cfg['color'] }} flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">{{ $cfg['icon'] }}</span>
                                </div>
                                <div>
                                    <h4 class="font-headline font-bold text-on-surface">{{ $cfg['label'] }}</h4>
                                    @if($journal->emotion_emoji)
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-sm text-on-surface-variant">Perasaan:</span>
                                            <span class="text-xl leading-none">{{ $journal->emotion_emoji }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Step specific extras -->
                        @if($journal->step == 'D' && $student->group_id)
                            <div class="mb-4 ml-15">
                                <a href="{{ route('teacher.forum.index', ['group_id' => $student->group_id, 'module_id' => $journal->module_id]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-50 text-purple-700 text-xs font-bold hover:bg-purple-100 transition-colors">
                                    <span class="material-symbols-outlined text-sm">forum</span>
                                    <span>Lihat Peta Argumen Kelompok</span>
                                    <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                </a>
                            </div>
                        @endif

                        <!-- Student's Image Proof -->
                        @if($journal->image)
                            <div class="mb-6 ml-15 rounded-2xl overflow-hidden border border-outline-variant/30 shadow-sm bg-surface-container-lowest p-2">
                                <p class="text-[10px] font-bold text-outline-variant uppercase mb-2 ml-2">Lampiran Dokumentasi</p>
                                <img src="{{ str_starts_with($journal->image, 'http') ? $journal->image : asset($journal->image) }}" 
                                     alt="Dokumentasi" 
                                     class="w-full h-auto object-cover max-h-[500px] rounded-xl cursor-zoom-in"
                                     onclick="window.open(this.src, '_blank')">
                            </div>
                        @endif

                        <!-- Student's Content / Reflection -->
                        @if($journal->content)
                            <div class="ml-15 space-y-4">
                                @if($journal->step === 'S' && str_starts_with($journal->content, '{'))
                                    @php $essays = json_decode($journal->content, true); @endphp
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach([
                                            'emotional' => ['label' => 'Kesadaran Emosional', 'icon' => 'mood', 'color' => 'text-amber-600'],
                                            'perspective' => ['label' => 'Pengambilan Perspektif', 'icon' => 'visibility', 'color' => 'text-blue-600'],
                                            'care' => ['label' => 'Kepedulian Empatik', 'icon' => 'favorite', 'color' => 'text-pink-600'],
                                            'responsibility' => ['label' => 'Tanggung Jawab Empatik', 'icon' => 'task_alt', 'color' => 'text-green-600'],
                                        ] as $key => $dim)
                                            <div class="bg-surface-container-low p-4 rounded-2xl border border-outline-variant/20">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="material-symbols-outlined text-sm {{ $dim['color'] }}">{{ $dim['icon'] }}</span>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">{{ $dim['label'] }}</span>
                                                </div>
                                                <div class="text-xs text-on-surface leading-relaxed whitespace-pre-line">
                                                    {{ $essays[$key] ?? 'Tidak ada jawaban.' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-surface-container-low p-6 rounded-2xl border border-outline-variant/20 relative">
                                        <span class="material-symbols-outlined absolute top-4 left-4 text-outline-variant/20 text-4xl" style="font-variation-settings: 'FILL' 1;">format_quote</span>
                                        <div class="text-on-surface leading-relaxed relative z-10 pl-8 whitespace-pre-line">
                                            {{ $journal->content }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="ml-15 mb-6 text-on-surface-variant italic text-sm">
                                Tidak ada catatan teks untuk fase ini.
                            </div>
                        @endif

                        <!-- Teacher Feedback Form -->
                        <form action="{{ route('teacher.journal.feedback', $journal->id) }}" method="POST" class="space-y-4 pt-4 border-t border-outline-variant/30">
                            @csrf
                            
                            @if($journal->step == 'S')
                            <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mb-4 space-y-6">
                                <h5 class="font-bold text-blue-800 text-sm flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">fact_check</span>
                                    Rubrik Penilaian Empati (Skala 1-4)
                                </h5>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider">Kesadaran Emosional</label>
                                        <select name="score_emotional" class="w-full rounded-xl border border-outline-variant/50 p-3 text-xs bg-white focus:ring-2 focus:ring-blue-200">
                                            <option value="1" {{ $journal->score_emotional == 1 ? 'selected' : '' }}>1 - Perlu Bimbingan</option>
                                            <option value="2" {{ $journal->score_emotional == 2 ? 'selected' : '' }}>2 - Cukup</option>
                                            <option value="3" {{ $journal->score_emotional == 3 ? 'selected' : '' }}>3 - Baik</option>
                                            <option value="4" {{ $journal->score_emotional == 4 ? 'selected' : '' }}>4 - Sangat Baik</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider">Pengambilan Perspektif</label>
                                        <select name="score_perspective" class="w-full rounded-xl border border-outline-variant/50 p-3 text-xs bg-white focus:ring-2 focus:ring-blue-200">
                                            <option value="1" {{ $journal->score_perspective == 1 ? 'selected' : '' }}>1 - Perlu Bimbingan</option>
                                            <option value="2" {{ $journal->score_perspective == 2 ? 'selected' : '' }}>2 - Cukup</option>
                                            <option value="3" {{ $journal->score_perspective == 3 ? 'selected' : '' }}>3 - Baik</option>
                                            <option value="4" {{ $journal->score_perspective == 4 ? 'selected' : '' }}>4 - Sangat Baik</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider">Kepedulian Aktif</label>
                                        <select name="score_care" class="w-full rounded-xl border border-outline-variant/50 p-3 text-xs bg-white focus:ring-2 focus:ring-blue-200">
                                            <option value="1" {{ $journal->score_care == 1 ? 'selected' : '' }}>1 - Perlu Bimbingan</option>
                                            <option value="2" {{ $journal->score_care == 2 ? 'selected' : '' }}>2 - Cukup</option>
                                            <option value="3" {{ $journal->score_care == 3 ? 'selected' : '' }}>3 - Baik</option>
                                            <option value="4" {{ $journal->score_care == 4 ? 'selected' : '' }}>4 - Sangat Baik</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tanggung Jawab Sosial</label>
                                        <select name="score_responsibility" class="w-full rounded-xl border border-outline-variant/50 p-3 text-xs bg-white focus:ring-2 focus:ring-blue-200">
                                            <option value="1" {{ $journal->score_responsibility == 1 ? 'selected' : '' }}>1 - Perlu Bimbingan</option>
                                            <option value="2" {{ $journal->score_responsibility == 2 ? 'selected' : '' }}>2 - Cukup</option>
                                            <option value="3" {{ $journal->score_responsibility == 3 ? 'selected' : '' }}>3 - Baik</option>
                                            <option value="4" {{ $journal->score_responsibility == 4 ? 'selected' : '' }}>4 - Sangat Baik</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div>
                                <label class="block font-bold text-sm text-on-surface mb-2">Umpan Balik Guru</label>
                                <textarea name="teacher_feedback" rows="3" 
                                          class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 text-sm p-3 bg-white"
                                          placeholder="Tulis pujian atau saran untuk siswa...">{{ $journal->teacher_feedback }}</textarea>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4 justify-between">
                                <div class="flex items-center gap-3">
                                    <label class="font-bold text-sm text-on-surface">Nilai Fase (0-100):</label>
                                    <input type="number" name="teacher_points" min="0" max="100" value="{{ $journal->teacher_points }}" 
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
