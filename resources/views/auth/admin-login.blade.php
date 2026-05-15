@extends('layouts.app')

@section('title', 'Admin Login - ProPePa PEDULI')

@section('content')
<div class="min-h-[100dvh] flex flex-col justify-between p-container-padding relative overflow-hidden bg-[#1e1e1e] text-white">
    <!-- Abstract Background Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[20%] right-[-10%] w-80 h-80 bg-secondary-container/10 rounded-full blur-3xl"></div>

    <main class="relative z-10 w-full max-w-md mx-auto pt-10">
        <!-- Identity Section -->
        <div class="flex flex-col items-center mb-10">
            <!-- Modified Logo for Admin (Dark mode compatible) -->
            <div class="bg-white/10 p-4 rounded-3xl backdrop-blur-md mb-4 border border-white/10">
                <span class="material-symbols-outlined text-5xl text-primary-fixed" style="font-variation-settings: 'FILL' 1;">shield_person</span>
            </div>
            <p class="font-label text-label-lg text-surface-variant mt-2 uppercase tracking-widest">Admin Control Panel</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/5 backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-white/10">
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                @if($errors->any())
                <div class="bg-error/20 border border-error/50 text-error-container p-4 rounded-xl text-sm font-bold">
                    {{ $errors->first() }}
                </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block font-label text-sm text-surface-variant mb-2">Email Administrator</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-surface-variant material-symbols-outlined">email</span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full h-14 pl-12 pr-4 bg-black/20 border border-white/10 rounded-2xl focus:border-primary-fixed focus:ring-2 focus:ring-primary-fixed/20 transition-all font-body-md text-white placeholder:text-white/30"
                                   placeholder="admin@propepa.id">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block font-label text-sm text-surface-variant mb-2">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-surface-variant material-symbols-outlined">lock</span>
                            <input type="password" id="password" name="password" required
                                   class="w-full h-14 pl-12 pr-4 bg-black/20 border border-white/10 rounded-2xl focus:border-primary-fixed focus:ring-2 focus:ring-primary-fixed/20 transition-all font-body-md text-white placeholder:text-white/30"
                                   placeholder="Masukkan kata sandi">
                        </div>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full h-14 bg-primary-fixed text-on-primary-fixed rounded-2xl font-headline text-button-text flex items-center justify-center gap-2 shadow-[0_4px_0_0_rgba(255,255,255,0.2)] active:translate-y-[2px] active:shadow-[0_2px_0_0_rgba(255,255,255,0.2)] transition-all group hover:bg-white">
                    Otorisasi Akses
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">login</span>
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full text-center py-6 text-xs text-surface-variant font-body">
        &copy; {{ date('Y') }} MurniBadi Teknologi. All rights reserved.
    </footer>
</div>
@endsection
