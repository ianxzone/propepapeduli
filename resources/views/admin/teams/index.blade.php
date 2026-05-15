@extends('layouts.admin')

@section('title', 'Manajemen Tim - ProPePa')
@section('header_title', 'Manajemen Tim')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-on-surface-variant text-sm">Kelola informasi tim yang tampil di halaman depan.</h2>
        </div>
        
        <a href="{{ route('admin.teams.create') }}" class="bg-primary text-white font-bold px-6 py-3 rounded-2xl shadow-soft hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">group_add</span>
            Tambah Anggota Tim
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-soft border border-outline-variant/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-xs uppercase tracking-widest border-b border-outline-variant/30">
                        <th class="p-6 font-bold">Anggota</th>
                        <th class="p-6 font-bold">Jabatan</th>
                        <th class="p-6 font-bold text-center">Urutan</th>
                        <th class="p-6 font-bold text-center">Status</th>
                        <th class="p-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 text-sm">
                    @forelse($teams as $member)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-surface-container overflow-hidden">
                                    @if($member->image)
                                        <img src="{{ $member->image }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-primary font-bold">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ $member->name }}</p>
                                    <p class="text-[10px] text-on-surface-variant italic">{{ Str::limit($member->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                            <span class="font-medium text-on-surface-variant">{{ $member->position }}</span>
                        </td>
                        <td class="p-6 text-center">
                            <span class="bg-surface-container px-3 py-1 rounded-full text-xs font-bold">{{ $member->order }}</span>
                        </td>
                        <td class="p-6 text-center">
                            @if($member->is_active)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">Aktif</span>
                            @else
                                <span class="bg-outline-variant text-on-surface-variant px-3 py-1 rounded-full text-[10px] font-bold uppercase">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.teams.edit', $member->id) }}" class="p-2 text-on-surface-variant hover:bg-primary/10 hover:text-primary rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('admin.teams.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Hapus anggota tim ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-on-surface-variant hover:bg-error/10 hover:text-error rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-on-surface-variant italic">
                            Belum ada anggota tim. Klik tombol "Tambah Anggota Tim" untuk memulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
