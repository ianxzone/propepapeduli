@extends('layouts.app')

@section('title', 'Lakukan - ' . $module->title)

@section('content')
<div class="pb-24">
    <!-- Top Header -->
    <header class="bg-white px-container-padding py-4 shadow-sm flex items-center justify-between sticky top-0 z-50">
        <x-logo variant="pill" />
        
        <div class="flex items-center gap-3">
            <div class="bg-secondary-container/10 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-secondary-container/20">
                <span class="material-symbols-outlined text-secondary text-lg" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="font-headline text-secondary font-bold">{{ Auth::user()->points }}</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold border-2 border-white shadow-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </header>

    <main class="px-container-padding pt-6 space-y-8">
        <!-- Step Indicator & Title -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-xl">rocket_launch</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Fase 5: Lakukan (L)</span>
            </div>
            <h1 class="font-headline text-headline-lg text-on-surface leading-tight">Waktunya Beraksi!</h1>
            <p class="text-body-md text-on-surface-variant">
                {{ $module->content['L']['task'] ?? 'Pilih aksi nyata yang akan kamu lakukan untuk membantu menjaga lingkungan.' }}
            </p>
        </div>

        <!-- Action Options -->
        <section class="space-y-4">
            @php
                $actions = [
                    ['palette', 'Kampanye Poster', 'Membuat poster ajakan menjaga sungai di mading kelas.'],
                    ['record_voice_over', 'Lapor Pak RT', 'Melaporkan jika melihat sampah menumpuk di pinggir sungai.'],
                    ['delete_outline', 'Pungut Sampah', 'Mengajak teman memungut sampah plastik di sekitar selokan.'],
                ];
            @endphp

            @foreach($actions as $index => $action)
                <div onclick="selectAction('{{ $action[1] }}', this)" 
                     class="action-card bg-white p-6 rounded-[2rem] border border-outline-variant/30 shadow-soft flex items-start gap-5 relative overflow-hidden group cursor-pointer transition-all hover:shadow-lg">
                    <div class="absolute top-0 left-0 w-2 h-full bg-secondary-container transition-all" id="indicator-{{ $index }}"></div>
                    <div class="w-14 h-14 bg-secondary-container/10 text-secondary rounded-2xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-3xl">{{ $action[0] }}</span>
                    </div>
                    <div class="flex-1 space-y-3">
                        <div>
                            <h3 class="font-headline text-on-surface font-bold text-lg">{{ $action[1] }}</h3>
                            <p class="text-sm text-on-surface-variant">{{ $action[2] }}</p>
                        </div>
                        <div class="action-btn w-full py-3 bg-surface-container-low text-primary font-bold rounded-xl border border-outline-variant/30 text-center transition-all group-hover:bg-primary group-hover:text-white">
                            Pilih Aksi
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        <!-- Final Action -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" id="action-form">
            @csrf
            <input type="hidden" name="content" id="selected-action" value="">
            <button type="submit" id="submit-btn" disabled
                    class="w-full h-20 bg-outline text-white rounded-3xl font-headline text-headline-md flex items-center justify-center gap-4 shadow-[0_6px_0_0_#49454f] active:translate-y-[2px] active:shadow-[0_4px_0_0_#49454f] transition-all mt-8 opacity-50 cursor-not-allowed">
                <span>Saya Berkomitmen!</span>
                <span class="material-symbols-outlined text-3xl">celebration</span>
            </button>
        </form>
    </main>

    @push('scripts')
    <script>
        function selectAction(actionName, element) {
            // Set input value
            document.getElementById('selected-action').value = "Aksi yang dipilih: " + actionName;
            
            // UI feedback: Reset all cards
            document.querySelectorAll('.action-card').forEach(card => {
                card.classList.remove('border-primary', 'bg-primary/5', 'ring-2', 'ring-primary');
                card.querySelector('.action-btn').innerHTML = 'Pilih Aksi';
                card.querySelector('.action-btn').classList.remove('bg-primary', 'text-white');
                card.querySelector('.action-btn').classList.add('bg-surface-container-low', 'text-primary');
            });
            
            // UI feedback: Highlight selected card
            element.classList.add('border-primary', 'bg-primary/5', 'ring-2', 'ring-primary');
            element.querySelector('.action-btn').innerHTML = '<span class="material-symbols-outlined align-middle mr-1">check_circle</span> Terpilih';
            element.querySelector('.action-btn').classList.remove('bg-surface-container-low', 'text-primary');
            element.querySelector('.action-btn').classList.add('bg-primary', 'text-white');
            
            // Enable submit button
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-outline', 'opacity-50', 'cursor-not-allowed', 'shadow-[0_6px_0_0_#49454f]');
            submitBtn.classList.add('bg-primary', 'shadow-[0_6px_0_0_#410000]');
        }
    </script>
    @endpush

    <!-- Bottom Nav -->
    <x-student-nav active="modul" />
</div>
@endsection
