@extends('layouts.admin')

@section('title', 'Edit Sekolah - ProPePa')
@section('header_title', 'Edit Sekolah: ' . $school->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.schools.index') }}" class="text-primary font-bold inline-flex items-center gap-2 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Daftar Sekolah
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low">
            <h2 class="font-headline text-headline-md text-on-surface">Informasi Sekolah</h2>
        </div>

        <form action="{{ route('admin.schools.update', $school->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block font-bold text-sm text-on-surface mb-2">Nama Sekolah <span class="text-error">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $school->name) }}" required
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="address" class="block font-bold text-sm text-on-surface mb-2">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3"
                          class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">{{ old('address', $school->address) }}</textarea>
                @error('address') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contact_person" class="block font-bold text-sm text-on-surface mb-2">Nama Kontak / Kepsek</label>
                <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person', $school->contact_person) }}"
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                @error('contact_person') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-outline-variant/30">
                <button type="submit" class="bg-primary text-white font-bold px-8 py-3 rounded-xl hover:bg-primary/90 transition-colors shadow-sm w-full sm:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
