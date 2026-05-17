@extends('layouts.teacher')

@section('title', 'Impor Massal Siswa - ProPePa')
@section('header_title', 'Manajemen Siswa')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.students.index', ['class_id' => $class?->id]) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-headline text-headline-md text-on-surface">Impor Massal Siswa</h1>
            <p class="text-on-surface-variant italic">Daftarkan banyak siswa sekaligus dengan cepat menggunakan file CSV/TXT atau salin teks.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="p-4 bg-error-container text-on-error-container rounded-2xl border border-error/10 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tab Selector -->
    <div class="bg-surface-container-low p-2 rounded-2xl flex gap-2 border border-outline-variant/20">
        <button type="button" onclick="switchTab('file')" id="tab-btn-file" 
                class="flex-1 py-3 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 bg-white text-primary shadow-sm border border-outline-variant/10">
            <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
            <span>Metode A: Unggah File</span>
        </button>
        <button type="button" onclick="switchTab('paste')" id="tab-btn-paste" 
                class="flex-1 py-3 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 text-on-surface-variant hover:bg-surface-container-high/50">
            <span class="material-symbols-outlined text-[18px]">content_paste</span>
            <span>Metode B: Tempel Daftar Nama</span>
        </button>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] border border-outline-variant/30 shadow-sm">
        <form action="{{ route('teacher.students.import.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Class Field -->
            @if(in_array(Auth::user()->role, ['admin', 'dosen']))
                <div>
                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2 ml-1">Pilih Kelas Sasaran</label>
                    <select name="class_id" required class="w-full h-12 px-4 bg-surface-container-lowest border-2 border-outline-variant/30 rounded-xl focus:border-primary focus:ring-0 transition-all text-sm font-medium">
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
                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2 ml-1">Kelas & Sekolah Sasaran</label>
                    <input type="text" readonly value="{{ $teacher->class->name }} - {{ $teacher->class->school->name }}" 
                           class="w-full h-12 px-4 bg-surface-container border-2 border-outline-variant/10 rounded-xl text-on-surface-variant text-sm font-medium cursor-not-allowed">
                </div>
            @endif

            <input type="hidden" name="import_method" id="import_method_input" value="file">

            <!-- TAB 1: FILE METHOD -->
            <div id="tab-content-file" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-outline uppercase tracking-wider ml-1">Unggah Berkas (CSV / TXT)</label>
                    
                    <div class="border-2 border-dashed border-outline-variant/50 rounded-2xl p-8 text-center bg-surface-container-lowest hover:border-primary transition-all relative cursor-pointer group">
                        <input type="file" name="import_file" id="import_file_input" accept=".csv,.txt"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <span class="material-symbols-outlined text-4xl text-outline/50 group-hover:text-primary transition-colors">cloud_upload</span>
                        <h4 class="font-bold text-sm text-on-surface mt-2 group-hover:text-primary transition-colors">Pilih file atau seret ke sini</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Mendukung berkas ekstensi .csv atau .txt (Maks. 2MB)</p>
                        <p id="file-name-display" class="text-xs text-primary font-bold mt-3 hidden bg-primary/5 py-1 px-3 rounded-full inline-block border border-primary/20"></p>
                    </div>
                    @error('import_file')
                        <p class="text-xs text-error mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CSV Template Download Panel -->
                <div class="p-6 bg-surface-container-low rounded-2xl border border-outline-variant/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <h4 class="font-bold text-sm text-on-surface">Unduh Template Contoh Format</h4>
                        <p class="text-xs text-on-surface-variant">Gunakan file contoh ini agar pengisian nama siswa sesuai standar.</p>
                    </div>
                    <a href="{{ route('teacher.students.import.sample') }}" 
                       class="flex items-center gap-2 bg-primary text-white px-5 h-11 rounded-xl font-bold text-xs shadow-soft hover:bg-primary/95 transition-all">
                        <span class="material-symbols-outlined text-[18px]">download_for_offline</span>
                        <span>Unduh Template CSV</span>
                    </a>
                </div>
            </div>

            <!-- TAB 2: PASTE METHOD -->
            <div id="tab-content-paste" class="space-y-4 hidden">
                <div>
                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2 ml-1">Tempel Daftar Nama Siswa</label>
                    <textarea name="import_paste" placeholder="Tulis atau tempel nama siswa di sini (satu nama per baris)...&#10;Contoh:&#10;Budi Darmawan&#10;Siti Aminah&#10;Ahmad Fauzi" 
                              rows="8" 
                              class="w-full p-4 bg-surface-container-lowest border-2 border-outline-variant/30 rounded-xl focus:border-primary focus:ring-0 transition-all text-sm font-mono"></textarea>
                    @error('import_paste')
                        <p class="text-xs text-error mt-1 ml-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] text-on-surface-variant italic mt-1.5 ml-1">Tulis atau salin nama siswa langsung dari Ms. Excel atau berkas teks. Pastikan setiap baris hanya berisi 1 nama siswa.</p>
                </div>
            </div>

            <div class="bg-primary/5 p-4 rounded-2xl border border-primary/10 flex gap-3">
                <span class="material-symbols-outlined text-primary text-sm shrink-0">info</span>
                <p class="text-[10px] text-on-surface-variant italic leading-relaxed">
                    Setiap siswa yang diimpor akan secara otomatis terdaftar di platform dengan password default <strong>123456</strong>. Siswa dapat login secara langsung dengan memilih namanya di kelas masing-masing.
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
                    <span class="material-symbols-outlined text-[18px]">publish</span>
                    <span>Proses Impor Siswa</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(method) {
        document.getElementById('import_method_input').value = method;
        
        const btnFile = document.getElementById('tab-btn-file');
        const btnPaste = document.getElementById('tab-btn-paste');
        const contentFile = document.getElementById('tab-content-file');
        const contentPaste = document.getElementById('tab-content-paste');
        
        const fileInput = document.getElementById('import_file_input');
        
        if (method === 'file') {
            btnFile.className = "flex-1 py-3 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 bg-white text-primary shadow-sm border border-outline-variant/10";
            btnPaste.className = "flex-1 py-3 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 text-on-surface-variant hover:bg-surface-container-high/50";
            
            contentFile.classList.remove('hidden');
            contentPaste.classList.add('hidden');
            
            fileInput.required = true;
        } else {
            btnPaste.className = "flex-1 py-3 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 bg-white text-primary shadow-sm border border-outline-variant/10";
            btnFile.className = "flex-1 py-3 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 text-on-surface-variant hover:bg-surface-container-high/50";
            
            contentPaste.classList.remove('hidden');
            contentFile.classList.add('hidden');
            
            fileInput.required = false;
        }
    }

    // Set file requirement on DOM ready
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('import_file_input').required = true;
    });

    // File name display listener
    document.getElementById('import_file_input').addEventListener('change', function(e) {
        const fileDisplay = document.getElementById('file-name-display');
        if (e.target.files && e.target.files.length > 0) {
            fileDisplay.innerText = "Berkas Terpilih: " + e.target.files[0].name;
            fileDisplay.classList.remove('hidden');
        } else {
            fileDisplay.innerText = "";
            fileDisplay.classList.add('hidden');
        }
    });
</script>
@endsection
