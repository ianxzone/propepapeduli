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

<script>
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
        const searchInput = document.getElementById('pickerSearch');
        const search = searchInput ? searchInput.value : '';
        
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
            if (typeof editors !== 'undefined' && editors[currentTargetId]) {
                const editor = editors[currentTargetId];
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
            if (input) {
                if (isAppendMode) {
                    const currentVal = input.value.trim();
                    input.value = currentVal ? `${currentVal}\n${url}` : url;
                } else {
                    input.value = url;
                }
                // Trigger change event for any listeners
                input.dispatchEvent(new Event('change'));
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

    // Dropzone logic
    document.addEventListener('DOMContentLoaded', function() {
        const dz = document.getElementById('dropzone');
        if (dz) {
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
            });
        }
    });
</script>
