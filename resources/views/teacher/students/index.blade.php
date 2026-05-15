@extends('layouts.teacher')

@section('title', 'Daftar Siswa - ProPePa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="font-headline text-headline-md text-on-surface">Data Siswa</h1>
                @if(in_array(Auth::user()->role, ['admin', 'dosen']))
                    <form action="{{ route('teacher.students.index') }}" method="GET" id="class-selector-form">
                        <select name="class_id" onchange="this.form.submit()" class="bg-surface-container-low border-none rounded-full px-4 py-1 text-xs font-bold text-primary focus:ring-2 focus:ring-primary">
                            <option value="">Pilih Kelas...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ ($class?->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
            <p class="text-on-surface-variant italic">Daftar seluruh siswa di {{ $class->name }} &bull; {{ $class->school->name }}</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-6 rounded-[2.5rem] border border-outline-variant/30 shadow-sm">
        <form action="{{ route('teacher.students.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant material-symbols-outlined text-[20px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full h-12 pl-12 pr-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm"
                           placeholder="Cari nama siswa...">
                </div>
            </div>
            <button type="submit" class="h-12 px-8 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('teacher.students.index') }}" class="h-12 px-4 flex items-center text-error font-bold text-sm hover:underline">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Student List -->
    <section class="bg-white rounded-[2.5rem] shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-lowest text-on-surface-variant text-xs uppercase tracking-wider border-b border-outline-variant/30">
                        <th class="px-6 py-4 font-bold">Nama Siswa</th>
                        <th class="px-6 py-4 font-bold text-center">Total Poin</th>
                        <th class="px-6 py-4 font-bold text-center">Status Terakhir</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($students as $student)
                    <tr class="hover:bg-surface-container-lowest/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-container text-white flex items-center justify-center font-bold">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface text-sm">{{ $student->name }}</p>
                                    <p class="text-[10px] text-on-surface-variant">ID: #{{ $student->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">
                                <span class="material-symbols-outlined text-[16px]">stars</span>
                                {{ number_format($student->points) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-[10px] text-on-surface-variant italic">
                                Aktif {{ $student->updated_at->diffForHumans() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('teacher.student.detail', $student->id) }}" class="inline-flex items-center gap-2 bg-surface-container text-primary px-4 py-2 rounded-xl font-bold text-xs hover:bg-primary/10 transition-all">
                                <span>Detail Progres</span>
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-on-surface-variant italic">
                            Tidak ada siswa yang ditemukan.
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
    </section>
</div>
@endsection
