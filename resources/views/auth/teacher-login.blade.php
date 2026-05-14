@extends('layouts.app')

@section('title', 'Portal Guru - ProPePa PEDULI')

@section('content')
<div class="min-h-[100dvh] flex flex-col justify-between p-container-padding relative overflow-hidden bg-surface-container-lowest">
    <!-- Abstract Background Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[20%] right-[-10%] w-80 h-80 bg-secondary-container/10 rounded-full blur-3xl"></div>

    <main class="relative z-10 w-full max-w-md mx-auto pt-10">
        <!-- Identity Section -->
        <div class="flex flex-col items-center mb-10">
            <x-logo />
            <h1 class="font-headline text-headline-lg text-primary tracking-tight mt-4 text-center">ProPePa PEDULI</h1>
            <p class="font-label text-label-lg text-on-surface-variant mt-2 uppercase tracking-widest">Portal Guru</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-outline-variant/50">
            <form action="{{ route('teacher.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                @if($errors->any())
                <div class="bg-error-container text-on-error-container p-4 rounded-xl text-sm font-bold">
                    {{ $errors->first() }}
                </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block font-label text-sm text-on-surface mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant material-symbols-outlined">email</span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full h-14 pl-12 pr-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md text-on-surface"
                                   placeholder="Contoh: guru@propepa.id">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block font-label text-sm text-on-surface mb-2">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant material-symbols-outlined">lock</span>
                            <input type="password" id="password" name="password" required
                                   class="w-full h-14 pl-12 pr-4 bg-surface-container-low border border-outline-variant rounded-2xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md text-on-surface"
                                   placeholder="Masukkan kata sandi">
                        </div>
                    </div>
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
        </div>
    </main>

    <!-- Footer Identity -->
    <x-institutional-footer />
</div>
@endsection
