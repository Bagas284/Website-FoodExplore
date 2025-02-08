<x-app-layout>
    <x-slot name="header">  
            {{ __('Daftar Warung') }}
    </x-slot>

    <div class="container" style="margin-top: 120px">
        <div class="d-flex justify-content-start mb-4">
            @auth
                @if (Auth::user()->hasRole('Admin'))
                    <!-- Admin selalu dapat menambah warung -->
                    <a href="{{ route('warung.add') }}" class="btn btn-success">Tambah Warung</a>
                @elseif (Auth::user()->hasRole('Warung'))
                    <!-- Cek jika pengguna sudah memiliki warung -->
                    @if (!Auth::user()->warung()->exists())
                        <a href="{{ route('warung.add') }}" class="btn btn-success">Tambah Warung</a>
                    @endif
                @endif
            @endauth
        </div>
        <div class="row">
            @foreach ($warung as $w)
                <div class="col-md-3 mb-4">
                    <div class="border rounded-4 bg-light shadow">
                        <!-- Gambar Warung -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $w->warung_id }}">
                            <img src="{{ asset('img/' . $w->image) }}" class="rounded-top-4 img-fluid"
                                style="height: 200px; width: 100%; object-fit: cover;" alt="{{ $w->nama_warung }}">
                        </a>
                        <!-- Informasi Warung -->
                        <div class="text-center">
                            <h5 class="fs-1">{{ $w->nama_warung }}</h5>
                            <p>Alamat: {{ $w->alamat }}</p>
                            <p>No. WA: {{ $w->no_wa }}</p>
                            <p>Status Pengantaran: {{ $w->status_pengantaran }}</p>
                            
                            @auth
                                @can('lihat menu')
                                    @if (auth()->user()->hasRole('User'))
                                        @if ($w->status_pengantaran === 'aktif')
                                            <a href="{{ route('warung.menu', $w->warung_id) }}" class="btn btn-warning mb-3">Menu</a>
                                        @endif
                                    @else
                                        <a href="{{ route('warung.menu', $w->warung_id) }}" class="btn btn-warning mb-3">Menu</a>
                                    @endif
                                @endcan
                        
                                @can('edit warung')
                                        <a href="{{ route('warung.edit', $w->warung_id) }}" class="btn btn-primary mb-3">Edit</a>
                                @endcan
                        
                                @can('hapus warung')
                                        <form action="{{ route('warung.destroy', $w->warung_id) }}" method="POST" style="display: inline-block;" id="deleteForm-{{ $w->warung_id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger mb-3" onclick="deleteWarung({{ $w->warung_id }})">Hapus</button>
                                        </form>
                                @endcan
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Modal untuk Gambar -->
                <div class="modal fade" id="imageModal-{{ $w->warung_id }}" tabindex="-1"
                    aria-labelledby="imageModalLabel-{{ $w->warung_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <img src="{{ asset('img/' . $w->image) }}" class="img-fluid" style="width: 100%;"
                                    alt="{{ $w->nama_warung }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteWarung(warungId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Warung ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + warungId).submit();
                }
            });
        }
    </script>
</x-app-layout>
