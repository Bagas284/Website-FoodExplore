<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penilaian dan Ulasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .star-rating {
            direction: rtl;
            display: inline-block;
            padding: 20px;
        }
        
        .star-rating input[type="radio"] {
            display: none;
        }
        
        .star-rating label {
            color: #bbb;
            font-size: 2rem;
            padding: 0;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input[type="radio"]:checked ~ label {
            color: #f2b600;
        }
    </style>
</head>
<body class="bg-light">
    <div class="position-relative">
        <div class="ms-3 mt-4">
            <a type="button" class="btn-close" aria-label="Close" href="{{ route('warung.menu', $warung->warung_id) }}"></a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-merahtua text-white">
                        <h4 class="m-3 text-center">Form Penilaian dan Ulasan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ulasan.store', $warung->warung_id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Rating</label>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5" required>
                                    <label for="star5" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2" class="bi bi-star-fill"></label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1" class="bi bi-star-fill"></label>
                                </div>
                            </div>
                        
                            <div class="mb-4">
                                <label for="ulasan" class="form-label">Ulasan</label>
                                <textarea class="form-control" id="ulasan" name="komentar" rows="4" required></textarea>
                            </div>
                        
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-merahtua">Kirim Ulasan</button>
                            </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>