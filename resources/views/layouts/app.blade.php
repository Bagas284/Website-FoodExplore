<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>
        <link rel="shortcut icon" type="image/png/jpg" href="img/logo_FoodExplore.png">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

        <!-- Animasi -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <style>
            body {
                padding-top: 150px; /* Sesuaikan dengan tinggi header */
            }

        </style>
       
    </head>
    <body class="d-flex flex-column min-vh-100">
        <div class="flex-grow-1">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="display-4 text-center fixed-top bg-light border-bottom" style="margin-top: 130px; z-index:100">
                    <div class="p-4 container">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pt-4">
                {{ $slot }}
            </main>
        </div>
        @unless(request()->is('dashboard')) {{-- Ganti 'dashboard' dengan route yang sesuai --}}
            @include('layouts.footer')
        @endunless
        
    </body>
</html>
