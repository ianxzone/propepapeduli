@extends('layouts.app')

@section('title', 'Evaluasi Akhir - ' . $module->title)

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
        <!-- Header -->
        <section class="text-center space-y-4">
            <div class="inline-flex items-center justify-center bg-blue-500/10 text-blue-600 px-5 py-2 rounded-full shadow-sm border border-blue-500/10">
                <span class="material-symbols-outlined mr-2 text-xl" style="font-variation-settings: 'FILL' 1;">assignment</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Evaluasi Akhir: Soal Essay</span>
            </div>
            
            @if(!empty($module->content['essay']['teacher_instruction']))
            <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 flex gap-3 text-left">
                <span class="material-symbols-outlined text-blue-600">record_voice_over</span>
                <div class="prose prose-sm prose-primary max-w-none text-on-surface leading-relaxed italic">
                    {!! $module->content['essay']['teacher_instruction'] !!}
                </div>
            </div>
            @endif

            <h1 class="font-headline text-headline-lg text-primary leading-tight">Tuangkan Pemikiranmu</h1>
            <p class="text-body-md text-on-surface-variant px-4">Jawablah pertanyaan di bawah ini dengan sungguh-sungguh berdasarkan apa yang telah kamu pelajari.</p>
        </section>

        <!-- Essay Question Card -->
        <section class="space-y-6">
            @php
                $dimensions = [
                    [
                        'id' => 'emotional', 
                        'label' => 'Kesadaran Emosional', 
                        'icon' => 'mood', 
                        'color' => 'bg-amber-100 text-amber-700', 
                        'placeholder' => $module->content['essay']['question_emotional'] ?? 'Apa yang kamu rasakan mengenai isu ini?'
                    ],
                    [
                        'id' => 'perspective', 
                        'label' => 'Pengambilan Perspektif', 
                        'icon' => 'visibility', 
                        'color' => 'bg-blue-100 text-blue-700', 
                        'placeholder' => $module->content['essay']['question_perspective'] ?? 'Bagaimana sudut pandang orang lain yang terlibat?'
                    ],
                    [
                        'id' => 'care', 
                        'label' => 'Kepedulian Empatik', 
                        'icon' => 'favorite', 
                        'color' => 'bg-pink-100 text-pink-700', 
                        'placeholder' => $module->content['essay']['question_care'] ?? 'Apa bentuk kepedulian yang muncul dalam dirimu?'
                    ],
                    [
                        'id' => 'responsibility', 
                        'label' => 'Tanggung Jawab Empatik', 
                        'icon' => 'task_alt', 
                        'color' => 'bg-green-100 text-green-700', 
                        'placeholder' => $module->content['essay']['question_responsibility'] ?? 'Apa tanggung jawab yang akan kamu ambil?'
                    ],
                ];
            @endphp

            @foreach($dimensions as $dim)
            <div class="bg-white p-8 rounded-[2rem] border-2 border-outline-variant/30 shadow-soft space-y-4 relative overflow-hidden">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl {{ $dim['color'] }} flex items-center justify-center shrink-0 shadow-sm">
                        <span class="material-symbols-outlined text-2xl">{{ $dim['icon'] }}</span>
                    </div>
                    <h3 class="font-headline text-headline-sm text-on-surface font-bold">{{ $dim['label'] }}</h3>
                </div>
                
                <!-- Question Text -->
                <div class="bg-surface-container-low/50 p-6 rounded-2xl border border-outline-variant/20">
                    <div class="prose prose-sm prose-primary max-w-none text-on-surface leading-relaxed italic">
                        {!! $dim['placeholder'] !!}
                    </div>
                </div>

                <!-- Answer Area -->
                <div class="bg-white rounded-2xl border-2 border-outline-variant/30 focus-within:border-primary transition-all">
                    <textarea name="essay_{{ $dim['id'] }}" rows="4" required form="final-essay-form"
                              class="w-full bg-transparent border-none focus:ring-0 p-5 text-body-md text-on-surface placeholder:text-outline-variant/50" 
                              placeholder="Tuliskan jawabanmu di sini..."></textarea>
                </div>
            </div>
            @endforeach
        </section>

        <!-- Final CTA -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" id="final-essay-form" novalidate>
            @csrf
            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Selesaikan Modul & Simpan</span>
                <span class="material-symbols-outlined">check_circle</span>
            </button>
        </form>
    </main>

    <!-- Bottom Navigation Bar -->
    <x-student-nav active="modul" />
</div>

@push('scripts')
<script>
    document.getElementById('final-essay-form').addEventListener('submit', function(e) {
        let isValid = true;
        const dimensions = ['emotional', 'perspective', 'care', 'responsibility'];
        
        // Remove existing error elements and styles
        document.querySelectorAll('.error-feedback-msg').forEach(el => el.remove());
        
        dimensions.forEach(dimId => {
            const textarea = document.querySelector(`textarea[name="essay_${dimId}"]`);
            if (textarea) {
                const container = textarea.parentElement;
                container.classList.remove('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
                
                if (!textarea.value.trim()) {
                    isValid = false;
                    container.classList.add('border-red-500', 'ring-4', 'ring-red-100', 'error-shake');
                    
                    const errMsg = document.createElement('p');
                    errMsg.className = 'error-feedback-msg text-red-500 text-xs font-bold mt-2 flex items-center gap-1';
                    errMsg.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> Jawaban ini tidak boleh kosong ya!';
                    container.parentElement.appendChild(errMsg);
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Ada Jawaban yang Kosong! 🌟',
                text: 'Yuk, jawab seluruh pertanyaan evaluasi akhir terlebih dahulu sebelum menyimpan hasil belajarmu!',
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
@endsection
