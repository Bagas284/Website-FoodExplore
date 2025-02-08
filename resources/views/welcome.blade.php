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
        <link href="https://fonts.googleapis.com/css2?family=Lobster+Two&family=Squada+One&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <style>
            .f-selamatDatang {
                font-family: "Lobster Two", sans-serif;
                font-weight: 400;
                font-style: normal;
                margin-bottom: -13px;
            }

            .f-temukan {
                font-family: "Squada One", sans-serif;
                font-weight: 400;
                font-style: normal;
                margin-bottom: -3px; 
            }

            .bg-shape {
                clip-path: polygon(0 0, 80% 0, 60% 100%, 0% 100%);
                height: 100vh;
            }

            @media (max-width: 795px) {
                .bg-shape {
                    clip-path: none;
                    height: 65vh;
                    width: 100%;
                    align-items : center;
                }
            }
        </style>

        <!-- Animasi -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    </head>

    <body>
        <div class="container-fluid">     
            <video class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" autoplay loop muted style="filter: brightness(0.4);">
                <source src="img/bg-2.mp4" type="video/mp4">
            </video>    
        
            <div class="row position-relative z-1">
                <div class="col-10 bg-merahtua bg-opacity-75 bg-shape d-flex flex-column justify-content-center">
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center">
                        <div class="text-center">
                            <p class="f-selamatDatang fs-2 text-warning animate__animated animate__zoomIn">
                                Selamat Datang
                            </p>

                            <p class="f-temukan text-white display-5 animate__animated animate__fadeIn animate__delay-1s">
                                Temukan makanan yang anda inginkan
                            </p>

                            <p class="text-white-50 animate__animated animate__fadeIn animate__delay-2s">
                                Terdapat berbagai macam informasi yang tersedia di dalamnya
                            </p>
                        </div>

                    @guest
                        <div class="animate__animated animate__pulse animate__slow animate__infinite">
                            <a href="{{ route('login') }}" class="btn btn-outline-warning btn-md me-3" aria-label="Login">Login</a>
        
                            <a href="{{ route('register') }}" class="btn btn-warning btn-md" aria-label="Register">Register</a>
                        </div>
                    </div>

                    @else
                    <div class="animate__animated animate__pulse animate__slow animate__infinite">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-warning btn-md me-3 w-100" aria-label="Login">Masuk</a>
                        </div>
                    @endguest

                </div>
            </div>
        </div>
    </body>
</html>
