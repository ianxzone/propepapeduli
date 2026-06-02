@extends('layouts.app')

@section('title', 'Lakukan - ' . $module->title)

@section('content')
<div class="pb-24">
    <!-- Top Header -->
    <header class="bg-white px-container-padding py-4 shadow-sm flex items-center justify-between sticky top-0 z-50">
        <x-logo variant="pill" />
        
        <div class="flex items-center gap-3">
            <div class="bg-secondary-container/10 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-secondary-container/20">
                <span class="material-symbols-outlined text-secondary text-lg" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="font-headline text-secondary font-bold">{{ Auth::user()->points }}</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold border-2 border-white shadow-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </header>

    <main class="px-container-padding pt-6 space-y-8">
        <!-- Validation Errors -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm font-bold animate-in fade-in slide-in-from-top-2">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Step Indicator & Title -->
        <div class="space-y-4">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-xl">rocket_launch</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Fase 5: Lakukan (L)</span>
            </div>
            
            @if(!empty($module->content['L']['teacher_instruction']))
            <div class="bg-primary/5 p-4 rounded-2xl border border-primary/10 flex gap-3">
                <span class="material-symbols-outlined text-primary">record_voice_over</span>
                <div class="prose prose-sm prose-primary max-w-none text-on-surface leading-relaxed">
                    {!! $module->content['L']['teacher_instruction'] !!}
                </div>
            </div>
            @endif

            <h1 class="font-headline text-headline-lg text-on-surface leading-tight">Waktunya Beraksi!</h1>
            <div class="prose prose-sm prose-primary max-w-none text-on-surface-variant leading-relaxed">
                {!! $module->content['L']['task'] ?? 'Pilih aksi nyata yang akan kamu lakukan untuk membantu menjaga lingkungan.' !!}
            </div>
        </div>

        <form id="lakukan-form" action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" enctype="multipart/form-data" class="space-y-8" novalidate>
            @csrf
            
            <!-- Action Task Card -->
            <section class="bg-white rounded-[2.5rem] shadow-soft border border-outline-variant/30 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10 bg-secondary/5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-secondary text-white flex items-center justify-center shadow-soft">
                        <span class="material-symbols-outlined">task_alt</span>
                    </div>
                    <div>
                        <h2 class="font-headline text-on-surface font-bold">Rencana Aksi Nyata</h2>
                        <p class="text-xs text-on-surface-variant">Tuliskan komitmenmu dan unggah buktinya.</p>
                    </div>
                </div>
                
                <div class="p-8 space-y-6">
                    @if(!empty($module->content['L']['task']))
                    <div class="bg-surface-container-low p-4 rounded-2xl border border-outline-variant/20">
                        <p class="text-xs font-bold text-secondary uppercase tracking-widest mb-1">Tugas Dari Guru:</p>
                        <p class="text-sm text-on-surface leading-relaxed">{!! $module->content['L']['task'] !!}</p>
                    </div>
                    @endif

                    <div class="space-y-2">
                        <label class="block font-bold text-sm text-on-surface ml-1">Deskripsi Aksimu</label>
                        <textarea name="content" rows="4" required
                                  class="w-full rounded-2xl border-2 border-outline-variant/30 focus:border-primary focus:ring-0 bg-surface-container-low p-4 text-sm text-on-surface placeholder:text-outline-variant transition-all" 
                                  placeholder="Tuliskan apa yang akan kamu lakukan... (Contoh: Saya akan membawa tumbler sendiri setiap hari)"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="block font-bold text-sm text-on-surface ml-1">Dokumentasi (Foto)</label>
                        <div class="relative group">
                            <input type="file" name="image" accept="image/*" id="image-upload" class="hidden" required>
                            <label for="image-upload" class="flex flex-col items-center justify-center gap-3 p-10 rounded-2xl border-2 border-dashed border-outline-variant/50 hover:border-secondary hover:bg-secondary/5 transition-all cursor-pointer bg-surface-container-low">
                                <div id="upload-placeholder" class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-secondary">add_a_photo</span>
                                    <span class="text-sm font-bold text-on-surface-variant">Klik untuk pilih foto aksi</span>
                                </div>
                                <div id="image-preview" class="hidden w-full flex flex-col items-center gap-4">
                                    <img src="" alt="Preview" class="max-h-64 rounded-xl shadow-md border-4 border-white">
                                    <span class="text-xs text-secondary font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">change_circle</span>
                                        Ganti Foto
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Final Commitment Button -->
            <button type="submit" 
                    class="w-full h-20 bg-primary text-white rounded-3xl font-headline text-headline-md flex items-center justify-center gap-4 shadow-[0_6px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_4px_0_0_#410000] transition-all mt-8">
                <span>Kirim Aksi & Lanjut</span>
                <span class="material-symbols-outlined text-3xl">celebration</span>
            </button>
        </form>
    </main>

    @push('scripts')
    <script>
        document.getElementById('image-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    const placeholder = document.getElementById('upload-placeholder');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Child-Friendly Form Validation
        document.getElementById('lakukan-form').addEventListener('submit', function(e) {
            let isValid = true;
            const contentTextarea = document.querySelector('textarea[name="content"]');
            const fileInput = document.getElementById('image-upload');
            const fileLabel = document.querySelector('label[for="image-upload"]');
            
            // Remove existing errors
            document.querySelectorAll('.error-feedback-msg').forEach(el => el.remove());
            if (contentTextarea) contentTextarea.classList.remove('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
            if (fileLabel) fileLabel.classList.remove('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
            
            // 1. Validate textarea
            if (contentTextarea && !contentTextarea.value.trim()) {
                isValid = false;
                contentTextarea.classList.add('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
                
                const errMsg = document.createElement('p');
                errMsg.className = 'error-feedback-msg text-red-500 text-xs font-bold mt-2 flex items-center gap-1';
                errMsg.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Tuliskan deskripsi aksi nyatamu terlebih dahulu ya!';
                contentTextarea.parentElement.appendChild(errMsg);
            }
            
            // 2. Validate file upload
            if (fileInput && fileInput.hasAttribute('required') && !fileInput.files.length) {
                isValid = false;
                if (fileLabel) {
                    fileLabel.classList.add('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
                    
                    const errMsg = document.createElement('p');
                    errMsg.className = 'error-feedback-msg text-red-500 text-xs font-bold mt-2 flex items-center justify-center gap-1';
                    errMsg.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Kamu harus mengunggah foto aksi nyatamu terlebih dahulu ya!';
                    fileLabel.parentElement.appendChild(errMsg);
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Ada yang Terlewat! 🌟',
                    text: 'Silakan tulis rencana aksi nyatamu dan unggah bukti fotonya sebelum melanjutkan.',
                    icon: 'warning',
                    confirmButtonText: 'Oke, Aku Lengkapi! 👍',
                    confirmButtonColor: '#570000',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                });
                
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    </script>
    @endpush

    <!-- Bottom Nav -->
    <x-student-nav active="modul" />
</div>
@endsection
