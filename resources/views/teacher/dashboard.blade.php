@extends('layouts.teacher')

@section('title', 'Dashboard Guru - ProPePa')

@section('content')
<div class="min-h-screen bg-surface-container-low pb-8">
    <main class="pt-2 space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="font-headline text-headline-md text-on-surface">Beranda Guru</h1>
                    @if(in_array(Auth::user()->role, ['admin', 'dosen']))
                        <form action="{{ route('teacher.dashboard') }}" method="GET" id="class-selector-form">
                            <select name="class_id" onchange="this.form.submit()" class="bg-surface-container-low border-none rounded-full px-4 py-1 text-xs font-bold text-primary focus:ring-2 focus:ring-primary">
                                <option value="">Pilih Kelas...</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}" {{ ($class?->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    @endif
                </div>
                <p class="text-on-surface-variant text-sm italic">Halo, {{ Auth::user()->name }}! Pantau progres belajar siswa Anda di sini.</p>
            </div>
            <div class="flex flex-wrap gap-2 self-start">
                <a href="{{ route('teacher.reports.index') }}" class="flex items-center gap-2 bg-white text-primary border border-primary/20 px-5 py-2.5 rounded-2xl font-bold shadow-sm hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined">assessment</span>
                    <span>Laporan Siswa</span>
                </a>
                <a href="{{ route('teacher.export.assessments', ['class_id' => $class->id]) }}" class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-2xl font-bold shadow-sm hover:bg-blue-700 transition-all">
                    <span class="material-symbols-outlined">fact_check</span>
                    <span>Export Penilaian Empati</span>
                </a>
            </div>
        </div>
        
        <!-- Welcome & Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1 bg-primary text-white rounded-3xl p-6 shadow-soft relative overflow-hidden">
                <div class="absolute top-[-20%] right-[-10%] w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <h2 class="font-headline text-headline-md mb-2">Kelas Anda</h2>
                <p class="text-primary-fixed-dim">{{ $class->name }} &bull; {{ $class->school->name }}</p>
                <div class="mt-6">
                    <p class="text-sm text-primary-fixed">Total Siswa</p>
                    <p class="font-headline text-4xl font-bold">{{ $totalStudents }} <span class="text-base font-normal opacity-80">Siswa</span></p>
                </div>
            </div>

            <div class="md:col-span-2 grid grid-cols-2 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-outline-variant/30 flex flex-col justify-between">
                    <div class="w-12 h-12 bg-secondary-container text-on-secondary-container rounded-2xl flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">stars</span>
                    </div>
                    <div>
                        <p class="text-sm text-on-surface-variant mb-1">Rata-rata Poin Kelas</p>
                        <p class="font-headline text-3xl font-bold text-on-surface">{{ $averagePoints }} <span class="text-sm font-normal text-on-surface-variant">Pts/Siswa</span></p>
                    </div>
                </div>
                <!-- Stat Card 2 -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-outline-variant/30 flex flex-col justify-between">
                    <div class="w-12 h-12 bg-surface-variant text-primary rounded-2xl flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">library_books</span>
                    </div>
                    <div>
                        <p class="text-sm text-on-surface-variant mb-1">Modul Aktif</p>
                        <p class="font-headline text-3xl font-bold text-on-surface">{{ $modules->count() }} <span class="text-sm font-normal text-on-surface-variant">Modul</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Progress Chart -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-outline-variant/30">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-headline text-lg text-on-surface">Statistik Tahapan</h3>
                        <p class="text-xs text-on-surface-variant">Jumlah siswa yang telah menyelesaikan setiap fase.</p>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="phaseChart"></canvas>
                </div>
            </div>

            <!-- Quick Info / Tips -->
            <div class="bg-primary/5 rounded-[2rem] p-8 border border-primary/10 relative overflow-hidden flex flex-col justify-center">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-primary text-4xl mb-4">lightbulb</span>
                    <h3 class="font-headline text-xl text-on-surface mb-2">Tips Mengajar</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed mb-6">
                        "Berikan umpan balik yang membangun pada fase **Ungkapkan** untuk meningkatkan motivasi siswa. Siswa yang mendapat apresiasi cenderung lebih aktif di fase berikutnya."
                    </p>
                    <a href="{{ route('teacher.journals.index') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline">
                        Beri Umpan Balik Sekarang
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
                <div class="absolute bottom-[-20%] right-[-10%] opacity-5 pointer-events-none">
                    <span class="material-symbols-outlined text-[200px]">school</span>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center">
                <h3 class="font-headline text-headline-md text-on-surface">Daftar Siswa</h3>
                <div class="relative hidden sm:block">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant material-symbols-outlined text-sm">search</span>
                    <input type="text" placeholder="Cari siswa..." class="pl-9 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-full text-sm focus:border-primary focus:ring-0">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant text-sm border-b border-outline-variant/30">
                            <th class="p-4 font-bold">Nama Siswa</th>
                            <th class="p-4 font-bold text-center">Poin</th>
                            <th class="p-4 font-bold text-center">Modul Selesai</th>
                            <th class="p-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @foreach($students as $student)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container text-white flex items-center justify-center text-xs font-bold">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-on-surface">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center gap-1 bg-secondary-container/20 text-secondary px-2 py-1 rounded-full text-xs font-bold">
                                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                                    {{ $student->points }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @php
                                    $completedModules = $student->progress()->where('is_completed', true)->count();
                                @endphp
                                <span class="text-on-surface-variant text-sm">{{ $completedModules }} / {{ $modules->count() }}</span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('teacher.student.detail', $student->id) }}" class="text-primary hover:bg-primary/10 p-2 rounded-lg transition-colors inline-flex items-center gap-1 text-sm font-bold">
                                    <span>Detail</span>
                                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('phaseChart').getContext('2d');
    
    // Gradient for bars
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, '#6750a4');
    gradient.addColorStop(1, 'rgba(103, 80, 164, 0.2)');

    const phaseLabels = ['Pelajari (P)', 'Eksplorasi (E)', 'Diskusi (D)', 'Ungkapkan (U)', 'Lakukan (L)', 'Introspeksi (I)', 'Evaluasi (S)'];
    const phaseData = [
        {{ $phaseStats['P'] }}, 
        {{ $phaseStats['E'] }}, 
        {{ $phaseStats['D'] }}, 
        {{ $phaseStats['U'] }}, 
        {{ $phaseStats['L'] }}, 
        {{ $phaseStats['I'] }},
        {{ $phaseStats['S'] }}
    ];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: phaseLabels,
            datasets: [{
                label: 'Jumlah Siswa',
                data: phaseData,
                backgroundColor: gradient,
                borderRadius: 12,
                borderSkipped: false,
                barThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1d1b20',
                    titleFont: { family: 'Outfit', size: 12 },
                    bodyFont: { family: 'Outfit', size: 12 },
                    padding: 12,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: {{ $totalStudents > 0 ? $totalStudents : 1 }},
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Outfit', size: 10 }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false }
                },
                x: {
                    ticks: {
                        font: { family: 'Outfit', size: 10, weight: 'bold' }
                    },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush
