@extends('layouts.admin')

@section('title', 'Pustaka Media - ProPePa')
@section('header_title', 'Pustaka Media')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0">
            <a href="{{ route('admin.media.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold whitespace-nowrap {{ !$type ? 'bg-primary text-white' : 'bg-white text-on-surface hover:bg-surface-container-low' }} transition-all">Semua</a>
            <a href="{{ route('admin.media.index', ['type' => 'image']) }}" class="px-4 py-2 rounded-xl text-sm font-bold whitespace-nowrap {{ $type == 'image' ? 'bg-primary text-white' : 'bg-white text-on-surface hover:bg-surface-container-low' }} transition-all">Gambar</a>
            <a href="{{ route('admin.media.index', ['type' => 'document']) }}" class="px-4 py-2 rounded-xl text-sm font-bold whitespace-nowrap {{ $type == 'document' ? 'bg-primary text-white' : 'bg-white text-on-surface hover:bg-surface-container-low' }} transition-all">Dokumen</a>
            
            <div class="ml-4 relative flex-1 min-w-[200px]">
                <form action="{{ route('admin.media.index') }}" method="GET" class="relative">
                    @if($type) <input type="hidden" name="type" value="{{ $type }}"> @endif
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama file..." 
                           class="w-full pl-9 pr-4 py-2 bg-white border border-outline-variant/50 rounded-xl text-sm focus:border-primary focus:ring-0">
                </form>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <div id="mainDropzone" class="hidden md:flex items-center gap-3 px-6 py-3 bg-white border-2 border-dashed border-outline-variant rounded-2xl text-on-surface-variant hover:border-primary hover:bg-primary/5 transition-all cursor-pointer group">
                <span class="material-symbols-outlined text-xl group-hover:scale-120 transition-transform">cloud_upload</span>
                <span class="text-xs font-bold uppercase tracking-wider">Tarik file ke sini untuk unggah</span>
            </div>
            
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="mainUploadForm">
                @csrf
                <input type="file" name="file" id="file_upload" class="hidden" onchange="this.form.submit()">
                <label for="file_upload" class="cursor-pointer bg-primary text-white font-bold px-6 py-3 rounded-2xl shadow-soft hover:bg-primary/90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">upload_file</span>
                    Pilih File
                </label>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($media as $item)
        <div class="group relative bg-white rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer" 
             onclick="openMediaDetail({{ json_encode([
                'id' => $item->id,
                'url' => $item->url,
                'filename' => $item->filename,
                'original_name' => $item->original_name,
                'type' => $item->type,
                'alt_text' => $item->alt_text,
                'caption' => $item->caption,
                'description' => $item->description
             ]) }})">
            <div class="aspect-square bg-surface-container-low flex items-center justify-center">
                @if($item->type == 'image')
                    <img src="{{ $item->url }}" class="w-full h-full object-cover">
                @else
                    <div class="flex flex-col items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl">
                            {{ $item->type == 'document' ? 'description' : ($item->type == 'video' ? 'movie' : 'draft') }}
                        </span>
                        <span class="text-[10px] font-bold uppercase">{{ $item->extension }}</span>
                    </div>
                @endif
            </div>
            <div class="p-3">
                <p class="text-xs font-bold text-on-surface truncate">{{ $item->original_name }}</p>
                <p class="text-[10px] text-on-surface-variant">{{ $item->human_size }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $media->links() }}
    </div>
</div>

<!-- Media Detail Modal -->
<div id="mediaModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeMediaModal()"></div>
    <div class="absolute right-0 top-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col transform transition-transform duration-300 translate-x-full" id="modalContent">
        <div class="p-6 border-b border-outline-variant/30 flex items-center justify-between">
            <h3 class="font-headline font-bold text-lg">Detail Media</h3>
            <button onclick="closeMediaModal()" class="p-2 hover:bg-surface-container-low rounded-full">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            <div id="modalPreview" class="aspect-video rounded-2xl bg-surface-container-low flex items-center justify-center overflow-hidden border border-outline-variant/30">
                <!-- Dynamic Preview -->
            </div>
            
            <form id="mediaUpdateForm" action="" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Nama File</label>
                    <p id="modalFilename" class="text-sm font-bold text-on-surface"></p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Alt Text</label>
                    <input type="text" name="alt_text" id="modalAlt" class="w-full rounded-xl border border-outline-variant/50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Caption</label>
                    <input type="text" name="caption" id="modalCaption" class="w-full rounded-xl border border-outline-variant/50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Keterangan</label>
                    <textarea name="description" id="modalDesc" rows="3" class="w-full rounded-xl border border-outline-variant/50 px-4 py-2 text-sm"></textarea>
                </div>
                <div class="flex items-center gap-2 pt-4">
                    <button type="submit" class="flex-1 bg-primary text-white font-bold py-3 rounded-xl hover:bg-primary/90 transition-all">Simpan Perubahan</button>
                    <button type="button" onclick="deleteMedia()" class="p-3 text-error bg-error/10 rounded-xl hover:bg-error hover:text-white transition-all">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentMediaId = null;

    function openMediaDetail(media) {
        currentMediaId = media.id;
        const modal = document.getElementById('mediaModal');
        const content = document.getElementById('modalContent');
        const preview = document.getElementById('modalPreview');
        const form = document.getElementById('mediaUpdateForm');
        
        form.action = `/admin/media/${media.id}`;
        document.getElementById('modalFilename').innerText = media.original_name;
        document.getElementById('modalAlt').value = media.alt_text || '';
        document.getElementById('modalCaption').value = media.caption || '';
        document.getElementById('modalDesc').value = media.description || '';

        if (media.type === 'image') {
            preview.innerHTML = `<img src="/storage/media/${media.filename}" class="w-full h-full object-contain">`;
        } else {
            preview.innerHTML = `<div class="flex flex-col items-center gap-2"><span class="material-symbols-outlined text-5xl">description</span><span class="font-bold text-sm uppercase">${media.original_name.split('.').pop()}</span></div>`;
        }

        modal.classList.remove('hidden');
        setTimeout(() => content.classList.remove('translate-x-full'), 10);
    }

    function closeMediaModal() {
        const modal = document.getElementById('mediaModal');
        const content = document.getElementById('modalContent');
        content.classList.add('translate-x-full');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function deleteMedia() {
        if (confirm('Hapus media ini secara permanen?')) {
            fetch(`/admin/media/${currentMediaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(() => window.location.reload());
        }
    }

    // Main Page Drag and Drop
    const mainDz = document.getElementById('mainDropzone');
    const mainForm = document.getElementById('mainUploadForm');
    const mainInput = document.getElementById('file_upload');

    if (mainDz) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            document.body.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            document.body.addEventListener(eventName, () => mainDz.classList.remove('hidden'), false);
        });

        mainDz.addEventListener('drop', e => {
            const dt = e.dataTransfer;
            const file = dt.files[0];
            mainInput.files = dt.files;
            mainForm.submit();
        }, false);
        
        mainDz.addEventListener('click', () => mainInput.click());
    }
</script>
@endpush
@endsection
