<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - ProPePa PEDULI')</title>
    
    @if(isset($site_settings['site_favicon']))
    <link rel="icon" type="image/x-icon" href="{{ asset($site_settings['site_favicon']) }}">
    @endif

    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="antialiased font-sans">
    <div class="relative min-h-screen flex flex-col items-center justify-center p-6 overflow-hidden @yield('bg_class', 'bg-surface')">
        <!-- Background Decor -->
        @section('background_decor')
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,#e2bfb9_1px,transparent_0)] bg-[size:32px_32px] opacity-40"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-secondary-container/10 rounded-full blur-3xl"></div>
        @show

        <main class="relative z-10 w-full max-w-md">
            <!-- Identity Section -->
            <div class="flex flex-col items-center mb-8">
                @section('logo')
                <x-logo />
                @show
            </div>

            <!-- Login Card / Selection Area -->
            @hasSection('card_content')
            <section class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-[0_20px_50px_rgba(87,0,0,0.1)] border border-outline-variant/30">
                @yield('card_content')
            </section>
            @else
                @yield('content')
            @endif

            <!-- Footer Section -->
            <div class="mt-8">
                <x-institutional-footer />
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>
