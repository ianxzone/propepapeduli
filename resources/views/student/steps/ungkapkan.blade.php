@extends('layouts.app')

@section('title', 'Ungkapkan - ' . $module->title)

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
        <!-- Validation Errors -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm font-bold animate-in fade-in slide-in-from-top-2">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Step Indicator & Title -->
        <div class="text-center space-y-4">
            <div class="inline-block bg-primary text-white rounded-full px-4 py-1 font-label text-[10px] uppercase tracking-widest font-bold shadow-md">
                Fase 4: Ungkapkan (U)
            </div>
            
            @if(!empty($module->content['U']['teacher_instruction']))
            <div class="bg-primary/5 p-4 rounded-2xl border border-primary/10 flex gap-3 text-left">
                <span class="material-symbols-outlined text-primary">record_voice_over</span>
                <div class="prose prose-sm prose-primary max-w-none text-on-surface leading-relaxed">
                    {!! $module->content['U']['teacher_instruction'] !!}
                </div>
            </div>
            @endif

            <h1 class="font-headline text-headline-lg text-primary">Jurnal Empati Digital</h1>
            <p class="text-body-md text-on-surface-variant">
                {{ $module->content['U']['task'] ?? 'Bagaimana perasaanmu setelah mempelajari isu ini? Ungkapkan dalam jurnalmu!' }}
            </p>
        </div>

        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Emotional Selection -->
            <section class="space-y-4">
                <h2 class="font-headline text-on-surface font-bold">Pilih Perasaanmu:</h2>
                <div class="flex overflow-x-auto no-scrollbar gap-4 pb-4 -mx-container-padding px-container-padding">
                    @php
                        $emotions = [
                            ['😊', 'Senang'], ['🤔', 'Peduli'], ['😢', 'Sedih'], 
                            ['😟', 'Khawatir'], ['😠', 'Marah'], ['💪', 'Semangat']
                        ];
                    @endphp
                    @foreach($emotions as $emotion)
                        <label class="flex-shrink-0 cursor-pointer">
                            <input type="radio" name="emotion" value="{{ $emotion[1] }}" class="hidden peer" required>
                            <div class="w-24 h-28 bg-white rounded-3xl shadow-sm border-2 border-transparent peer-checked:border-primary peer-checked:bg-primary/5 flex flex-col items-center justify-center gap-2 transition-all">
                                <span class="text-4xl">{{ $emotion[0] }}</span>
                                <span class="text-xs font-bold text-on-surface-variant peer-checked:text-primary">{{ $emotion[1] }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </section>

            <!-- Writing Area (Book Style) -->
            <section class="bg-white rounded-[2.5rem] shadow-soft border border-outline-variant/30 p-8 relative overflow-hidden">
                <!-- Binding effect left side -->
                <div class="absolute left-0 top-0 bottom-0 w-4 bg-gradient-to-r from-surface-variant/20 to-transparent"></div>
                
                <div class="space-y-4">
                    <textarea name="content" required
                              class="w-full min-h-[250px] bg-transparent border-none resize-none focus:ring-0 text-body-lg text-on-surface p-0 leading-[32px] placeholder:text-outline-variant" 
                              placeholder="Mulai menulis jurnalmu di sini..."
                              style="background-image: repeating-linear-gradient(transparent, transparent 31px, #e2bfb9 32px); background-attachment: local;"></textarea>
                    
                    <div class="flex flex-col items-center gap-3 pt-4">
                        <div id="waveform" class="flex items-end justify-center gap-1 h-8 mb-2 hidden">
                            <div class="w-1 bg-primary rounded-full animate-bounce h-4" style="animation-duration: 0.5s"></div>
                            <div class="w-1 bg-primary rounded-full animate-bounce h-6" style="animation-duration: 0.7s"></div>
                            <div class="w-1 bg-primary rounded-full animate-bounce h-3" style="animation-duration: 0.4s"></div>
                            <div class="w-1 bg-primary rounded-full animate-bounce h-7" style="animation-duration: 0.6s"></div>
                            <div class="w-1 bg-primary rounded-full animate-bounce h-4" style="animation-duration: 0.5s"></div>
                        </div>
                        <button type="button" id="mic-btn" class="flex items-center gap-3 bg-surface-container-low text-primary px-8 py-4 rounded-full border-2 border-outline-variant/30 active:scale-95 transition-all relative overflow-hidden group shadow-sm">
                            <div id="mic-pulse" class="absolute inset-0 bg-primary/10 scale-0 rounded-full transition-transform duration-500"></div>
                            <span class="material-symbols-outlined text-2xl relative z-10" id="mic-icon" style="font-variation-settings: 'FILL' 1;">mic</span>
                            <span class="text-sm font-bold relative z-10" id="mic-text">Dikte Suara</span>
                        </button>
                        <p id="mic-status" class="text-[10px] text-on-surface-variant font-bold tracking-wider uppercase hidden">Sedang mendengarkan...</p>
                    </div>
                </div>
            </section>

            <!-- Action Button -->
            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Simpan & Lanjut ke Lakukan</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const micBtn = document.getElementById('mic-btn');
            const micIcon = document.getElementById('mic-icon');
            const micText = document.getElementById('mic-text');
            const micStatus = document.getElementById('mic-status');
            const micPulse = document.getElementById('mic-pulse');
            const textarea = document.querySelector('textarea[name="content"]');

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            
            if (!SpeechRecognition) {
                micBtn.style.display = 'none';
                return;
            }

            const recognition = new SpeechRecognition();
            recognition.lang = 'id-ID';
            recognition.continuous = true;
            recognition.interimResults = true;

            let isRecording = false;
            let finalTranscript = '';

            recognition.onstart = function() {
                isRecording = true;
                micIcon.innerText = 'graphic_eq';
                micText.innerText = 'Berhenti';
                micStatus.classList.remove('hidden');
                document.getElementById('waveform').classList.remove('hidden');
                micPulse.classList.add('scale-150', 'animate-pulse');
                micBtn.classList.add('border-primary', 'bg-primary/10');
                
                // Keep track of current text before starting
                finalTranscript = textarea.value;
            };

            recognition.onresult = function(event) {
                let interimTranscript = '';
                for (let i = event.resultIndex; i < event.results.length; ++i) {
                    if (event.results[i].isFinal) {
                        finalTranscript += (finalTranscript && !finalTranscript.endsWith(' ') ? ' ' : '') + event.results[i][0].transcript;
                    } else {
                        interimTranscript += event.results[i][0].transcript;
                    }
                }
                
                textarea.value = finalTranscript + (interimTranscript ? (finalTranscript ? ' ' : '') + interimTranscript : '');
                
                // Scroll to bottom
                textarea.scrollTop = textarea.scrollHeight;
            };

            recognition.onend = function() {
                isRecording = false;
                micIcon.innerText = 'mic';
                micText.innerText = 'Dikte Suara';
                micStatus.classList.add('hidden');
                document.getElementById('waveform').classList.add('hidden');
                micPulse.classList.remove('scale-150', 'animate-pulse');
                micBtn.classList.remove('border-primary', 'bg-primary/10');
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
                let message = 'Terjadi kesalahan pada pengenalan suara.';
                
                if(event.error === 'not-allowed') {
                    message = 'Izin mikrofon ditolak. Silakan aktifkan izin mikrofon di pengaturan browser Anda untuk menggunakan fitur ini.';
                } else if(event.error === 'network') {
                    message = 'Koneksi internet bermasalah. Rekam suara memerlukan internet aktif.';
                } else if(event.error === 'no-speech') {
                    message = 'Tidak ada suara terdeteksi. Silakan coba lagi.';
                }
                
                alert(message);
                recognition.stop();
            };

            micBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!isRecording) {
                    try {
                        recognition.start();
                    } catch (err) {
                        console.error('Recognition start error:', err);
                    }
                } else {
                    recognition.stop();
                }
            });
        });
    </script>
    @endpush

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-lg border-t border-outline-variant/30 px-6 py-3 flex justify-between items-center z-50">
        <a href="{{ route('student.dashboard') }}" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">menu_book</span>
            <span class="text-[10px] font-bold">Modul</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">forum</span>
            <span class="text-[10px] font-bold">Diskusi</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">edit_square</span>
            <span class="text-[10px] font-bold">Jurnal</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </nav>
</div>
@endsection
