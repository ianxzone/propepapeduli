@extends('layouts.admin')

@section('title', 'Edit Modul - ProPePa')
@section('header_title', 'Edit Modul: ' . $module->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.modules.index') }}" class="text-primary font-bold inline-flex items-center gap-2 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Daftar Modul
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex justify-between items-center">
            <div>
                <h2 class="font-headline text-headline-md text-on-surface">Informasi Modul</h2>
                <p class="text-sm text-on-surface-variant mt-1">Perbarui data modul pembelajaran.</p>
            </div>
            <div class="flex items-center gap-3">
                @if($module->is_active)
                    <span class="bg-[#d4edda] text-[#155724] px-3 py-1 rounded-full text-xs font-bold shadow-sm">Aktif</span>
                @else
                    <span class="bg-surface-container-high text-on-surface-variant px-3 py-1 rounded-full text-xs font-bold shadow-sm">Draft</span>
                @endif
            </div>
        </div>

        <!-- NEW: Manage Content Shortcut -->
        <div class="bg-primary/5 p-6 border-b border-outline-variant/30 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-3xl">auto_stories</span>
                </div>
                <div>
                    <h3 class="font-bold text-on-surface">Materi Pembelajaran (PEDULI)</h3>
                    <p class="text-xs text-on-surface-variant">Kelola video, topik diskusi, dan tugas jurnal untuk setiap fase.</p>
                </div>
            </div>
            <a href="{{ route('admin.modules.content', $module->id) }}" 
               class="bg-primary text-white font-bold px-6 py-2.5 rounded-xl hover:bg-primary/90 transition-all shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">edit_note</span>
                Kelola Isi Materi
            </a>
        </div>

        <form action="{{ route('admin.modules.update', $module->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Judul Modul -->
            <div>
                <label for="title" class="block font-bold text-sm text-on-surface mb-2">Judul Modul <span class="text-error">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $module->title) }}" required
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                       placeholder="Contoh: Ayo Jaga Kebersihan Sungai">
                @error('title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block font-bold text-sm text-on-surface mb-2">Deskripsi Singkat <span class="text-error">*</span></label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">{{ old('description', $module->description) }}</textarea>
                @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Thumbnail -->
            <div class="space-y-4">
                <div>
                    <label for="thumbnail_file" class="block font-bold text-sm text-on-surface mb-2">Upload Gambar Thumbnail</label>
                    <input type="file" id="thumbnail_file" name="thumbnail_file"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p class="text-[10px] text-on-surface-variant mt-1 italic">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="h-px bg-outline-variant/30 flex-1"></div>
                    <span class="text-[10px] font-bold text-outline uppercase">Atau Gunakan URL</span>
                    <div class="h-px bg-outline-variant/30 flex-1"></div>
                </div>

                <div>
                    <input type="url" id="thumbnail_url" name="thumbnail_url" value="{{ old('thumbnail_url') }}"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                           placeholder="https://example.com/image.jpg">
                    @error('thumbnail_url') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                @if($module->thumbnail)
                <div class="mt-4 p-4 bg-surface-container-low rounded-2xl border border-outline-variant/20 flex items-start gap-4">
                    <img src="{{ $module->thumbnail }}" alt="Thumbnail" class="h-20 w-32 rounded-lg object-cover border border-outline-variant/30">
                    <div>
                        <p class="text-[10px] text-outline font-bold uppercase mb-1">Pratinjau Saat Ini</p>
                        <p class="text-xs text-on-surface-variant truncate max-w-[200px]">{{ $module->thumbnail }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Badge Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="badge_name" class="block font-bold text-sm text-on-surface mb-2">Nama Lencana</label>
                    <input type="text" id="badge_name" name="badge_name" value="{{ old('badge_name', $module->badge_name) }}"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                </div>
                <div>
                    <label for="badge_icon" class="block font-bold text-sm text-on-surface mb-2">Ikon Lencana</label>
                    <input type="text" id="badge_icon" name="badge_icon" value="{{ old('badge_icon', $module->badge_icon) }}"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="flex items-center gap-3 pt-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ $module->is_active ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary/20">
                <label for="is_active" class="font-bold text-sm text-on-surface cursor-pointer">
                    Aktifkan modul ini
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-outline-variant/30 flex items-center justify-between">
                <button type="submit" class="bg-primary text-white font-bold px-8 py-3 rounded-xl hover:bg-primary/90 transition-colors shadow-sm w-full sm:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
