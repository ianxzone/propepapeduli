@extends('layouts.admin')

@section('title', 'Pengaturan Sistem - ProPePa')
@section('header_title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Branding Settings -->
        <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">branding_watermark</span>
                </div>
                <div>
                    <h2 class="font-headline text-headline-sm text-on-surface">Branding & Identitas</h2>
                    <p class="text-xs text-on-surface-variant">Atur nama aplikasi dan tampilan dasar.</p>
                </div>
            </div>
            <div class="p-8 space-y-6">
                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Nama Aplikasi</label>
                    <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name') }}" 
                           class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                </div>
                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Deskripsi Aplikasi</label>
                    <textarea name="site_description" rows="3" 
                              class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">{{ \App\Models\Setting::get('site_description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Localization Settings -->
        <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">language</span>
                </div>
                <div>
                    <h2 class="font-headline text-headline-sm text-on-surface">Lokalisasi</h2>
                    <p class="text-xs text-on-surface-variant">Atur zona waktu dan bahasa sistem.</p>
                </div>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Zona Waktu</label>
                    <select name="timezone" class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                        <option value="Asia/Jakarta" {{ \App\Models\Setting::get('timezone') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                        <option value="Asia/Makassar" {{ \App\Models\Setting::get('timezone') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                        <option value="Asia/Jayapura" {{ \App\Models\Setting::get('timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Bahasa Sistem</label>
                    <select name="locale" class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                        <option value="id" {{ \App\Models\Setting::get('locale') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="en" {{ \App\Models\Setting::get('locale') == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-error/10 flex items-center justify-center text-error">
                    <span class="material-symbols-outlined">contact_support</span>
                </div>
                <div>
                    <h2 class="font-headline text-headline-sm text-on-surface">Kontak & Bantuan</h2>
                    <p class="text-xs text-on-surface-variant">Email admin untuk bantuan sistem.</p>
                </div>
            </div>
            <div class="p-8">
                <label class="block font-bold text-sm text-on-surface mb-2">Email Admin</label>
                <input type="email" name="contact_email" value="{{ \App\Models\Setting::get('contact_email') }}" 
                       class="w-full rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-primary text-white font-bold px-10 py-4 rounded-2xl shadow-soft hover:bg-primary/90 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
