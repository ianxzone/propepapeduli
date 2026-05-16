@extends('layouts.auth')

@section('title', 'Login Guru - ProPePa PEDULI')

@section('card_content')
<form action="{{ route('teacher.login.submit') }}" method="POST" class="space-y-6">
    @csrf
    <div class="text-center">
        <h2 class="font-headline text-headline-md text-on-surface">Portal Guru</h2>
        <p class="text-body-md text-on-surface-variant mt-1">Otorisasi akses ke dashboard pendidik.</p>
    </div>

    @if($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-xl text-sm border border-error/20">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2 ml-1">Email / Username</label>
            <input type="text" name="email" required
                   class="w-full h-14 px-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md"
                   placeholder="Masukkan email Anda">
        </div>
        
        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2 ml-1">Kata Sandi</label>
            <input type="password" name="password" required
                   class="w-full h-14 px-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md"
                   placeholder="••••••••">
        </div>

        @if(\App\Models\Setting::get('enable_captcha', '0') == '1')
        <div class="space-y-3">
            <label class="block text-sm font-bold text-on-surface-variant mb-1 ml-1 text-center">Verifikasi Keamanan</label>
            <div class="flex flex-col items-center gap-3 p-4 bg-surface-container-lowest rounded-2xl border border-outline-variant/30">
                <div class="captcha-img-container flex items-center justify-center bg-white p-2 rounded-xl border border-outline-variant/50">
                    {!! captcha_img('flat') !!}
                </div>
                <button type="button" onclick="refreshCaptcha()" class="text-xs font-bold text-primary flex items-center gap-1 hover:underline">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                    Muat Ulang Kode
                </button>
            </div>
            <input type="text" name="captcha" required
                   class="w-full h-14 px-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md text-on-surface text-center tracking-widest"
                   placeholder="Ketik kode di atas">
        </div>
        @endif
    </div>

    <button type="submit" 
            class="w-full h-14 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-2 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] transition-all group">
        Masuk ke Portal
        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">login</span>
    </button>
</form>

<div class="mt-6 text-center">
    <a href="{{ route('login') }}" class="text-primary font-label hover:underline">Siswa? Masuk di sini</a>
</div>
@endsection

@push('scripts')
<script>
function refreshCaptcha() {
    const img = document.querySelector('.captcha-img-container img');
    if (img) {
        img.src = '{{ captcha_src("flat") }}' + '?' + Math.random();
    }
}
</script>
@endpush
