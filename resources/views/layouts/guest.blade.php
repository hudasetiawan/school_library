<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' . config('app.name', 'Perpustakaan') : config('app.name', 'Perpustakaan') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;500;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-foreground antialiased bg-background">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-background">
            <div data-animate="fade-in-up">
                <a href="/" class="flex flex-col items-center gap-2 mb-6 group">
                    <div class="p-3 bg-card rounded-2xl shadow-sm border border-border group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/logo.webp') }}" alt="Logo Perpustakaan" class="h-12 w-auto">
                    </div>
                    <div class="text-center">
                        <h1 class="text-lg font-bold text-foreground tracking-tight leading-tight uppercase">Perpustakaan</h1>
                        <span class="text-muted-foreground font-normal text-xs block -mt-1">SMKN 2 Magelang</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-card shadow-xl overflow-hidden sm:rounded-[2.5rem] border border-border relative" data-animate="fade-in-up">
                <!-- Decorative top border -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary to-blue-500"></div>
                
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-xs text-muted-foreground font-medium">
                &copy; {{ date('Y') }} SMKN 2 Magelang. <br>All rights reserved.
            </div>
        </div>
    </body>
</html>
