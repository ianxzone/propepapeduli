@extends('layouts.admin')

@section('title', 'Manajemen User - ProPePa')
@section('header_title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold {{ !$role ? 'bg-primary text-white' : 'bg-white text-on-surface hover:bg-surface-container-low' }} transition-all">Semua</a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="px-4 py-2 rounded-xl text-sm font-bold {{ $role == 'admin' ? 'bg-primary text-white' : 'bg-white text-on-surface hover:bg-surface-container-low' }} transition-all">Admin</a>
            <a href="{{ route('admin.users.index', ['role' => 'teacher']) }}" class="px-4 py-2 rounded-xl text-sm font-bold {{ $role == 'teacher' ? 'bg-primary text-white' : 'bg-white text-on-surface hover:bg-surface-container-low' }} transition-all">Guru</a>
            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="px-4 py-2 rounded-xl text-sm font-bold {{ $role == 'student' ? 'bg-primary text-white' : 'bg-white text-on-surface hover:bg-surface-container-low' }} transition-all">Siswa</a>
        </div>
        
        <a href="{{ route('admin.users.create') }}" class="bg-primary text-white font-bold px-6 py-3 rounded-2xl shadow-soft hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">person_add</span>
            Tambah User Baru
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-soft border border-outline-variant/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-xs uppercase tracking-widest border-b border-outline-variant/30">
                        <th class="p-6 font-bold">Nama & Email</th>
                        <th class="p-6 font-bold text-center">Role</th>
                        <th class="p-6 font-bold text-center">Kelas</th>
                        <th class="p-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 text-sm">
                    @foreach($users as $user)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ $user->name }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            @if($user->role == 'admin')
                                <span class="bg-error/10 text-error px-3 py-1 rounded-full text-[10px] font-bold uppercase">Admin</span>
                            @elseif($user->role == 'teacher')
                                <span class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[10px] font-bold uppercase">Guru</span>
                            @else
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase">Siswa</span>
                            @endif
                        </td>
                        <td class="p-6 text-center text-on-surface-variant">
                            {{ $user->class->name ?? '-' }}
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-on-surface-variant hover:bg-primary/10 hover:text-primary rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-on-surface-variant hover:bg-error/10 hover:text-error rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="p-6 border-t border-outline-variant/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
