@extends('layouts.admin')

@section('title', 'Dasbor Admin - ProPePa')
@section('header_title', 'Dasbor Administrator')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Cards -->
        <div class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">school</span>
            </div>
            <div>
                <p class="text-sm font-bold text-on-surface-variant">Sekolah & Kelas</p>
                <p class="font-headline text-2xl font-bold text-on-surface">{{ $stats['schools'] }} <span class="text-sm font-normal">/ {{ $stats['classes'] }}</span></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-secondary-container/30 text-secondary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">group</span>
            </div>
            <div>
                <p class="text-sm font-bold text-on-surface-variant">Guru</p>
                <p class="font-headline text-2xl font-bold text-on-surface">{{ $stats['teachers'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#004628]/10 text-[#004628] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">face</span>
            </div>
            <div>
                <p class="text-sm font-bold text-on-surface-variant">Siswa Aktif</p>
                <p class="font-headline text-2xl font-bold text-on-surface">{{ $stats['students'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#002d6d]/10 text-[#002d6d] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">library_books</span>
            </div>
            <div>
                <p class="text-sm font-bold text-on-surface-variant">Modul</p>
                <p class="font-headline text-2xl font-bold text-on-surface">{{ $stats['modules'] }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-8 rounded-[2rem] border border-outline-variant/30 shadow-sm">
        <h2 class="font-headline text-headline-md text-on-surface mb-6">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.modules.create') }}" class="flex flex-col items-center justify-center gap-2 p-6 rounded-2xl border-2 border-dashed border-primary/30 hover:border-primary hover:bg-primary/5 transition-all text-primary group">
                <span class="material-symbols-outlined text-3xl group-hover:scale-110 transition-transform">add_circle</span>
                <span class="font-bold">Buat Modul Baru</span>
            </a>
            <a href="{{ route('admin.teachers.create') }}" class="flex flex-col items-center justify-center gap-2 p-6 rounded-2xl bg-surface-container-low hover:bg-surface-container transition-all text-on-surface">
                <span class="material-symbols-outlined text-3xl text-secondary">person_add</span>
                <span class="font-bold">Tambah Akun Guru</span>
            </a>
            <a href="{{ route('admin.schools.create') }}" class="flex flex-col items-center justify-center gap-2 p-6 rounded-2xl bg-surface-container-low hover:bg-surface-container transition-all text-on-surface">
                <span class="material-symbols-outlined text-3xl text-outline">domain_add</span>
                <span class="font-bold">Daftarkan Sekolah</span>
            </a>
        </div>
    </div>

    <!-- Leaderboard & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Global Leaderboard -->
        <div class="bg-white p-8 rounded-[2rem] border border-outline-variant/30 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-headline text-headline-md text-on-surface">Peringkat Global</h2>
                <a href="{{ route('admin.students.index') }}" class="text-primary text-sm font-bold hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @foreach($leaderboard as $student)
                <div class="flex items-center justify-between p-4 bg-surface-container-lowest rounded-2xl border border-outline-variant/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center font-bold">
                            {{ $loop->iteration }}
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">{{ $student->name }}</p>
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest">
                                {{ $student->class?->name ?? 'Siswa Mandiri' }}
                                @if($student->class?->school)
                                    &bull; {{ $student->class->school->name }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-primary">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">stars</span>
                        <span class="font-bold">{{ number_format($student->points) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Latest Journal Activity -->
        <div class="bg-white p-8 rounded-[2rem] border border-outline-variant/30 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-headline text-headline-md text-on-surface">Jurnal Terbaru</h2>
                <span class="bg-secondary-container/30 text-secondary px-3 py-1 rounded-full text-xs font-bold">Aktivitas Live</span>
            </div>
            <div class="space-y-6">
                @forelse($latestJournals as $journal)
                <div class="flex gap-4 relative">
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">history</span>
                        </div>
                        @if(!$loop->last)
                        <div class="w-0.5 h-full bg-outline-variant/30 my-1"></div>
                        @endif
                    </div>
                    <div class="flex-1 pb-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold text-on-surface">{{ $journal->user->name }}</p>
                            <span class="text-[10px] text-on-surface-variant italic">{{ $journal->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            Menyelesaikan Fase 
                            <strong class="text-primary">
                                @php
                                    $stepNames = ['P' => 'Pelajari', 'E' => 'Eksplorasi', 'D' => 'Diskusi', 'U' => 'Ungkapkan', 'L' => 'Lakukan', 'I' => 'Introspeksi'];
                                    echo $stepNames[$journal->step] ?? $journal->step;
                                @endphp
                            </strong> 
                            pada modul <strong>{{ $journal->module->title }}</strong>
                            @if($journal->image)
                                <span class="ml-1 inline-flex items-center gap-0.5 text-secondary font-bold">
                                    <span class="material-symbols-outlined text-[14px]">image</span>
                                    +Foto
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-center py-10 text-on-surface-variant italic">Belum ada aktivitas jurnal.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
