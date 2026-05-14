@extends('layouts.admin')

@section('title', 'Edit Siswa - ProPePa PEDULI')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline mb-4">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Kembali ke Daftar</span>
        </a>
        <h1 class="font-headline text-headline-md text-on-surface">Edit Data Siswa</h1>
        <p class="text-on-surface-variant italic">Perbarui informasi diri atau penempatan kelas siswa.</p>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block font-label text-sm text-on-surface mb-2 ml-1">Nama Lengkap Siswa</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required
                           class="w-full h-14 px-4 bg-surface-container-lowest border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md">
                    @error('name') <p class="text-error text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="class_id" class="block font-label text-sm text-on-surface mb-2 ml-1">Pindah Kelas</label>
                    <div class="relative">
                        <select id="class_id" name="class_id" required
                                class="w-full h-14 px-4 bg-surface-container-lowest border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md appearance-none">
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} — {{ $class->school->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant material-symbols-outlined pointer-events-none">expand_more</span>
                    </div>
                    @error('class_id') <p class="text-error text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="points" class="block font-label text-sm text-on-surface mb-2 ml-1">Total Poin</label>
                    <input type="number" id="points" name="points" value="{{ old('points', $student->points) }}" min="0" required
                           class="w-full h-14 px-4 bg-surface-container-lowest border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md">
                    @error('points') <p class="text-error text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit" class="w-full h-14 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-2 shadow-soft hover:bg-primary/90 transition-all group">
                Simpan Perubahan
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">save</span>
            </button>
        </form>
    </div>
</div>
@endsection
