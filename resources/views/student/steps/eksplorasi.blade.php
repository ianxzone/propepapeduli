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
                        <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-soft border border-outline-variant/30 h-full flex flex-col group transition-all duration-500 hover:shadow-xl max-w-4xl mx-auto">
                            <!-- Compact Image Area -->
                            <div class="w-full h-48 md:h-64 relative bg-surface-container-high overflow-hidden shrink-0">
                                @if(!empty($p['image']))
                                    <img src="{{ $p['image'] }}" 
                                         alt="{{ $p['name'] ?? 'Perspektif' }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="flex flex-col items-center justify-center h-full gap-2 text-on-surface-variant/30">
                                        <span class="material-symbols-outlined text-4xl">person_search</span>
                                        <p class="text-[10px] font-bold uppercase tracking-widest">Gambar Belum Tersedia</p>
                                    </div>
                                @endif
                                
                                <!-- Decorative Badge -->
                                <div class="absolute top-4 left-4 z-10">
                                    <div class="bg-secondary/80 backdrop-blur-md text-white px-3 py-1.5 rounded-xl text-[10px] font-bold shadow-lg flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-xs">visibility</span>
                                        <span>Perspektif</span>
                                    </div>
                                </div>

                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-40"></div>
                            </div>
                            
                            <!-- Content Area -->
                            <div class="p-6 md:p-8 space-y-4 flex-1 flex flex-col">
                                <h2 class="font-headline text-headline-sm text-primary text-center">{{ $p['name'] ?? 'Tokoh Tanpa Nama' }}</h2>
                                
                                <div class="bg-surface-container-lowest p-6 rounded-3xl border border-outline-variant/10 relative flex-1 flex items-center justify-center shadow-inner min-h-[100px]">
                                    <span class="material-symbols-outlined text-primary/5 absolute top-2 left-2 text-6xl pointer-events-none">format_quote</span>
                                    <div class="prose prose-primary max-w-none text-body-md md:text-body-lg text-on-surface font-medium italic relative z-10 leading-relaxed text-center">
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
                    slidesPerView: 1.15,
                    centeredSlides: true,
                    spaceBetween: 16,
                    grabCursor: true,
                    loop: {{ count($perspectives) > 1 ? 'true' : 'false' }},
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true
                    },
                    navigation: {
                        nextEl: '.swiper-next',
                        prevEl: '.swiper-prev',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2.2,
                            centeredSlides: false,
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: 3,
                            centeredSlides: false,
                            spaceBetween: 24
                        }
                    }
                });
            });
        </script>
        @endpush
        @endif

        <!-- Action Button -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" id="next-form" class="space-y-6" novalidate>
            @csrf
            <input type="hidden" name="emotion" id="selected_emotion" value="">
            
            <!-- Emotion Interaction Section -->
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-soft space-y-6">
                <h3 class="font-headline text-label-lg text-primary text-center uppercase tracking-widest">Bagaimana perasaanmu?</h3>
                <div class="flex justify-between items-center px-2">
                    @foreach(['😢', '☹️', '😐', '🙂', '😄'] as $index => $emoji)
                        <button type="button" 
                                onclick="selectEmotion(this, '{{ $emoji }}')"
                                class="emotion-btn relative w-14 h-14 rounded-2xl bg-surface-container-low flex items-center justify-center text-3xl border border-outline-variant/30 hover:border-primary hover:bg-primary/5 transition-all active:scale-90">
                            {{ $emoji }}
                            <!-- Checkmark Badge -->
                            <span class="checkmark-badge hidden absolute -top-1.5 -right-1.5 bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center border-2 border-white text-[10px] font-black shadow-sm">
                                ✓
                            </span>
                        </button>
                    @endforeach
                </div>

                <!-- Dinamis feedback prompt -->
                <div id="emotion-feedback" class="text-center text-xs font-bold text-secondary hidden transition-all duration-300">
                    Kamu memilih: <span id="selected-emotion-display" class="text-xl"></span>. Klik emoji lain jika ingin mengubah.
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

        <!-- Script removed to be in push script stack -->
    </main>

    @push('scripts')
    <script>
        function selectEmotion(btn, emoji) {
            // Reset all buttons
            document.querySelectorAll('.emotion-btn').forEach(b => {
                b.classList.remove('ring-4', 'ring-primary/30', 'border-amber-500', 'bg-amber-400', 'text-white', 'animate-pop-bounce');
                b.classList.add('bg-surface-container-low', 'border-outline-variant/30');
                
                // Hide checkmark badge
                const checkmark = b.querySelector('.checkmark-badge');
                if (checkmark) checkmark.classList.add('hidden');
                
                // Reset emoji opacity
                b.style.filter = 'grayscale(100%) opacity(50%)';
            });
            
            // Mark selected button (Kuning solid terang / Amber & Bounce animation)
            btn.classList.add('ring-4', 'ring-primary/30', 'border-amber-500', 'bg-amber-400', 'text-white', 'animate-pop-bounce');
            btn.classList.remove('bg-surface-container-low', 'border-outline-variant/30');
            btn.style.filter = 'grayscale(0%) opacity(100%)';
            
            // Show checkmark badge
            const checkmark = btn.querySelector('.checkmark-badge');
            if (checkmark) checkmark.classList.remove('hidden');
            
            // Play Pop Sound
            playPopSound();
            
            // Update dynamic text prompt
            const feedbackContainer = document.getElementById('emotion-feedback');
            const displaySpan = document.getElementById('selected-emotion-display');
            if (feedbackContainer && displaySpan) {
                displaySpan.innerText = emoji;
                feedbackContainer.classList.remove('hidden');
            }
            
            // Update hidden input
            document.getElementById('selected_emotion').value = emoji;
        }

        // Initialize emojis to grayscale
        document.querySelectorAll('.emotion-btn').forEach(b => {
            b.style.filter = 'grayscale(100%) opacity(50%)';
        });

        // CHEERFUL SYNTH SOUND GENERATOR using Web Audio API
        function playPopSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                
                osc.type = 'sine';
                osc.frequency.setValueAtTime(350, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(1000, ctx.currentTime + 0.12);
                
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.12);
                
                osc.connect(gain);
                gain.connect(ctx.destination);
                
                osc.start();
                osc.stop(ctx.currentTime + 0.12);
            } catch (e) {
                console.warn('AudioContext not allowed or blocked:', e);
            }
        }

        // Form Validation
        document.getElementById('next-form').addEventListener('submit', function(e) {
            let isValid = true;
            const selectedEmotion = document.getElementById('selected_emotion').value;
            const contentTextarea = document.getElementById('eksplorasi-content');
            const confirmCheckbox = document.getElementById('confirm-explore');
            const emojiSection = document.querySelector('.emotion-btn').parentElement;
            
            // Remove existing error elements and styles
            document.querySelectorAll('.error-feedback-msg').forEach(el => el.remove());
            emojiSection.classList.remove('border-red-500', 'ring-4', 'ring-red-100', 'error-shake', 'border', 'rounded-2xl', 'p-2');
            contentTextarea.classList.remove('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
            confirmCheckbox.parentElement.classList.remove('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
            
            // Validate emoji choice
            if (!selectedEmotion) {
                isValid = false;
                emojiSection.classList.add('border-red-500', 'ring-4', 'ring-red-100', 'error-shake', 'border', 'rounded-2xl', 'p-2');
                
                const errMsg = document.createElement('p');
                errMsg.className = 'error-feedback-msg text-red-500 text-xs font-bold mt-2 text-center flex items-center justify-center gap-1';
                errMsg.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Silakan pilih salah satu emoji perasaanmu terlebih dahulu ya!';
                emojiSection.parentElement.appendChild(errMsg);
            }
            
            // Validate textarea
            if (!contentTextarea.value.trim()) {
                isValid = false;
                contentTextarea.classList.add('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
                
                const errMsg = document.createElement('p');
                errMsg.className = 'error-feedback-msg text-red-500 text-xs font-bold mt-2 flex items-center gap-1';
                errMsg.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Tuliskan deskripsi perasaanmu terlebih dahulu ya!';
                contentTextarea.parentElement.appendChild(errMsg);
            }
            
            // Validate checkbox
            if (!confirmCheckbox.checked) {
                isValid = false;
                confirmCheckbox.parentElement.classList.add('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
                
                const errMsg = document.createElement('p');
                errMsg.className = 'error-feedback-msg text-red-500 text-xs font-bold mt-2 flex items-center gap-1';
                errMsg.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Kamu harus mencentang kotak persetujuan eksplorasi!';
                confirmCheckbox.parentElement.parentElement.appendChild(errMsg);
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Friendly Alert Dialog
                Swal.fire({
                    title: 'Ada yang Terlewat! 🌟',
                    text: 'Silakan pilih emoji perasaanmu, tulis deskripsi perasaanmu, dan centang kotak persetujuan untuk melanjutkan.',
                    icon: 'warning',
                    confirmButtonText: 'Oke, Aku Lengkapi! 👍',
                    confirmButtonColor: '#570000',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                });
                
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    </script>
    @endpush

    <!-- Bottom Navigation Bar -->
    <x-student-nav active="modul" />
</div>
@endsection
