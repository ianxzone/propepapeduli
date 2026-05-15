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
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="block font-label text-sm text-on-surface mb-2 font-bold">Instruksi Guru (Opsional)</label>
                    <textarea name="content[P][teacher_instruction]" id="teacher_instruction_p" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl">{{ $content['P']['teacher_instruction'] ?? '' }}</textarea>
                    <p class="text-[10px] text-on-surface-variant italic">*Berikan instruksi atau pengantar untuk fase ini.</p>
                </div>
                <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2">URL Video (YouTube/Vimeo)</label>
                    <div class="flex gap-2">
                        <input type="url" name="content[P][video_url]" value="{{ $content['P']['video_url'] ?? '' }}" id="input_video_url"
                               class="flex-1 h-12 px-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                               placeholder="https://youtube.com/watch?v=...">
                        <button type="button" onclick="openMediaPicker('input_video_url', 'video')" class="h-12 px-4 bg-secondary-container/10 text-secondary font-bold rounded-xl border border-secondary/20 hover:bg-secondary hover:text-white transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">movie</span>
                            Media
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2">Cerita Bergambar (Daftar URL Gambar)</label>
                    <div class="space-y-2">
                        <textarea name="content[P][story_images]" rows="3" id="input_story_images" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-xs"
                                  placeholder="Masukkan URL gambar, satu per baris...">{{ $content['P']['story_images'] ?? '' }}</textarea>
                        <button type="button" onclick="openMediaPicker('input_story_images', 'image', true)" class="w-full h-10 bg-secondary-container/10 text-secondary font-bold rounded-xl border border-secondary/20 hover:bg-secondary hover:text-white transition-all flex items-center justify-center gap-2 text-xs">
                            <span class="material-symbols-outlined text-sm">add_photo_alternate</span>
                            Tambah Gambar dari Media
                        </button>
                    </div>
                    <p class="text-[10px] text-on-surface-variant mt-1 italic">*Gunakan URL gambar publik. Akan ditampilkan sebagai slider.</p>
                </div>
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2">Data Faktual & Materi Ringkas</label>
                    <textarea name="content[P][text]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                              placeholder="Tuliskan data faktual atau poin-poin penting materi...">{{ $content['P']['text'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2">Link Dokumen Materi (PDF/Slide/Drive)</label>
                    <div class="flex gap-2">
                        <input type="url" name="content[P][file_url]" value="{{ $content['P']['file_url'] ?? '' }}" id="input_file_url"
                               class="flex-1 h-12 px-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                               placeholder="https://drive.google.com/file/d/...">
                        <button type="button" onclick="openMediaPicker('input_file_url', 'document')" class="h-12 px-4 bg-secondary-container/10 text-secondary font-bold rounded-xl border border-secondary/20 hover:bg-secondary hover:text-white transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">attachment</span>
                            Media
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- E: Eksplorasi -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-outline-variant/30 pb-4">
                <div class="flex items-center gap-3 text-green-600">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center font-bold text-lg">E</div>
                    <h3 class="font-headline text-xl font-bold">Fase Eksplorasi</h3>
                </div>
                <button type="button" onclick="addPerspective()" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-green-700 transition-all shadow-md">
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                    Tambah Perspektif
                </button>
            </div>
            
            <div id="perspective_container" class="space-y-6">
                @php
                    $perspectives = $content['E']['perspectives'] ?? [['name' => '', 'image' => '', 'text' => '']];
                @endphp
                @foreach($perspectives as $index => $p)
                <div class="perspective-item bg-surface-container-low p-6 rounded-[2rem] border border-outline-variant/30 relative group" data-index="{{ $index }}">
                    <button type="button" onclick="this.closest('.perspective-item').remove()" class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block font-label text-xs text-on-surface-variant mb-2 font-bold uppercase tracking-wider">Nama Tokoh / Perspektif</label>
                                <input type="text" name="content[E][perspectives][{{ $index }}][name]" value="{{ $p['name'] ?? '' }}" 
                                       class="w-full h-12 px-4 bg-white border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                       placeholder="Contoh: Aktivis Lingkungan">
                            </div>
                            <div>
                                <label class="block font-label text-xs text-on-surface-variant mb-2 font-bold uppercase tracking-wider">Gambar Tokoh</label>
                                <div class="flex gap-2">
                                    <input type="url" name="content[E][perspectives][{{ $index }}][image]" value="{{ $p['image'] ?? '' }}" id="input_e_image_{{ $index }}"
                                           class="flex-1 h-12 px-4 bg-white border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                           placeholder="URL Gambar">
                                    <button type="button" onclick="openMediaPicker('input_e_image_{{ $index }}', 'image')" class="h-12 px-4 bg-secondary-container/10 text-secondary font-bold rounded-xl border border-secondary/20 hover:bg-secondary hover:text-white transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">image</span>
                                        Media
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block font-label text-xs text-on-surface-variant mb-2 font-bold uppercase tracking-wider">Kutipan Pendapat</label>
                            <textarea name="content[E][perspectives][{{ $index }}][text]" rows="5" class="w-full p-4 bg-white border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                      placeholder="Apa pendapat tokoh ini tentang isunya?">{{ $p['text'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @push('scripts')
        <script>
            let perspectiveCount = {{ count($perspectives) }};
            function addPerspective() {
                const container = document.getElementById('perspective_container');
                const div = document.createElement('div');
                const index = perspectiveCount++;
                div.className = 'perspective-item bg-surface-container-low p-6 rounded-[2rem] border border-outline-variant/30 relative group animate-in fade-in slide-in-from-top-4 duration-300';
                div.setAttribute('data-index', index);
                div.innerHTML = `
                    <button type="button" onclick="this.closest('.perspective-item').remove()" class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block font-label text-xs text-on-surface-variant mb-2 font-bold uppercase tracking-wider">Nama Tokoh / Perspektif</label>
                                <input type="text" name="content[E][perspectives][${index}][name]" 
                                       class="w-full h-12 px-4 bg-white border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                       placeholder="Contoh: Aktivis Lingkungan">
                            </div>
                            <div>
                                <label class="block font-label text-xs text-on-surface-variant mb-2 font-bold uppercase tracking-wider">Gambar Tokoh</label>
                                <div class="flex gap-2">
                                    <input type="url" name="content[E][perspectives][${index}][image]" id="input_e_image_${index}"
                                           class="flex-1 h-12 px-4 bg-white border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                           placeholder="URL Gambar">
                                    <button type="button" onclick="openMediaPicker('input_e_image_${index}', 'image')" class="h-12 px-4 bg-secondary-container/10 text-secondary font-bold rounded-xl border border-secondary/20 hover:bg-secondary hover:text-white transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">image</span>
                                        Media
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block font-label text-xs text-on-surface-variant mb-2 font-bold uppercase tracking-wider">Kutipan Pendapat</label>
                            <textarea name="content[E][perspectives][${index}][text]" rows="5" class="w-full p-4 bg-white border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                      placeholder="Apa pendapat tokoh ini tentang isunya?"></textarea>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            }
        </script>
        @endpush

        <!-- D: Diskusi -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-outline-variant/30 pb-4">
                <div class="flex items-center gap-3 text-purple-600">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center font-bold text-lg">D</div>
                    <h3 class="font-headline text-xl font-bold">Fase Diskusi</h3>
                </div>
                <div class="flex items-center gap-4">
                    <label class="text-sm font-bold text-on-surface-variant uppercase tracking-wider">Tipe Aktivitas:</label>
                    <select name="content[D][type]" class="px-4 py-2 bg-purple-50 text-purple-700 rounded-xl text-sm font-bold border border-purple-200 focus:ring-2 focus:ring-purple-200 transition-all outline-none">
                        <option value="chat" {{ ($content['D']['type'] ?? 'chat') == 'chat' ? 'selected' : '' }}>💬 Fitur Chat Langsung</option>
                        <option value="upload" {{ ($content['D']['type'] ?? '') == 'upload' ? 'selected' : '' }}>📤 Unggah File Hasil</option>
                        <option value="map" {{ ($content['D']['type'] ?? '') == 'map' ? 'selected' : '' }}>📊 Peta Argumen Visual</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">Instruksi Guru (Opsional)</label>
                        <textarea name="content[D][teacher_instruction]" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl">{{ $content['D']['teacher_instruction'] ?? '' }}</textarea>
                    </div>
                </div>
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2 font-bold">Topik Diskusi Utama</label>
                    <textarea name="content[D][topic]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                              placeholder="Apa yang harus didiskusikan siswa?">{{ $content['D']['topic'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- U & L: Ungkapkan & Lakukan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
                <div class="flex items-center gap-3 text-orange-600 border-b border-outline-variant/30 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center font-bold text-lg">U</div>
                    <h3 class="font-headline text-xl font-bold">Fase Ungkapkan</h3>
                </div>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">Instruksi Guru (Opsional)</label>
                        <textarea name="content[U][teacher_instruction]" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl">{{ $content['U']['teacher_instruction'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">Tugas Jurnal</label>
                        <textarea name="content[U][task]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                  placeholder="Tugas jurnal untuk fase Ungkapkan...">{{ $content['U']['task'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
                <div class="flex items-center gap-3 text-red-600 border-b border-outline-variant/30 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center font-bold text-lg">L</div>
                    <h3 class="font-headline text-xl font-bold">Fase Lakukan</h3>
                </div>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">Instruksi Guru (Opsional)</label>
                        <textarea name="content[L][teacher_instruction]" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl">{{ $content['L']['teacher_instruction'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">Tugas Aksi Nyata</label>
                        <textarea name="content[L][task]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                  placeholder="Aksi nyata yang harus dilakukan siswa...">{{ $content['L']['task'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- I: Introspeksi -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6">
            <div class="flex items-center gap-3 text-teal-600 border-b border-outline-variant/30 pb-4">
                <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center font-bold text-lg">I</div>
                <h3 class="font-headline text-xl font-bold">Fase Introspeksi</h3>
            </div>
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="block font-label text-sm text-on-surface mb-2 font-bold">Instruksi Guru (Opsional)</label>
                    <textarea name="content[I][teacher_instruction]" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl">{{ $content['I']['teacher_instruction'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block font-label text-sm text-on-surface mb-2 font-bold">Pertanyaan Refleksi Akhir</label>
                    <textarea name="content[I][questions]" rows="4" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                              placeholder="Tuliskan pertanyaan untuk membantu siswa merenungkan apa yang telah dipelajari...">{{ $content['I']['questions'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Essay: Soal Essay (Rubrik Empati) -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm space-y-6 border-l-8 border-l-blue-500">
            <div class="flex items-center gap-3 text-blue-600 border-b border-outline-variant/30 pb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center font-bold text-lg shadow-sm">S</div>
                <h3 class="font-headline text-xl font-bold">Soal Essay (Rubrik Empati)</h3>
            </div>
            <div class="space-y-4">
                <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 flex gap-3">
                    <span class="material-symbols-outlined text-blue-600">info</span>
                    <p class="text-xs text-blue-800 leading-relaxed font-medium">
                        Pertanyaan ini akan muncul setelah siswa menyelesaikan seluruh fase PEDULI. 
                        Tentukan pertanyaan spesifik untuk setiap dimensi empati di bawah ini.
                    </p>
                </div>
                <div class="space-y-2">
                    <label class="block font-label text-sm text-on-surface mb-2 font-bold">Instruksi Guru (Opsional)</label>
                    <textarea name="content[essay][teacher_instruction]" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl">{{ $content['essay']['teacher_instruction'] ?? '' }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">1. Kesadaran Emosional (Pertanyaan)</label>
                        <textarea name="content[essay][question_emotional]" rows="3" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                  placeholder="Contoh: Apa yang kamu rasakan mengenai isu ini?">{{ $content['essay']['question_emotional'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">2. Pengambilan Perspektif (Pertanyaan)</label>
                        <textarea name="content[essay][question_perspective]" rows="3" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                  placeholder="Contoh: Bagaimana sudut pandang orang lain yang terlibat?">{{ $content['essay']['question_perspective'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">3. Kepedulian Empatik (Pertanyaan)</label>
                        <textarea name="content[essay][question_care]" rows="3" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                  placeholder="Contoh: Apa bentuk kepedulian yang muncul dalam dirimu?">{{ $content['essay']['question_care'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block font-label text-sm text-on-surface mb-2 font-bold">4. Tanggung Jawab Sosial (Pertanyaan)</label>
                        <textarea name="content[essay][question_responsibility]" rows="3" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                  placeholder="Contoh: Apa tanggung jawab yang akan kamu ambil?">{{ $content['essay']['question_responsibility'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Media Picker Modal -->
<div id="mediaPickerModal" class="fixed inset-0 z-[200] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeMediaPicker()"></div>
    <div class="absolute inset-10 bg-white rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 flex items-center justify-between bg-surface-container-low">
            <div class="flex items-center gap-6">
                <h3 class="font-headline font-bold text-lg text-primary">Pilih Media</h3>
                <nav class="flex border-b border-transparent">
                    <button onclick="switchPickerTab('library')" id="tab_library" class="px-4 py-2 font-bold text-sm border-b-2 border-primary text-primary transition-all">Pustaka Media</button>
                    <button onclick="switchPickerTab('upload')" id="tab_upload" class="px-4 py-2 font-bold text-sm border-b-2 border-transparent text-on-surface-variant hover:text-primary transition-all">Unggah File</button>
                </nav>
            </div>
            <button onclick="closeMediaPicker()" class="p-2 hover:bg-white/50 rounded-full">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="flex-1 overflow-hidden flex flex-col">
            <!-- Library Tab -->
            <div id="picker_library_content" class="flex-1 overflow-y-auto p-6 space-y-4">
                <div class="relative max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                    <input type="text" id="pickerSearch" onkeyup="loadLibrary()" placeholder="Cari nama file..." 
                           class="w-full pl-9 pr-4 py-2 bg-surface-container-lowest border border-outline-variant/50 rounded-xl text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>

                <div id="pickerGrid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Media items will be loaded here -->
                </div>
                <div id="pickerLoading" class="hidden flex flex-col items-center justify-center py-20 gap-4">
                    <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-sm font-bold text-on-surface-variant uppercase tracking-widest">Memuat Media...</p>
                </div>
            </div>

            <!-- Upload Tab -->
            <div id="picker_upload_content" class="hidden flex-1 flex flex-col items-center justify-center p-12">
                <div id="dropzone" class="w-full max-w-xl aspect-video rounded-[3rem] border-4 border-dashed border-outline-variant/50 flex flex-col items-center justify-center gap-4 hover:border-primary hover:bg-primary/5 transition-all cursor-pointer group"
                     onclick="document.getElementById('picker_file_input').click()">
                    <div class="w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center text-on-surface-variant group-hover:scale-110 group-hover:bg-primary/10 group-hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-5xl">cloud_upload</span>
                    </div>
                    <div class="text-center">
                        <p class="font-headline text-xl font-bold text-on-surface">Tarik & Lepaskan File</p>
                        <p class="text-sm text-on-surface-variant mt-1">Atau klik untuk memilih file dari komputer</p>
                    </div>
                    <input type="file" id="picker_file_input" class="hidden" onchange="handlePickerUpload(this.files[0])">
                </div>
                <div id="uploadProgress" class="hidden w-full max-w-md mt-8 space-y-2">
                    <div class="flex justify-between text-xs font-bold uppercase tracking-wider">
                        <span id="uploadStatus">Mengunggah...</span>
                        <span id="uploadPercent">0%</span>
                    </div>
                    <div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden">
                        <div id="progressBar" class="w-0 h-full bg-primary transition-all duration-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .ck-editor__editable {
        min-height: 200px;
        background-color: #fcf9f8 !important;
        border-radius: 0 0 1rem 1rem !important;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
                        border-color: #e5e7eb !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    const editors = {};

    document.querySelectorAll('textarea[name^="content"]').forEach(textarea => {
        if (!textarea.name.includes('story_images')) {
            ClassicEditor
                .create(textarea, {
                    toolbar: {
                        items: [
                            'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'mediaLibrary',
                            'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    }
                })
                .then(editor => {
                    const name = textarea.getAttribute('name');
                    editors[name] = editor;

                    editor.ui.componentFactory.add('mediaLibrary', locale => {
                        const view = new editor.ui.view.button.ButtonView(locale);
                        view.set({
                            label: 'Sisipkan dari Media Library',
                            icon: '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" fill="currentColor"/></svg>',
                            tooltip: true
                        });
                        view.on('execute', () => {
                            openMediaPicker(name, '', false, true);
                        });
                        return view;
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });

    let currentTargetId = null;
    let isAppendMode = false;
    let currentTypeFilter = '';
    let isCkEditorMode = false;

    function switchPickerTab(tab) {
        const libTab = document.getElementById('tab_library');
        const upTab = document.getElementById('tab_upload');
        const libContent = document.getElementById('picker_library_content');
        const upContent = document.getElementById('picker_upload_content');

        if (tab === 'library') {
            libTab.classList.add('border-primary', 'text-primary');
            libTab.classList.remove('border-transparent', 'text-on-surface-variant');
            upTab.classList.remove('border-primary', 'text-primary');
            upTab.classList.add('border-transparent', 'text-on-surface-variant');
            libContent.classList.remove('hidden');
            upContent.classList.add('hidden');
            loadLibrary();
        } else {
            upTab.classList.add('border-primary', 'text-primary');
            upTab.classList.remove('border-transparent', 'text-on-surface-variant');
            libTab.classList.remove('border-primary', 'text-primary');
            libTab.classList.add('border-transparent', 'text-on-surface-variant');
            upContent.classList.remove('hidden');
            libContent.classList.add('hidden');
        }
    }

    function loadLibrary() {
        const grid = document.getElementById('pickerGrid');
        const loading = document.getElementById('pickerLoading');
        const search = document.getElementById('pickerSearch').value;
        grid.innerHTML = '';
        loading.classList.remove('hidden');

        const ts = new Date().getTime();
        let url = `/admin/media?ajax=1&t=${ts}`;
        if (currentTypeFilter) url += `&type=${currentTypeFilter}`;
        if (search) url += `&search=${encodeURIComponent(search)}`;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.json())
            .then(data => {
                loading.classList.add('hidden');
                
                if (data.length === 0) {
                    grid.innerHTML = `
                        <div class="col-span-full py-20 text-center">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">folder_open</span>
                            <p class="text-on-surface-variant font-bold mt-2 text-sm uppercase">Tidak ada media ditemukan</p>
                        </div>
                    `;
                    return;
                }

                data.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'group relative bg-surface-container-low rounded-2xl border border-outline-variant/30 overflow-hidden cursor-pointer hover:border-primary transition-all aspect-square flex items-center justify-center';
                    
                    let preview = '';
                    if (item.type === 'image') {
                        preview = `<img src="${item.url}" class="w-full h-full object-cover">`;
                    } else {
                        preview = `<div class="flex flex-col items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-3xl">description</span>
                            <span class="text-[9px] font-bold uppercase truncate px-2 w-full text-center">${item.original_name}</span>
                        </div>`;
                    }

                    div.innerHTML = preview;
                    div.onclick = () => selectMedia(item);
                    grid.appendChild(div);
                });
            });
    }

    function openMediaPicker(targetId, type = '', append = false, ckEditor = false) {
        currentTargetId = targetId;
        isAppendMode = append;
        currentTypeFilter = type;
        isCkEditorMode = ckEditor;
        document.getElementById('mediaPickerModal').classList.remove('hidden');
        switchPickerTab('library');
    }

    function closeMediaPicker() {
        document.getElementById('mediaPickerModal').classList.add('hidden');
    }

    function selectMedia(media) {
        const url = media.url;
        
        if (isCkEditorMode) {
            const editor = editors[currentTargetId];
            if (editor) {
                if (media.type === 'image') {
                    editor.model.change(writer => {
                        const imageElement = writer.createElement('imageBlock', {
                            src: url,
                            alt: media.original_name
                        });
                        editor.model.insertContent(imageElement, editor.model.document.selection);
                    });
                } else {
                    const linkHtml = `<a href="${url}" class="download-link" target="_blank">📥 Unduh: ${media.original_name}</a>`;
                    const viewFragment = editor.data.processor.toView(linkHtml);
                    const modelFragment = editor.data.toModel(viewFragment);
                    editor.model.insertContent(modelFragment, editor.model.document.selection);
                }
            }
        } else {
            const input = document.getElementById(currentTargetId);
            if (isAppendMode) {
                const currentVal = input.value.trim();
                input.value = currentVal ? `${currentVal}\n${url}` : url;
            } else {
                input.value = url;
            }
        }
        
        closeMediaPicker();
    }

    function handlePickerUpload(file) {
        if (!file) return;

        const progress = document.getElementById('uploadProgress');
        const bar = document.getElementById('progressBar');
        const percent = document.getElementById('uploadPercent');
        const status = document.getElementById('uploadStatus');

        progress.classList.remove('hidden');
        status.innerText = 'Mengunggah...';

        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', '{{ csrf_token() }}');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.media.store") }}', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                const p = Math.round((e.loaded / e.total) * 100);
                bar.style.width = p + '%';
                percent.innerText = p + '%';
            }
        };

        xhr.onload = () => {
            if (xhr.status === 200) {
                status.innerText = 'Selesai!';
                setTimeout(() => {
                    progress.classList.add('hidden');
                    bar.style.width = '0%';
                    switchPickerTab('library');
                }, 1000);
            } else {
                status.innerText = 'Gagal mengunggah.';
            }
        };

        xhr.send(formData);
    }

    const dz = document.getElementById('dropzone');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dz.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dz.addEventListener(eventName, () => dz.classList.add('bg-primary/10', 'border-primary'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dz.addEventListener(eventName, () => dz.classList.remove('bg-primary/10', 'border-primary'), false);
    });

    dz.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        handlePickerUpload(file);
    }, false);
</script>
@endpush
@endsection
