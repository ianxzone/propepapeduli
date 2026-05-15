@extends('layouts.admin')

@section('title', 'Backup Data - Admin ProPePa')
@section('header_title', 'Backup & Pemulihan Data')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-on-surface">Manajemen Backup</h2>
            <p class="text-sm text-on-surface-variant">Cadangkan database Anda secara rutin untuk keamanan data.</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.backups.create') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="db">
                <button type="submit" class="bg-surface-container-high text-on-surface px-6 py-3 rounded-2xl font-bold flex items-center gap-2 border border-outline-variant/30 hover:bg-surface-container-highest transition-all">
                    <span class="material-symbols-outlined">database</span>
                    Backup Database
                </button>
            </form>
            <form action="{{ route('admin.backups.create') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="full">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 shadow-soft hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined">folder_zip</span>
                    Backup Database & File
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Backup Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-primary/5 rounded-[2rem] p-8 border border-primary/10">
                <div class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-2xl">info</span>
                </div>
                <h3 class="font-headline text-xl font-bold text-on-surface mb-4">Informasi Backup</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        <p class="text-sm text-on-surface-variant"><strong>Backup Database</strong>: Hanya mencakup tabel dan data MySQL.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        <p class="text-sm text-on-surface-variant"><strong>Backup Database & File</strong>: Mencakup database dan semua file yang diunggah (gambar/PDF/dokumen).</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        <p class="text-sm text-on-surface-variant">File backup disimpan dalam format .sql atau .zip di server.</p>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Backup List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center gap-3">
                    <span class="material-symbols-outlined text-on-surface-variant">folder_zip</span>
                    <h3 class="font-bold text-on-surface">Riwayat Backup</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="px-6 py-4 font-bold text-xs text-on-surface uppercase tracking-wider">Nama File</th>
                                <th class="px-6 py-4 font-bold text-xs text-on-surface uppercase tracking-wider">Ukuran</th>
                                <th class="px-6 py-4 font-bold text-xs text-on-surface uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 font-bold text-xs text-on-surface uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20">
                            @forelse($backups as $backup)
                                <tr class="hover:bg-surface-container-lowest transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-secondary">description</span>
                                            <span class="text-sm font-medium text-on-surface">{{ $backup['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-on-surface-variant">
                                        {{ $backup['size'] }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-on-surface-variant">
                                        {{ $backup['date'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.backups.download', $backup['name']) }}" class="w-8 h-8 rounded-lg bg-secondary/10 text-secondary flex items-center justify-center hover:bg-secondary/20 transition-all" title="Download">
                                                <span class="material-symbols-outlined text-sm">download</span>
                                            </a>
                                            <form action="{{ route('admin.backups.delete', $backup['name']) }}" method="POST" onsubmit="return confirm('Hapus backup ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-error/10 text-error flex items-center justify-center hover:bg-error/20 transition-all" title="Hapus">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-4xl mb-2 opacity-20">cloud_off</span>
                                        <p>Belum ada file backup.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
