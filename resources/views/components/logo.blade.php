@props(['variant' => 'default'])

@php
    $site_logo = $site_settings['site_logo'] ?? null;
    $has_custom_logo = !empty($site_logo) && !str_contains($site_logo, 'googleusercontent');
    
    $logo = $site_logo ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCNPPLLCXI_weBqrbq0jVwVfujoLheHHc-JGI7oQFPRdxrRL8NS-vCO2kBp-VxNO5mcYfHrn6wl3cjPQE38WMsKx581Gzw3WWPCtIR2JxQlGfLLDjs4pu29DmMM8SKx4by8kX74VEb2iUzYMeqBdtDedT-yQ_GhxHAM-AcbjtiKZ8UBGQMl-ya5cHUuYwOGK0JjXJF6laJC3KNQ_uU-u7lAf2d9_5ZhmNXWqBf7Wzq9MeTB7V5nOYXiYv6EjSUOdcpcvIRnOmZ5dY3O';
    $name = $site_settings['site_name'] ?? 'ProPePa';
    $description = $site_settings['site_description'] ?? 'Profil Pelajar Pancasila';
@endphp

@if($has_custom_logo)
    {{-- Jika user upload logo sendiri, tampilkan gambarnya saja secara proporsional --}}
    <div class="flex items-center">
        <img src="{{ $logo }}" alt="{{ $name }}" 
             class="{{ $variant === 'pill' ? 'h-10 md:h-12' : 'h-16 md:h-20' }} w-auto object-contain rounded-lg">
    </div>
@else
    {{-- Jika menggunakan logo default --}}
    @if($variant === 'pill')
        <div class="flex items-center">
            <div class="flex items-center bg-primary rounded-full pr-6 pl-1 py-1 shadow-sm border border-primary/20">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center p-1.5 shadow-inner">
                    <img src="{{ $logo }}" alt="{{ $name }}" class="w-full h-auto brightness-0 saturate-100 invert-[25%] sepia-[100%] saturate-[5000%] hue-rotate-[350deg] brightness-[40%] contrast-[110%]">
                </div>
                <div class="ml-3 flex flex-col justify-center leading-none">
                    <span class="font-headline text-white font-extrabold text-lg tracking-wider uppercase">{{ $name }}</span>
                    <span class="text-white/80 text-[7px] font-bold tracking-widest uppercase mt-0.5">{{ $description }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 flex items-center justify-center">
                 <img src="{{ $logo }}" alt="{{ $name }}" class="w-full h-auto brightness-0 saturate-100 invert-[15%] sepia-[95%] saturate-[6932%] hue-rotate-[358deg] brightness-[35%] contrast-[107%]">
            </div>
            <div class="flex flex-col justify-center">
                <h1 class="font-headline text-primary font-extrabold text-3xl tracking-tight leading-none uppercase">{{ $name }}</h1>
                <p class="text-primary font-bold text-[10px] tracking-[0.15em] uppercase mt-1">{{ $description }}</p>
            </div>
        </div>
    @endif
@endif
