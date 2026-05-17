@extends('layouts.app')

@section('title', 'Pelajari - ' . $module->title)

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
                <span class="material-symbols-outlined text-xl">menu_book</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Fase 1: Pelajari (P)</span>
            </div>
            <h1 class="font-headline text-headline-lg text-on-surface leading-tight">{{ $module->title }}</h1>
            
            <p class="text-body-md text-on-surface-variant">Tonton video atau pelajari materi di bawah ini untuk memahami topik ini.</p>
        </div>

        @php
            $videoUrl = $module->content['P']['video_url'] ?? '';
            $videoId = '';
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match)) {
                $videoId = $match[1];
            }
        @endphp

        <!-- Video Player Section -->
        @if($videoId)
        <section>
            <div class="relative w-full rounded-3xl overflow-hidden shadow-lg bg-black aspect-video border-4 border-white">
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            
            @if(!empty($module->content['P']['text']))
            <div class="mt-4 space-y-3">
                <div class="flex items-center gap-3 bg-surface-container-low p-4 rounded-2xl border border-outline-variant/30">
                    <div class="w-10 h-10 bg-secondary-container/20 rounded-full flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-xl">lightbulb</span>
                    </div>
                    <div class="text-sm text-on-surface font-medium italic line-clamp-2">
                        {{ strip_tags($module->content['P']['text']) }}
                    </div>
                </div>
            </div>
            @endif
        </section>
        @endif

        <!-- Image Story Section (Cerita Bergambar) -->
        @php
            $storyImages = array_filter(array_map('trim', explode("\n", $module->content['P']['story_images'] ?? '')));
        @endphp

        @if(count($storyImages) > 0)
        <section class="space-y-4">
            <div class="flex items-center gap-2 text-secondary">
                <span class="material-symbols-outlined text-xl">auto_stories</span>
                <h2 class="font-headline text-headline-sm font-bold">Cerita Bergambar</h2>
            </div>
            <div class="swiper story-swiper rounded-3xl border-4 border-white shadow-lg overflow-hidden bg-surface-container-low">
                <div class="swiper-wrapper">
                    @foreach($storyImages as $img)
                    <div class="swiper-slide">
                        <img src="{{ $img }}" class="w-full aspect-[4/3] object-cover" alt="Cerita Bergambar">
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next !text-white !w-10 !h-10 bg-black/20 backdrop-blur-md rounded-full after:!text-sm"></div>
                <div class="swiper-button-prev !text-white !w-10 !h-10 bg-black/20 backdrop-blur-md rounded-full after:!text-sm"></div>
            </div>
        </section>
        @endif

        <!-- Factual Data & Materials -->
        @if(!empty($module->content['P']['text']) || !empty($module->content['P']['file_url']))
        <section class="space-y-4">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-xl">fact_check</span>
                <h2 class="font-headline text-headline-sm font-bold">Data Faktual & Materi</h2>
            </div>
            
            <div class="bg-white p-6 rounded-[2rem] border border-outline-variant/30 shadow-sm space-y-4">
                @if(!empty($module->content['P']['text']))
                <div class="prose prose-primary max-w-none text-on-surface-variant leading-relaxed
                            prose-headings:font-headline prose-headings:text-on-surface
                            prose-p:text-sm prose-li:text-sm prose-strong:text-primary">
                    {!! $module->content['P']['text'] !!}
                </div>
                @endif

                @if(!empty($module->content['P']['file_url']))
                <div class="space-y-3">
                    @php
                        $isPdf = str_ends_with(strtolower($module->content['P']['file_url']), '.pdf');
                    @endphp

                    @if($isPdf)
                    <div class="relative w-full aspect-[3/4] md:aspect-video rounded-3xl overflow-hidden border border-outline-variant/30 shadow-sm bg-surface-container-low group">
                        <embed src="{{ $module->content['P']['file_url'] }}" type="application/pdf" class="w-full h-full">
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center pointer-events-none group-has-[:blocked]:flex">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant/30 mb-2">find_in_page</span>
                            <p class="text-xs text-on-surface-variant font-medium">Jika PDF tidak muncul, silakan klik tombol unduh di bawah.</p>
                        </div>
                    </div>
                    @endif

                    <a href="{{ $module->content['P']['file_url'] }}" target="_blank" 
                       class="flex items-center justify-between bg-secondary-container/10 p-4 rounded-2xl border border-secondary-container/20 group hover:bg-secondary transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-secondary/10 group-hover:bg-white/20 rounded-xl flex items-center justify-center text-secondary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-xl">file_download</span>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-on-surface group-hover:text-white transition-colors">
                                    {{ $isPdf ? 'Buka / Unduh PDF' : 'Unduh Dokumen Lengkap' }}
                                </span>
                                <span class="block text-[10px] text-on-surface-variant group-hover:text-white/80 uppercase font-bold">PDF / Materi Pendukung</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-secondary group-hover:text-white transition-colors">download</span>
                    </a>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- Action Button -->
        <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" class="space-y-6">
            @csrf
            
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/30 shadow-soft space-y-4">
                <label for="pelajari-content" class="block font-headline text-headline-sm text-primary">Apa yang kamu pelajari dari materi di atas?</label>
                <textarea id="pelajari-content" name="content" rows="3" required
                          class="w-full bg-surface-container-low border border-outline-variant/50 rounded-2xl p-4 text-sm focus:border-primary focus:ring-0 transition-all"
                          placeholder="Tuliskan poin penting yang kamu dapatkan..."></textarea>
            </section>

            @if(!empty($module->content['P']['teacher_instruction']))
            <div class="bg-primary/5 p-4.5 rounded-2xl border border-primary/10 flex gap-3.5 shadow-sm">
                <span class="material-symbols-outlined text-primary text-xl">record_voice_over</span>
                <div class="space-y-1">
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-primary">Instruksi Guru:</span>
                    <div class="prose prose-sm prose-primary max-w-none text-on-surface leading-relaxed font-medium">
                        {!! $module->content['P']['teacher_instruction'] !!}
                    </div>
                </div>
            </div>
            @endif

            <div class="flex items-center gap-3 bg-white p-4 rounded-2xl border border-outline-variant/30 shadow-sm">
                <input type="checkbox" id="confirm-learn" required class="w-6 h-6 rounded-lg text-primary focus:ring-primary border-outline-variant/50">
                <label for="confirm-learn" class="text-sm font-bold text-on-surface select-none cursor-pointer">
                    Saya telah mempelajari materi di atas dengan seksama.
                </label>
            </div>

            <button type="submit" 
                    class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                <span>Lanjut ke Eksplorasi</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>
    </main>

    <!-- Bottom Navigation Bar -->
    <x-student-nav active="modul" />
</div>
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .story-swiper .swiper-pagination-bullet-active {
        background: white !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.story-swiper', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
@endpush
@endsection
