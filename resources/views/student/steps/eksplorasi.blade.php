@extends('layouts.app')

@section('title', 'Eksplorasi - ' . $module->title)

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
        <div class="text-center space-y-2">
            <h1 class="font-headline text-headline-md text-primary">Fase 2: Eksplorasi (E)</h1>
            <p class="text-body-md text-on-surface-variant">Gunakan kacamata perspektifmu! Bagaimana perasaan mereka tentang isu ini?</p>
        </div>

        <!-- Perspectives Section -->
        @php
            $perspectives = $module->content['E']['perspectives'] ?? [];
        @endphp

        @if(count($perspectives) > 0)
        <section class="swiper perspective-swiper overflow-visible">
            <div class="swiper-wrapper">
                @foreach($perspectives as $p)
                <div class="swiper-slide">
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-soft border border-outline-variant/30 h-full flex flex-col">
                        <!-- Image Area -->
                        <div class="w-full h-64 relative bg-surface-container-high flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($p['image']))
                                <img src="{{ $p['image'] }}" 
                                     alt="{{ $p['name'] ?? 'Perspektif' }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center gap-2 text-on-surface-variant/30">
                                    <span class="material-symbols-outlined text-6xl">person_search</span>
                                    <p class="text-xs font-bold uppercase tracking-widest">Gambar Belum Tersedia</p>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-secondary text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg">
                                Perspektif
                            </div>
                        </div>
                        
                        <!-- Content Area -->
                        <div class="p-8 text-center space-y-6 flex-1 flex flex-col justify-center">
                            <h2 class="font-headline text-headline-md text-primary">{{ $p['name'] ?? 'Tokoh Tanpa Nama' }}</h2>
                            <div class="bg-surface-container-low p-6 rounded-3xl relative min-h-[120px] flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary/10 absolute top-2 left-2 text-6xl">format_quote</span>
                                <div class="prose prose-primary max-w-none text-body-lg text-on-surface font-medium italic relative z-10 leading-relaxed">
                                    {!! $p['text'] ?? 'Materi belum diisi.' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if(count($perspectives) > 1)
            <!-- Custom Pagination -->
            <div class="swiper-pagination !-bottom-8"></div>
            <!-- Navigation Arrows -->
            <div class="swiper-button-next !text-primary !-right-4 md:!-right-12"></div>
            <div class="swiper-button-prev !text-primary !-left-4 md:!-left-12"></div>
            @endif
        </section>

        @push('scripts')
        <script>
            new Swiper('.perspective-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 1 },
                    1024: { slidesPerView: 1 }
                }
            });
        </script>
        @endpush
        @endif

        <!-- Emotion Interaction Section -->
        <section class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-soft space-y-6">
            <h3 class="font-headline text-label-lg text-primary text-center uppercase tracking-widest">Bagaimana perasaanmu?</h3>
            <div class="flex justify-between items-center px-2">
                @foreach(['😢', '☹️', '😐', '🙂', '😄'] as $index => $emoji)
                    <button type="button" 
                            onclick="selectEmotion(this, '{{ $emoji }}')"
                            class="emotion-btn w-14 h-14 rounded-2xl bg-surface-container-low flex items-center justify-center text-3xl border border-outline-variant/30 hover:border-primary hover:bg-primary/5 transition-all active:scale-90">
                        {{ $emoji }}
                    </button>
                @endforeach
            </div>
        </section>

        <!-- Action Button -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" id="next-form" class="space-y-6">
            @csrf
            <input type="hidden" name="emotion" id="selected_emotion" value="">
            
            <div class="flex items-center gap-3 bg-white p-4 rounded-2xl border border-outline-variant/30 shadow-sm">
                <input type="checkbox" id="confirm-explore" required class="w-6 h-6 rounded-lg text-primary focus:ring-primary border-outline-variant/50">
                <label for="confirm-explore" class="text-sm font-bold text-on-surface select-none cursor-pointer">
                    Saya telah mengeksplorasi berbagai perspektif di atas.
                </label>
            </div>

            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Lanjut ke Diskusi</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>

        <script>
            document.getElementById('next-form').addEventListener('submit', function(e) {
                if (!document.getElementById('selected_emotion').value) {
                    e.preventDefault();
                    alert('Silakan pilih salah satu emoji perasaanmu terlebih dahulu!');
                }
            });
        </script>
    </main>

    @push('scripts')
    <script>
        function selectEmotion(btn, emoji) {
            // Reset all buttons
            document.querySelectorAll('.emotion-btn').forEach(b => {
                b.classList.remove('ring-4', 'ring-primary/30', 'border-primary', 'scale-110', 'bg-primary/10');
                b.classList.add('bg-surface-container-low', 'border-outline-variant/30');
                // Reset emoji opacity
                b.style.filter = 'grayscale(100%) opacity(50%)';
            });
            
            // Mark selected button
            btn.classList.add('ring-4', 'ring-primary/30', 'border-primary', 'scale-110', 'bg-primary/10');
            btn.classList.remove('bg-surface-container-low', 'border-outline-variant/30');
            btn.style.filter = 'grayscale(0%) opacity(100%)';
            
            // Update hidden input
            document.getElementById('selected_emotion').value = emoji;
        }

        // Initialize emojis to grayscale
        document.querySelectorAll('.emotion-btn').forEach(b => {
            b.style.filter = 'grayscale(100%) opacity(50%)';
        });
    </script>
    @endpush

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-lg border-t border-outline-variant/30 px-6 py-3 flex justify-between items-center z-50">
        <a href="{{ route('student.dashboard') }}" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">menu_book</span>
            <span class="text-[10px] font-bold">Modul</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">forum</span>
            <span class="text-[10px] font-bold">Diskusi</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">edit_square</span>
            <span class="text-[10px] font-bold">Jurnal</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </nav>
</div>
@endsection
