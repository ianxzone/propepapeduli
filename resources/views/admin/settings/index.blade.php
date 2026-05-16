@extends('layouts.admin')

@section('title', 'Pengaturan Sistem - ProPePa')
@section('header_title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-on-surface">Pengaturan Sistem</h2>
            <p class="text-sm text-on-surface-variant">Kelola konfigurasi platform dan keamanan.</p>
        </div>
        <a href="{{ route('admin.setup.wizard') }}" class="flex items-center gap-2 bg-secondary text-white px-6 py-3 rounded-2xl font-bold shadow-soft hover:bg-secondary/90 transition-all">
            <span class="material-symbols-outlined">magic_button</span>
            Setup Wizard
        </a>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    <div>
                        <label class="block font-bold text-sm text-on-surface mb-2">Logo Aplikasi</label>
                        <div class="flex items-center gap-4 bg-surface-container-lowest p-4 rounded-xl border border-outline-variant/50">
                            @if(\App\Models\Setting::get('site_logo'))
                                <img src="{{ asset(\App\Models\Setting::get('site_logo')) }}" alt="Logo" class="h-12 w-auto object-contain bg-white rounded-lg p-1 border">
                            @endif
                            <input type="file" name="site_logo" accept="image/*" class="text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-sm text-on-surface mb-2">Favicon (PNG/ICO)</label>
                        <div class="flex items-center gap-4 bg-surface-container-lowest p-4 rounded-xl border border-outline-variant/50">
                            @if(\App\Models\Setting::get('site_favicon'))
                                <img src="{{ asset(\App\Models\Setting::get('site_favicon')) }}" alt="Favicon" class="w-8 h-8 object-contain bg-white rounded-lg p-1 border">
                            @endif
                            <input type="file" name="site_favicon" accept="image/*" class="text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                        </div>
                    </div>
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

        <!-- Security Settings -->
        <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-error/10 flex items-center justify-center text-error">
                    <span class="material-symbols-outlined">security</span>
                </div>
                <div>
                    <h2 class="font-headline text-headline-sm text-on-surface">Keamanan & Proteksi</h2>
                    <p class="text-xs text-on-surface-variant">Atur proteksi login dan header keamanan.</p>
                </div>
            </div>
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-2xl border border-outline-variant/20">
                    <div>
                        <h4 class="font-bold text-sm text-on-surface">Rate Limiting (Anti Brute-force)</h4>
                        <p class="text-[10px] text-on-surface-variant">Batasi percobaan login yang salah untuk mencegah peretasan.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_rate_limiting" value="1" {{ \App\Models\Setting::get('enable_rate_limiting', '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-2xl border border-outline-variant/20">
                    <div>
                        <h4 class="font-bold text-sm text-on-surface">Header Keamanan (CSP, XSS, Frame)</h4>
                        <p class="text-[10px] text-on-surface-variant">Aktifkan header proteksi tambahan pada browser pengunjung.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_security_headers" value="1" {{ \App\Models\Setting::get('enable_security_headers', '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-2xl border border-outline-variant/20">
                    <div>
                        <h4 class="font-bold text-sm text-on-surface">Verifikasi CAPTCHA Login</h4>
                        <p class="text-[10px] text-on-surface-variant">Tambahkan verifikasi kode visual pada halaman login admin dan guru.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enable_captcha" value="1" {{ \App\Models\Setting::get('enable_captcha', '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>

                <div>
                    <label class="block font-bold text-sm text-on-surface mb-2">Maksimal Percobaan Login</label>
                    <input type="number" name="max_login_attempts" value="{{ \App\Models\Setting::get('max_login_attempts', '5') }}" 
                           class="w-full max-w-[200px] rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-0 px-4 py-3 bg-surface-container-lowest">
                    <p class="text-[10px] text-on-surface-variant mt-2 italic">Jumlah kesalahan login sebelum akun dikunci sementara.</p>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-on-surface-variant/10 flex items-center justify-center text-on-surface-variant">
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
