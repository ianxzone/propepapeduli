@extends('layouts.app')

@section('title', 'Masuk - ProPePa PEDULI')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-center p-container-padding overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,#e2bfb9_1px,transparent_0)] bg-[size:32px_32px] opacity-40"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-secondary-container/10 rounded-full blur-3xl"></div>

    <main class="relative z-10 w-full max-w-md">
        <!-- Identity Section -->
        <div class="flex flex-col items-center mb-10">
            <x-logo />
        </div>

        <!-- Login Card -->
        <section class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(87,0,0,0.08)] border border-outline-variant/30">
            <form action="{{ route('student.login.submit') }}" method="POST" class="space-y-8">
                @csrf
                <header class="text-center">
                    <h2 class="font-headline text-headline-md text-on-surface">ProPePa PEDULI</h2>
                    <p class="text-body-md text-on-surface-variant mt-1">Masukkan kode kelas untuk belajar.</p>
                </header>

                @if($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Input Group -->
                <div class="space-y-3">
                    <label class="font-label text-label-lg text-primary ml-1" for="class_code">Kode Kelas</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">key</span>
                        <input type="text" id="class_code" name="class_code" required
                               class="w-full h-16 pl-14 pr-4 bg-surface border-2 border-transparent focus:border-primary focus:ring-0 rounded-2xl text-2xl font-bold tracking-[0.2em] text-center text-primary placeholder:text-outline-variant placeholder:tracking-normal transition-all"
                               placeholder="Contoh: 5A-2024">
                    </div>
                </div>

                <!-- Action Button -->
                <button type="submit" 
                        class="w-full h-[56px] bg-primary text-white font-headline text-button-text rounded-2xl flex items-center justify-center gap-3 hover:bg-primary-container transition-colors shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000]">
                    <span>Masuk</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>
        </section>

        <x-institutional-footer />
    </main>
</div>
@endsection
