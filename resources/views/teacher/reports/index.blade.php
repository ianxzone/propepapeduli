@extends('layouts.teacher')

@section('title', 'Laporan & Export - ProPePa')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="font-headline text-headline-md text-on-surface">Laporan & Export</h2>
                @if(in_array(Auth::user()->role, ['admin', 'dosen']))
                    <form action="{{ route('teacher.reports.index') }}" method="GET" id="class-selector-form-reports">
                        <select name="class_id" onchange="this.form.submit()" class="bg-surface-container-low border-none rounded-full px-4 py-1 text-xs font-bold text-primary focus:ring-2 focus:ring-primary">
                            <option value="">Pilih Kelas...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ ($class?->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
            <p class="text-on-surface-variant text-sm">Unduh data progres dan penilaian siswa di kelas {{ $class?->name ?? '---' }}.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Student Progress Report -->
        <div class="bg-white rounded-[2rem] p-8 border border-outline-variant/30 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-3xl">groups</span>
                </div>
                <h3 class="font-headline text-xl text-on-surface mb-2">Laporan Progres Siswa</h3>
                <p class="text-sm text-on-surface-variant leading-relaxed mb-8">
                    Berisi data identitas siswa, total poin yang dikumpulkan, jumlah modul yang telah diselesaikan, dan waktu terakhir aktif di platform.
                </p>
            </div>
            <a href="{{ route('teacher.export', ['class_id' => request('class_id')]) }}" class="flex items-center justify-center gap-2 bg-primary text-white py-4 rounded-2xl font-bold shadow-soft hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined">download</span>
                <span>Unduh CSV Progres</span>
            </a>
        </div>

        <!-- Empathy Assessment Report -->
        <div class="bg-white rounded-[2rem] p-8 border border-outline-variant/30 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-blue-500/10 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-3xl">fact_check</span>
                </div>
                <h3 class="font-headline text-xl text-on-surface mb-2">Laporan Penilaian Empati</h3>
                <p class="text-sm text-on-surface-variant leading-relaxed mb-8">
                    Berisi detail jawaban essay siswa pada setiap modul beserta skor rubrik untuk 4 dimensi empati dan umpan balik yang diberikan guru.
                </p>
            </div>
            <a href="{{ route('teacher.export.assessments', ['class_id' => request('class_id')]) }}" class="flex items-center justify-center gap-2 bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-soft hover:bg-blue-700 transition-all">
                <span class="material-symbols-outlined">analytics</span>
                <span>Unduh CSV Penilaian</span>
            </a>
        </div>
    </div>

    <!-- Tip Section -->
    <div class="bg-surface-container-low p-6 rounded-3xl border border-outline-variant/20 flex gap-4 items-start mb-8">
        <span class="material-symbols-outlined text-primary">info</span>
        <div class="text-xs text-on-surface-variant space-y-1">
            <p class="font-bold text-on-surface">Data Real-time</p>
            <p>Tabel di bawah menampilkan hasil input essay dan penilaian rubrik yang telah dilakukan. Anda dapat mengunduh versi lengkapnya melalui tombol di atas.</p>
        </div>
    </div>

    <!-- Rekap Penilaian Table -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30">
            <h3 class="font-headline text-lg text-on-surface">Rekap Hasil Evaluasi Siswa</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-[10px] uppercase tracking-wider border-b border-outline-variant/30">
                        <th class="p-4 font-bold">Siswa</th>
                        <th class="p-4 font-bold">Modul</th>
                        <th class="p-4 font-bold">Jawaban Essay</th>
                        <th class="p-4 font-bold text-center">Ems</th>
                        <th class="p-4 font-bold text-center">Prs</th>
                        <th class="p-4 font-bold text-center">Kpl</th>
                        <th class="p-4 font-bold text-center">Tj</th>
                        <th class="p-4 font-bold text-center">Total</th>
                        <th class="p-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($assessments as $assessment)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-[10px] font-bold">
                                    {{ substr($assessment->user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-xs">{{ $assessment->user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-[10px] font-bold text-on-surface leading-tight">{{ $assessment->module->title }}</div>
                        </td>
                        <td class="p-4">
                            @if($assessment->step === 'S' && str_starts_with($assessment->content, '{'))
                                @php $essays = json_decode($assessment->content, true); @endphp
                                <p class="text-[9px] text-on-surface-variant leading-tight line-clamp-2 max-w-[200px]">
                                    <span class="font-bold text-amber-600">Ems:</span> {{ Str::limit($essays['emotional'] ?? '-', 30) }},
                                    <span class="font-bold text-blue-600">Prs:</span> {{ Str::limit($essays['perspective'] ?? '-', 30) }}
                                </p>
                            @else
                                <p class="text-[10px] text-on-surface-variant italic line-clamp-2 max-w-[200px]">"{{ $assessment->content }}"</p>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <span class="w-6 h-6 inline-flex items-center justify-center rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">
                                {{ $assessment->score_emotional ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="w-6 h-6 inline-flex items-center justify-center rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">
                                {{ $assessment->score_perspective ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="w-6 h-6 inline-flex items-center justify-center rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">
                                {{ $assessment->score_care ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="w-6 h-6 inline-flex items-center justify-center rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">
                                {{ $assessment->score_responsibility ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-0.5 rounded-full bg-secondary-container/20 text-secondary text-[10px] font-bold">
                                {{ $assessment->teacher_points }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('teacher.student.detail', ['student' => $assessment->user->id, 'module_id' => $assessment->module_id]) }}#journal-{{ $assessment->id }}" class="text-primary hover:bg-primary/10 p-2 rounded-lg transition-colors text-[10px] font-bold whitespace-nowrap">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-12 text-center text-on-surface-variant italic text-xs">Belum ada evaluasi essay yang dikerjakan siswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
