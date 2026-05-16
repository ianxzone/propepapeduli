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
        <section class="perspective-section -mx-container-padding overflow-hidden">
            <div class="swiper perspective-swiper px-container-padding overflow-visible">
                <div class="swiper-wrapper">
                    @foreach($perspectives as $p)
                    <div class="swiper-slide !h-auto">
                        <div class="bg-white rounded-[3rem] overflow-hidden shadow-soft border border-outline-variant/30 h-full flex flex-col group transition-all duration-500 hover:shadow-2xl">
                            <!-- Image Area with Premium Overlay -->
                            <div class="w-full aspect-[16/9] relative bg-surface-container-high overflow-hidden shrink-0">
                                @if(!empty($p['image']))
                                    <img src="{{ $p['image'] }}" 
                                         alt="{{ $p['name'] ?? 'Perspektif' }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="flex flex-col items-center justify-center h-full gap-2 text-on-surface-variant/30">
                                        <span class="material-symbols-outlined text-6xl">person_search</span>
                                        <p class="text-xs font-bold uppercase tracking-widest">Gambar Belum Tersedia</p>
                                    </div>
                                @endif
                                
                                <!-- Decorative Badge -->
                                <div class="absolute top-6 left-6 z-10">
                                    <div class="bg-secondary/90 backdrop-blur-md text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-lg flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                        <span>Kacamata Perspektif</span>
                                    </div>
                                </div>

                                <!-- Gradient Overlay for text readability -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                                
                                <!-- Name Overlay on Image -->
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h2 class="font-headline text-headline-sm text-white drop-shadow-md">{{ $p['name'] ?? 'Tokoh Tanpa Nama' }}</h2>
                                </div>
                            </div>
                            
                            <!-- Content Area -->
                            <div class="p-8 space-y-6 flex-1 flex flex-col">
                                <div class="bg-surface-container-lowest p-8 rounded-[2rem] border border-outline-variant/20 relative flex-1 flex items-center justify-center shadow-inner">
                                    <span class="material-symbols-outlined text-primary/10 absolute -top-2 -left-2 text-8xl pointer-events-none">format_quote</span>
                                    <div class="prose prose-primary max-w-none text-body-lg text-on-surface font-medium italic relative z-10 leading-relaxed text-center">
                                        {!! $p['text'] ?? 'Materi belum diisi.' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if(count($perspectives) > 1)
                <!-- Custom Navigation -->
                <div class="flex items-center justify-center gap-6 mt-12 mb-4">
                    <button class="swiper-prev w-14 h-14 rounded-2xl bg-white border border-outline-variant/30 shadow-sm flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all active:scale-95 group">
                        <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    </button>
                    <div class="swiper-pagination !static !w-auto"></div>
                    <button class="swiper-next w-14 h-14 rounded-2xl bg-white border border-outline-variant/30 shadow-sm flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all active:scale-95 group">
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </div>
                @endif
            </div>
        </section>

        @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <style>
            .perspective-swiper .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
                background: #e5e7eb;
                opacity: 1;
                transition: all 0.3s ease;
            }
            .perspective-swiper .swiper-pagination-bullet-active {
                width: 32px;
                border-radius: 5px;
                background: var(--md-sys-color-primary, #570000);
            }
            .perspective-swiper {
                padding-bottom: 2rem !important;
            }
        </style>
        @endpush

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                new Swiper('.perspective-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: {{ count($perspectives) > 1 ? 'true' : 'false' }},
                    centeredSlides: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-next',
                        prevEl: '.swiper-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 1.1, spaceBetween: 24 },
                        1024: { slidesPerView: 1.2, spaceBetween: 32 }
                    }
                });
            });
        </script>
        @endpush
        @endif

        <!-- Action Button -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" id="next-form" class="space-y-6">
            @csrf
            <input type="hidden" name="emotion" id="selected_emotion" value="">
            
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

                <div class="pt-4 border-t border-outline-variant/20">
                    <label for="eksplorasi-content" class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-3">Deskripsikan perasaanmu tentang perspektif di atas:</label>
                    <textarea id="eksplorasi-content" name="content" rows="4" required
                              class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-2xl p-4 text-sm focus:border-primary focus:ring-0 transition-all"
                              placeholder="Apa yang kamu rasakan setelah melihat kacamata orang lain?"></textarea>
                </div>
            </section>

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

    <!-- Bottom Navigation Bar -->
    <x-student-nav active="modul" />
</div>
@endsection
