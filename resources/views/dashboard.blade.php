<x-app-layout>
    <style>
        .f-selamatDatang {
                font-family: "Lobster Two", sans-serif;
                font-weight: 400;
                font-style: normal;
                margin-bottom: 0.1rem;
            }
    </style>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-7 d-flex flex-column justify-content-center text-center">
                <h1 class="f-selamatDatang display-1 animate__animated animate__zoomIn">Selamat Datang</h1>
                <p class="fs-5 animate__animated animate__fadeIn animate__delay-1s">Temukan warung makan terbaik di sekitar dengan mudah dan cepat</p>
                <div class="animate__animated animate__pulse animate__slow animate__infinite">
                    <a href="{{ route('warung.index') }}" class="btn btn-outline-warning btn-md mb-5 mt-3">Temukan!!!</a>
                </div>
            </div>

            <div class="col-md d-flex justify-content-center align-items-center animate__animated animate__fadeIn animate">
                <img src="img/makanan-dashboard.png" class="img-fluid">
            </div>
        </div>
    </div>
</x-app-layout>
