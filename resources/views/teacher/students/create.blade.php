@extends('layouts.teacher')

@section('title', 'Tambah Siswa Baru - ProPePa')
@section('header_title', 'Manajemen Siswa')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.students.index', ['class_id' => $class?->id]) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-headline text-headline-md text-on-surface">Tambah Siswa Baru</h1>
            <p class="text-on-surface-variant italic">Tambahkan siswa baru secara individu ke dalam kelas.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="p-4 bg-error-container text-on-error-container rounded-2xl border border-error/10 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm">
        <form action="{{ route('teacher.students.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Class Field -->
            @if(in_array(Auth::user()->role, ['admin', 'dosen']))
                <div>
                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2 ml-1">Pilih Kelas</label>
                    <select name="class_id" required class="w-full h-12 px-4 bg-surface-container-lowest border-2 border-outline-variant/30 rounded-xl focus:border-primary focus:ring-0 transition-all text-sm">
                        <option value="">Pilih Kelas...</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ ($class?->id == $c->id) ? 'selected' : '' }}>
                                {{ $c->name }} ({{ $c->school->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="text-xs text-error mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>
            @else
                <input type="hidden" name="class_id" value="{{ $teacher->class_id }}">
                <div>
                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2 ml-1">Kelas & Sekolah</label>
                    <input type="text" readonly value="{{ $teacher->class->name }} - {{ $teacher->class->school->name }}" 
                           class="w-full h-12 px-4 bg-surface-container border-2 border-outline-variant/10 rounded-xl text-on-surface-variant text-sm font-medium cursor-not-allowed">
                </div>
            @endif

            <!-- Student Name -->
            <div>
                <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2 ml-1">Nama Lengkap Siswa</label>
                <input type="text" name="name" required placeholder="Masukkan nama lengkap siswa..." value="{{ old('name') }}"
                       class="w-full h-12 px-4 bg-surface-container-lowest border-2 border-outline-variant/30 rounded-xl focus:border-primary focus:ring-0 transition-all text-sm">
                @error('name')
                    <p class="text-xs text-error mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-primary/5 p-4 rounded-2xl border border-primary/10 flex gap-3">
                <span class="material-symbols-outlined text-primary text-sm shrink-0">info</span>
                <p class="text-[10px] text-on-surface-variant italic leading-relaxed">
                    Siswa yang baru didaftarkan akan secara otomatis mendapatkan password default <strong>123456</strong> untuk mengakses platform LMS ProPePa.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-2">
                <a href="{{ route('teacher.students.index', ['class_id' => $class?->id]) }}" 
                   class="flex-1 h-12 rounded-xl border border-outline-variant flex items-center justify-center font-bold text-on-surface-variant hover:bg-surface-container transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 h-12 rounded-xl bg-primary text-white font-bold shadow-md hover:bg-primary/95 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Siswa</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
