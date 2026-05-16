<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', ($site_settings['site_name'] ?? 'ProPePa LMS'))</title>
    
    <!-- Favicon -->
    @if(isset($site_settings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset($site_settings['site_favicon']) }}">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700;800&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body class="bg-surface font-sans text-on-surface min-h-screen antialiased">
    <div class="app-container">
        <div class="app-content">
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intercept standard confirm() in forms
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                const originalOnSubmit = form.getAttribute('onsubmit');
                if (originalOnSubmit && originalOnSubmit.includes('confirm')) {
                    // Extract message from confirm('...')
                    const match = originalOnSubmit.match(/confirm\(['"](.+)['"]\)/);
                    const message = match ? match[1] : 'Apakah Anda yakin?';
                    
                    form.removeAttribute('onsubmit');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#570000',
                            cancelButtonColor: '#CAC4D0',
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal',
                            borderRadius: '1.5rem',
                            customClass: {
                                popup: 'rounded-[2rem]',
                                confirmButton: 'rounded-xl px-6 py-3',
                                cancelButton: 'rounded-xl px-6 py-3'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
