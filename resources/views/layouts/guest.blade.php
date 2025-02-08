<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="shortcut icon" type="image/png/jpg" href="img/logo_FoodExplore.png">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
    </head>
    <body>
        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row bg-light border rounded-5 p-2 shadow-lg my-5" style="max-width: 800px; width: 90%">
                <div class="position-relative">
                    <div class="position-absolute mt-3">
                        <a type="button" class="btn-close" aria-label="Close" href="{{ route('home') }}"></a>
                    </div>
                </div>
                
                {{ $header}}
                
                <div class="col-md-6">
                    <div id="carouselExampleFade" id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner mb-3">
                            <div class="carousel-item active">
                                <img src="img/gambar1.jpg" class="d-block w-100 img-fluid rounded-5">
                            </div>

                            <div class="carousel-item">
                                <img src="img/gambar2.jpg" class="d-block w-100 img-fluid rounded-5" alt="...">
                            </div>

                            <div class="carousel-item">
                                <img src="img/gambar3.jpg" class="d-block w-100 img-fluid rounded-5" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>