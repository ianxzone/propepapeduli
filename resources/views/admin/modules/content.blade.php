@extends('layouts.admin')

@section('title', 'Kelola Konten - ' . $module->title)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.modules.index') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline mb-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali
            </a>
            <h1 class="font-headline text-headline-md text-on-surface">Kelola Konten Siklus PEDULI</h1>
            <p class="text-on-surface-variant italic">Modul: {{ $module->title }}</p>
        </div>
        <button type="submit" form="contentForm" class="bg-primary text-white font-bold px-8 py-3 rounded-2xl shadow-soft hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">save</span>
            Simpan Semua Perubahan
        </button>
    </div>

    <form id="contentForm" action="{{ route('admin.modules.content.update', $module->id) }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- P: Pelajari -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
            <div class="flex items-center gap-3 text-primary border-b border-outline-variant/30 pb-4">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center font-bold text-lg">P</div>
                <h3 class="font-headline text-xl font-bold">Fase Pelajari</h3>
            </div>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2">URL Video (YouTube/Vimeo)</label>
                    <input type="url" name="content[P][video_url]" value="{{ $content['P']['video_url'] ?? '' }}" 
                           class="w-full h-12 px-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                           placeholder="https://youtube.com/watch?v=...">
                </div>
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2">Materi Ringkas</label>
                    <textarea name="content[P][text]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                              placeholder="Tuliskan poin-poin penting yang harus dipelajari siswa...">{{ $content['P']['text'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2">Link Materi Tambahan (PDF/Slide/Drive)</label>
                    <input type="url" name="content[P][file_url]" value="{{ $content['P']['file_url'] ?? '' }}" 
                           class="w-full h-12 px-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                           placeholder="https://drive.google.com/file/d/...">
                </div>
            </div>
        </div>

        <!-- E: Eksplorasi -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
            <div class="flex items-center gap-3 text-green-600 border-b border-outline-variant/30 pb-4">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center font-bold text-lg">E</div>
                <h3 class="font-headline text-xl font-bold">Fase Eksplorasi</h3>
            </div>
            <div>
                <label class="block font-label text-sm text-on-surface mb-2">Instruksi Eksplorasi</label>
                <textarea name="content[E][text]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                          placeholder="Instruksikan siswa untuk mencari informasi tambahan...">{{ $content['E']['text'] ?? '' }}</textarea>
            </div>
        </div>

        <!-- D: Diskusi -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
            <div class="flex items-center gap-3 text-purple-600 border-b border-outline-variant/30 pb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center font-bold text-lg">D</div>
                <h3 class="font-headline text-xl font-bold">Fase Diskusi</h3>
            </div>
            <div>
                <label class="block font-label text-sm text-on-surface mb-2">Topik Diskusi Utama</label>
                <input type="text" name="content[D][topic]" value="{{ $content['D']['topic'] ?? '' }}" 
                       class="w-full h-12 px-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                       placeholder="Contoh: Bagaimana pendapatmu tentang sampah plastik di sekolah?">
            </div>
        </div>

        <!-- U & L: Ungkapkan & Lakukan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
                <div class="flex items-center gap-3 text-orange-600 border-b border-outline-variant/30 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center font-bold text-lg">U</div>
                    <h3 class="font-headline text-xl font-bold">Fase Ungkapkan</h3>
                </div>
                <textarea name="content[U][task]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                          placeholder="Tugas jurnal untuk fase Ungkapkan...">{{ $content['U']['task'] ?? '' }}</textarea>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
                <div class="flex items-center gap-3 text-red-600 border-b border-outline-variant/30 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center font-bold text-lg">L</div>
                    <h3 class="font-headline text-xl font-bold">Fase Lakukan</h3>
                </div>
                <textarea name="content[L][task]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                          placeholder="Aksi nyata yang harus dilakukan siswa...">{{ $content['L']['task'] ?? '' }}</textarea>
            </div>
        </div>

        <!-- I: Introspeksi -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
            <div class="flex items-center gap-3 text-teal-600 border-b border-outline-variant/30 pb-4">
                <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center font-bold text-lg">I</div>
                <h3 class="font-headline text-xl font-bold">Fase Introspeksi</h3>
            </div>
            <div>
                <label class="block font-label text-sm text-on-surface mb-2">Pertanyaan Refleksi Akhir</label>
                <textarea name="content[I][questions]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                          placeholder="Tuliskan pertanyaan untuk membantu siswa merenungkan apa yang telah dipelajari...">{{ $content['I']['questions'] ?? '' }}</textarea>
            </div>
        </div>
    </form>
</div>
@endsection
