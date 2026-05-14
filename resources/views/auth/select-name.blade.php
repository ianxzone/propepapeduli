@extends('layouts.app')

@section('title', 'Pilih Nama - ProPePa PEDULI')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-start p-container-padding pt-12 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,#e2bfb9_1px,transparent_0)] bg-[size:32px_32px] opacity-40"></div>

    <main class="relative z-10 w-full max-w-md">
        <header class="text-center mb-8">
            <div class="inline-flex flex-col items-center gap-1 mb-6">
                <span class="px-4 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full border border-primary/20 uppercase tracking-widest">
                    {{ $class->school->name }}
                </span>
                <span class="text-on-surface-variant font-bold text-sm">{{ $class->name }}</span>
            </div>
            
            <h1 class="font-headline text-headline-lg text-primary">Siapa Namamu?</h1>
            <p class="text-body-md text-on-surface-variant mt-2">Pilih namamu dari daftar di bawah ini.</p>
        </header>

        <section class="grid grid-cols-1 gap-4">
            @foreach($students as $student)
                <form action="{{ route('student.select.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $student->id }}">
                    <button type="submit" 
                            class="w-full p-6 bg-white rounded-2xl shadow-sm border border-outline-variant flex items-center gap-4 hover:border-primary hover:bg-primary/5 transition-all text-left group">
                        <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-bold text-xl">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <span class="font-headline text-headline-md text-on-surface group-hover:text-primary">{{ $student->name }}</span>
                        <span class="material-symbols-outlined ml-auto text-outline group-hover:text-primary">chevron_right</span>
                    </button>
                </form>
            @endforeach
        </section>

        <footer class="mt-12 text-center">
            <a href="{{ route('login') }}" class="text-primary font-label hover:underline">
                <span class="material-symbols-outlined align-middle mr-1">arrow_back</span>
                Kembali ke Login
            </a>
        </footer>
        
        <x-institutional-footer />
    </main>
</div>
@endsection
