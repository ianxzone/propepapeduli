@extends('layouts.admin')

@section('title', 'Tambah Guru - ProPePa')
@section('header_title', 'Tambah Akun Guru Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.teachers.index') }}" class="text-primary font-bold inline-flex items-center gap-2 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Daftar Guru
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low">
            <h2 class="font-headline text-headline-md text-on-surface">Informasi Akun Guru</h2>
        </div>

        <form action="{{ route('admin.teachers.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block font-bold text-sm text-on-surface mb-2">Nama Lengkap <span class="text-error">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                       placeholder="Contoh: Siti Aminah, S.Pd">
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block font-bold text-sm text-on-surface mb-2">Alamat Email <span class="text-error">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                       placeholder="Contoh: guru@sekolah.com">
                @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block font-bold text-sm text-on-surface mb-2">Kata Sandi <span class="text-error">*</span></label>
                <input type="password" id="password" name="password" required
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                @error('password') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="class_id" class="block font-bold text-sm text-on-surface mb-2">Penempatan Kelas <span class="text-error">*</span></label>
                <select id="class_id" name="class_id" required
                        class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} - {{ $class->school->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-outline-variant/30">
                <button type="submit" class="bg-primary text-white font-bold px-8 py-3 rounded-xl hover:bg-primary/90 transition-colors shadow-sm w-full sm:w-auto">
                    Buat Akun Guru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
