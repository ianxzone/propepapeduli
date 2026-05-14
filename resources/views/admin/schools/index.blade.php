@extends('layouts.admin')

@section('title', 'Manajemen Sekolah - ProPePa')
@section('header_title', 'Daftar Sekolah')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="font-headline text-headline-sm text-on-surface">Data Sekolah</h2>
        <a href="{{ route('admin.schools.create') }}" class="bg-primary text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-primary/90 transition-all shadow-sm">
            <span class="material-symbols-outlined text-sm">add</span>
            Tambah Sekolah
        </a>
    </div>

    @if(session('success'))
        <div class="bg-[#d4edda] text-[#155724] p-4 rounded-xl font-bold text-sm border border-[#c3e6cb]">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-error/10 text-error p-4 rounded-xl font-bold text-sm border border-error/20">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-sm border-b border-outline-variant/30">
                        <th class="p-4 font-bold">Nama Sekolah</th>
                        <th class="p-4 font-bold">Alamat</th>
                        <th class="p-4 font-bold">Kontak Person</th>
                        <th class="p-4 font-bold text-center">Jumlah Kelas</th>
                        <th class="p-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse($schools as $school)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="p-4 font-bold text-on-surface">{{ $school->name }}</td>
                            <td class="p-4 text-sm text-on-surface-variant">{{ $school->address ?: '-' }}</td>
                            <td class="p-4 text-sm text-on-surface-variant">{{ $school->contact_person ?: '-' }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $school->classes_count }} Kelas
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.schools.edit', $school->id) }}" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-error hover:bg-error hover:text-white transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-on-surface-variant italic">Belum ada data sekolah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
