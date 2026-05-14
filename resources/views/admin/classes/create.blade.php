@extends('layouts.admin')

@section('title', 'Tambah Kelas - ProPePa')
@section('header_title', 'Tambah Kelas Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.classes.index') }}" class="text-primary font-bold inline-flex items-center gap-2 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Daftar Kelas
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low">
            <h2 class="font-headline text-headline-md text-on-surface">Informasi Kelas</h2>
        </div>

        <form action="{{ route('admin.classes.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block font-bold text-sm text-on-surface mb-2">Nama Kelas <span class="text-error">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                       placeholder="Contoh: Kelas 5A">
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="school_id" class="block font-bold text-sm text-on-surface mb-2">Sekolah <span class="text-error">*</span></label>
                <select id="school_id" name="school_id" required
                        class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-outline-variant/30">
                <button type="submit" class="bg-primary text-white font-bold px-8 py-3 rounded-xl hover:bg-primary/90 transition-colors shadow-sm w-full sm:w-auto">
                    Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
