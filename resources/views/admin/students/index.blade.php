@extends('layouts.admin')

@section('title', 'Manajemen Siswa - ProPePa PEDULI')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-headline-md text-on-surface">Data Siswa</h1>
            <p class="text-on-surface-variant italic">Kelola data siswa, penempatan kelas, dan total poin mereka.</p>
        </div>
        <a href="{{ route('admin.students.create') }}" class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-2xl font-bold shadow-soft hover:bg-primary/90 transition-all self-start">
            <span class="material-symbols-outlined">person_add</span>
            <span>Tambah Siswa</span>
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-6 rounded-[2.5rem] border border-outline-variant/30 shadow-sm">
        <form action="{{ route('admin.students.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-outline uppercase mb-2 ml-1">Pencarian</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant material-symbols-outlined text-[20px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full h-12 pl-12 pr-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm"
                           placeholder="Cari nama siswa...">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-outline uppercase mb-2 ml-1">Filter Kelas</label>
                <select name="class_id" class="w-full h-12 px-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm appearance-none">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->school->name }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="h-12 px-6 bg-secondary-container text-on-secondary-container rounded-xl font-bold hover:bg-secondary-container/80 transition-all">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'class_id']))
                    <a href="{{ route('admin.students.index') }}" class="h-12 px-4 flex items-center text-error font-bold text-sm hover:underline">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-[2.5rem] border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-lowest border-b border-outline-variant/30">
                        <th class="px-6 py-4 font-headline text-sm font-bold text-on-surface">Siswa</th>
                        <th class="px-6 py-4 font-headline text-sm font-bold text-on-surface">Sekolah & Kelas</th>
                        <th class="px-6 py-4 font-headline text-sm font-bold text-on-surface">Poin</th>
                        <th class="px-6 py-4 font-headline text-sm font-bold text-on-surface text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse($students as $student)
                    <tr class="hover:bg-surface-container-lowest/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ $student->name }}</p>
                                    <p class="text-xs text-on-surface-variant">ID: #{{ $student->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-on-surface">{{ $student->class->name }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $student->class->school->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">
                                <span class="material-symbols-outlined text-[16px]">stars</span>
                                {{ number_format($student->points) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.students.edit', $student) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-surface-container text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-surface-container text-on-surface-variant hover:bg-error/10 hover:text-error transition-all">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-on-surface-variant italic">
                            Belum ada data siswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
        <div class="px-6 py-4 bg-surface-container-lowest border-t border-outline-variant/30">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
