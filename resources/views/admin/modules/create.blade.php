@extends('layouts.admin')

@section('title', 'Buat Modul Baru - ProPePa')
@section('header_title', 'Buat Modul Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.modules.index') }}" class="text-primary font-bold inline-flex items-center gap-2 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Daftar Modul
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low">
            <h2 class="font-headline text-headline-md text-on-surface">Informasi Modul</h2>
            <p class="text-sm text-on-surface-variant mt-1">Lengkapi data di bawah untuk membuat modul siklus PEDULI yang baru.</p>
        </div>

        <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            
            <!-- Judul Modul -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block font-bold text-sm text-on-surface mb-2">Judul Modul <span class="text-error">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                           placeholder="Contoh: Ayo Jaga Kebersihan Sungai">
                    @error('title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="slug" class="block font-bold text-sm text-on-surface mb-2">Slug URL (Otomatis)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-low"
                           placeholder="ayo-jaga-kebersihan-sungai">
                    @error('slug') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block font-bold text-sm text-on-surface mb-2">Deskripsi Singkat <span class="text-error">*</span></label>
                <textarea id="description" name="description" rows="4"
                          class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">{{ old('description') }}</textarea>
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
            </div>

            <!-- Badge Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="badge_name" class="block font-bold text-sm text-on-surface mb-2">Nama Lencana</label>
                    <input type="text" id="badge_name" name="badge_name" value="{{ old('badge_name') }}"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                           placeholder="Contoh: Pahlawan Sungai">
                </div>
                <div>
                    <label for="badge_icon" class="block font-bold text-sm text-on-surface mb-2">Ikon Lencana (Material Icon Name)</label>
                    <input type="text" id="badge_icon" name="badge_icon" value="{{ old('badge_icon') }}"
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest"
                           placeholder="Contoh: workspace_premium">
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="flex items-center gap-3 pt-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" checked
                       class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary/20">
                <label for="is_active" class="font-bold text-sm text-on-surface cursor-pointer">
                    Aktifkan modul ini sekarang
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-outline-variant/30">
                <button type="submit" class="bg-primary text-white font-bold px-8 py-3 rounded-xl hover:bg-primary/90 transition-colors shadow-sm w-full sm:w-auto">
                    Simpan & Buat Modul
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('keyup', function() {
        const title = titleInput.value;
        const slug = title.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        slugInput.value = slug;
    });
</script>
@endpush
