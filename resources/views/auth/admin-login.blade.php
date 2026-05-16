@extends('layouts.auth')

@section('title', 'Admin Otorisasi - ProPePa PEDULI')
@section('bg_class', 'bg-[#1e1e1e]')

@section('background_decor')
<div class="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,#333_1px,transparent_0)] bg-[size:32px_32px] opacity-20"></div>
<div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-fixed/5 rounded-full blur-3xl"></div>
@endsection

@section('card_content')
<form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
    @csrf
    <div class="text-center">
        <h2 class="font-headline text-headline-md text-on-surface">Otorisasi Admin</h2>
        <p class="text-body-md text-on-surface-variant mt-1">Sistem perlindungan akses tingkat tinggi.</p>
    </div>

    @if($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-xl text-sm border border-error/20">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-2 ml-1">Kredensial</label>
            <input type="text" name="email" required
                   class="w-full h-14 px-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md"
                   placeholder="Username / Email">
        </div>
        
        <div>
            <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-2 ml-1">Sandi Lewat</label>
            <input type="password" name="password" required
                   class="w-full h-14 px-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md"
                   placeholder="••••••••">
        </div>

        <div class="space-y-3">
            <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1 ml-1 text-center">Verifikasi Manusia</label>
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
    </div>

    <button type="submit" 
            class="w-full h-14 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-2 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] transition-all group hover:bg-primary-container">
        Buka Akses
        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">login</span>
    </button>
</form>
@endsection

@push('scripts')
<script>
function refreshCaptcha() {
    const container = document.querySelector('.captcha-img-container');
    fetch('/captcha/api/flat')
        .then(response => response.json())
        .then(data => {
            container.innerHTML = data.img;
        });
}
</script>
@endpush
