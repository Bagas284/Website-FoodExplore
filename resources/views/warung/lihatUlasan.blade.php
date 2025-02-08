<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Warung</title>
    
    <!-- Link CSS Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
<div class="position-relative">
    <div class="ms-3 mt-4">
        <a type="button" class="btn-close" aria-label="Close" href="{{ route('warung.menu', $warung->warung_id) }}"></a>
    </div>
</div>

<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-merahtua text-white">
            <h2 class="card-title text-center">Ulasan untuk {{ $warung->nama_warung }}</h2>
        </div>
        <div class="card-body">
            @if ($warung->ulasan->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Belum ada ulasan untuk warung ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>Rating</th>
                                <th>Komentar</th>
                                <th>Tanggal</th>
                                @if(Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('User')))
                                    <th>Hapus</th>
                                @else
                                    <th>Hapus</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warung->ulasan as $ulasan)
                                <tr>
                                    <td>{{ $ulasan->user->name }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $ulasan->rating }} / 5</span>
                                    </td>
                                    <td>{{ $ulasan->komentar }}</td>
                                    <td>{{ $ulasan->created_at->format('d-m-Y H:i') }}</td>
                                    @if(Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('User') || Auth::user()->hasRole('Warung')))
                                        <td>
                                            @if(Auth::id() === $ulasan->user_id || Auth::user()->hasRole('Admin'))
                                                <form id="delete-form-{{ $ulasan->ulasan_id }}" 
                                                      action="{{ route('warung.ulasan.hapus', ['warung' => $warung->warung_id, 'ulasan' => $ulasan->ulasan_id]) }}" 
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="confirmDelete({{ $ulasan->ulasan_id }})">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Script JS Bootstrap 5.3 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(ulasanId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Ulasan yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + ulasanId).submit();
        }
    });
}

// SweetAlert untuk pesan sukses
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

// SweetAlert untuk pesan error
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif
</script>

</body>
</html>