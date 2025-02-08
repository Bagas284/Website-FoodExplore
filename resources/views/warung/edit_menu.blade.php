<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Edit Menu - {{ $warung->nama_warung }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('menu.update', ['warung' => $warung->warung_id, 'menu' => $menu->menu_id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_menu" class="form-label">Nama Menu</label>
                        <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" 
                               id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}">
                        @error('nama_menu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                               id="harga" name="harga" value="{{ old('harga', $menu->harga) }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ketersediaan" class="form-label">Ketersediaan</label>
                        <select class="form-select @error('ketersediaan') is-invalid @enderror" 
                                id="ketersediaan" name="ketersediaan">
                            <option value="tersedia" {{ $menu->ketersediaan == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="habis" {{ $menu->ketersediaan == 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                        @error('ketersediaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('warung.menu', $warung->warung_id) }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </form>
               
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
