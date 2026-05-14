@extends('layouts.admin')

@section('title', 'Manajemen Modul - ProPePa')
@section('header_title', 'Manajemen Modul')

@section('content')
<div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-low">
        <h2 class="font-headline text-headline-md text-on-surface">Daftar Modul Belajar</h2>
        <a href="{{ route('admin.modules.create') }}" class="bg-primary text-white font-bold px-5 py-2.5 rounded-xl hover:bg-primary/90 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">add</span>
            Buat Modul Baru
        </a>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($modules as $module)
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/50 overflow-hidden flex flex-col transition-all hover:shadow-md hover:border-outline-variant group">
                    <!-- Thumbnail -->
                    <div class="h-40 relative overflow-hidden bg-surface-variant">
                        @if($module->thumbnail)
                            <img src="{{ $module->thumbnail }}" alt="{{ $module->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-outline">
                                <span class="material-symbols-outlined text-4xl">image</span>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @if($module->is_active)
                                <span class="bg-[#d4edda] text-[#155724] px-3 py-1 rounded-full text-xs font-bold shadow-sm">Aktif</span>
                            @else
                                <span class="bg-surface-container-high text-on-surface-variant px-3 py-1 rounded-full text-xs font-bold shadow-sm">Draft</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-headline text-lg font-bold text-on-surface mb-2 line-clamp-1" title="{{ $module->title }}">{{ $module->title }}</h3>
                        <p class="text-sm text-on-surface-variant line-clamp-2 mb-4 flex-1">{{ $module->description }}</p>
                        
                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-outline-variant/30 mt-auto">
                            <span class="text-xs text-outline font-medium">{{ $module->created_at->format('d M Y') }}</span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.modules.content', $module->id) }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all text-xs font-bold">
                                    <span class="material-symbols-outlined text-[16px]">article</span>
                                    Konten
                                </a>
                                <a href="{{ route('admin.modules.edit', $module->id) }}" class="w-8 h-8 rounded-lg bg-surface-container hover:bg-secondary-container/20 hover:text-secondary text-on-surface-variant flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-surface-container hover:bg-error-container/50 hover:text-error text-on-surface-variant flex items-center justify-center transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-5xl mb-3 text-outline">library_books</span>
                    <p class="font-headline text-lg">Belum ada modul yang dibuat.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
