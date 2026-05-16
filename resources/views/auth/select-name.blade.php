@extends('layouts.auth')

@section('title', 'Pilih Nama - ProPePa PEDULI')

@section('logo')
<div class="inline-flex flex-col items-center gap-1 mb-2">
    <span class="px-4 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-full border border-primary/20 uppercase tracking-widest">
        {{ $class->school->name }}
    </span>
    <span class="text-on-surface-variant font-bold text-sm">{{ $class->name }}</span>
</div>
@endsection

@section('content')
<header class="text-center mb-8">
    <h1 class="font-headline text-headline-lg text-primary">Siapa Namamu?</h1>
    <p class="text-body-md text-on-surface-variant mt-2">Pilih namamu dari daftar di bawah ini.</p>
</header>

<section class="grid grid-cols-1 gap-4">
    @foreach($students as $student)
        <form action="{{ route('student.select.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $student->id }}">
            <button type="submit" 
                    class="w-full p-6 bg-white rounded-3xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:border-primary hover:bg-primary/5 transition-all text-left group">
                <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-bold text-xl">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <span class="font-headline text-headline-md text-on-surface group-hover:text-primary">{{ $student->name }}</span>
                <span class="material-symbols-outlined ml-auto text-outline group-hover:text-primary">chevron_right</span>
            </button>
        </form>
    @endforeach
</section>

<footer class="mt-8 text-center">
    <a href="{{ route('login') }}" class="text-primary font-label hover:underline flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Bukan kelas saya? Kembali
    </a>
</footer>
@endsection
