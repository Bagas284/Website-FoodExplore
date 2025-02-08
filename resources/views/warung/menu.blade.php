<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css"/>
    <style>
        .modal-body img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .counter-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .counter-display {
            min-width: 40px;
            text-align: center;
            font-weight: bold;
        }

        .btn-counter {
            padding: 0px 8px;
            font-size: 14px;
        }

        #address {
            resize: none;
            height: auto;
            overflow-y: hidden;
            line-height: 1.5;
            max-height: 1.5em;
            padding: 6px;
        }

        #map {
            width: 100%;
            height: 200px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 20px;
        }

        .leaflet-popup-content {
            margin: 8px;
            line-height: 1.4;
        }

        .leaflet-popup-content b {
            color: #333;
            display: block;
            margin-bottom: 4px;
        }

    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div>
        <!-- Tombol Close -->
        <a 
            type="button" 
            class="btn-close" 
            style="filter: invert(100%) sepia(100%); position: fixed; top: 24px; left: 16px; z-index: 1050;" 
            aria-label="Close" 
            href="{{ route('warung.index') }}">
        </a>

        <!-- Header -->
        <h2 
            class="mb-2 text-center text-light bg-merahtua fs-1 p-4 fixed-top" 
            style="box-shadow: 2px 2px 5px rgba(0,0,0,0.3); z-index: 1040;">
            Warung {{ $warung->nama_warung }}
        </h2>
    </div>  

    <div class="container" style="margin-top:130px">
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
        @endif

        <div class="row">
            <!-- Sidebar Kiri -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('img/' . $warung->image) }}" class="card-img-top img-fluid"
                        alt="{{ $warung->nama_warung }}">
                    <div class="card-body">
                        @auth
                            @can('tambah ulasan')
                                @php
                                    $hasReviewed = App\Models\Ulasan::where('warung_id', $warung->warung_id)
                                        ->where('user_id', Auth::id())
                                        ->exists();
                                @endphp

                                @if (!$hasReviewed)
                                    <a href="{{ route('ulasan.index', ['warung_id' => $warung->warung_id]) }}"
                                        class="btn btn-success w-100 mb-2">Berikan Penilaian</a>
                                @endif
                            @endcan

                            @can('lihat ulasan')
                                <a href="{{ route('ulasan.lihatUlasan', ['warung_id' => $warung->warung_id]) }}"
                                    class="btn btn-success w-100">Lihat Ulasan</a>
                            @endcan
                        @endauth
                    </div>
                </div>
                <div class="card-body">
                    <div id="map"></div>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-8">
                @auth
                    @can('tambah menu')
                        <a href="{{ route('menu.create', ['warung_id' => $warung->warung_id]) }}"
                            class="btn btn-primary mb-3">Tambah Menu</a>
                    @endcan
                @endauth

                <table class="table table-striped table-hover" id="myTable">
                    <thead>
                        <tr>
                            @auth
                                @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('User'))
                                    <th scope="col">Pilih</th>
                                    <th scope="col">Jumlah</th>
                                @endif
                            @endauth
                            <th scope="col">Makanan & Minuman</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Ketersediaan</th>
                            @auth
                                @if (auth()->user()->can('edit menu') || auth()->user()->can('hapus menu'))
                                    <th scope="col">Edit & Hapus</th>
                                @endif
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($warung->menu as $menu)
                            <tr>
                                @auth
                                    @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('User'))
                                        <td>
                                            @if ($menu->ketersediaan !== 'habis')
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input menu-checkbox"
                                                        value="{{ $menu->menu_id }}" data-menu-name="{{ $menu->nama_menu }}"
                                                        data-menu-price="{{ $menu->harga }}"
                                                        id="menuCheck{{ $loop->index }}"
                                                        onchange="toggleCounter({{ $loop->index }})">
                                                </div>
                                            @else
                                                <span class="text-danger">Tidak tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($menu->ketersediaan !== 'habis')
                                                <div class="counter-container" id="counter{{ $loop->index }}"
                                                    style="display: none;">
                                                    <button type="button" class="btn btn-danger btn-counter"
                                                        onclick="decrease({{ $loop->index }})">-</button>
                                                    <div class="counter-display" id="count{{ $loop->index }}">0</div>
                                                    <input type="hidden" id="quantity{{ $loop->index }}" value="0">
                                                    <button type="button" class="btn btn-success btn-counter"
                                                        onclick="increase({{ $loop->index }})">+</button>
                                                </div>
                                            @else
                                                <span class="text-danger">Tidak tersedia</span>
                                            @endif
                                        </td>
                                    @endif
                                @endauth
                                <td>{{ $menu->nama_menu }}</td>
                                <td>Rp{{ number_format($menu->harga, 2, ',', '.') }}</td>
                                <td>{{ $menu->ketersediaan }}</td>
                                @auth
                                    @if (auth()->user()->can('edit menu') || auth()->user()->can('hapus menu'))
                                        <td>
                                            <div class="btn-group" role="group">
                                                @can('edit menu')
                                                    <a href="{{ route('menu.edit', ['warung' => $warung->warung_id, 'menu' => $menu->menu_id]) }}"
                                                        class="btn btn-warning btn-sm me-2">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                @endcan

                                                @can('hapus menu')
                                                    <form id="delete-form-{{ $menu->menu_id }}"
                                                        action="{{ route('menu.destroy', ['warung' => $warung->warung_id, 'menu' => $menu->menu_id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete({{ $menu->menu_id }})">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @auth
                    @if (Auth::user()->hasRole('User') || Auth::user()->hasRole('Admin'))
                        <div class="card mt-4">
                            <div class="card-body">
                                <form id="orderForm" onsubmit="sendWhatsAppMessage(event)">
                                    @csrf
                                    <input type="hidden" id="warungPhone" value="{{ $warung->no_wa }}">
                                    <input type="hidden" id="selectedMenus" name="selectedMenus">
                                    <input type="hidden" id="menuQuantities" name="menuQuantities">

                                    <div class="row align-items-end">
                                        <div class="col-md-8">
                                            <label for="address" class="form-label"><b>Alamat:</b></label>
                                            <textarea id="address" class="form-control" rows="1" placeholder="Masukkan alamat Anda"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Form hanya untuk submit -->
    <form id="orderForm" onsubmit="sendWhatsAppMessage(event)">
        @csrf
        <input type="hidden" id="warungPhone" value="{{ $warung->no_wa }}">
        <input type="hidden" id="selectedMenus" name="selectedMenus">
        <input type="hidden" id="menuQuantities" name="menuQuantities">

        <!-- Alamat dan Tombol WhatsApp -->

    </form>


    <!-- Modal -->
    <div class="modal fade" id="imageModal-{{ $warung->warung_id }}" tabindex="-1"
        aria-labelledby="imageModalLabel-{{ $warung->warung_id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="{{ asset('img/' . $warung->image) }}" class="img-fluid"
                        alt="{{ $warung->nama_warung }}">
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(menuId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Menu yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + menuId).submit();
                }
            });
        }

        function toggleCounter(index) {
            const checkbox = document.getElementById('menuCheck' + index);
            const counter = document.getElementById('counter' + index);
            counter.style.display = checkbox.checked ? 'flex' : 'none';
            document.getElementById('quantity' + index).value = checkbox.checked ? 0 : '';
        }

        function increase(index) {
            const count = document.getElementById('count' + index);
            let current = parseInt(count.innerText);
            count.innerText = current + 1;
            document.getElementById('quantity' + index).value = current + 1;
        }

        function decrease(index) {
            const count = document.getElementById('count' + index);
            let current = parseInt(count.innerText);
            if (current > 0) {
                count.innerText = current - 1;
                document.getElementById('quantity' + index).value = current - 1;
            }
        }

        function sendWhatsAppMessage(event) {
            event.preventDefault();

            let message = "Saya ingin memesan:\n\n";
            let totalPrice = 0;

            // Get all checked menu items
            const checkedMenus = document.querySelectorAll('.menu-checkbox:checked');

            let orderNumber = 1; // Initialize order counter
            checkedMenus.forEach((checkbox) => {
                const menuName = checkbox.dataset.menuName;
                const menuPrice = parseFloat(checkbox.dataset.menuPrice);
                const menuIndex = checkbox.id.replace('menuCheck', ''); // Extract the index from checkbox ID
                const quantity = parseInt(document.getElementById('quantity' + menuIndex).value);

                if (quantity > 0) {
                    const itemTotal = menuPrice * quantity;
                    totalPrice += itemTotal;
                    message +=
                        `${orderNumber}. ${menuName} (${quantity}) = Rp${itemTotal.toLocaleString('id-ID')}\n`;
                    orderNumber++;
                }
            });

            if (totalPrice > 0) {
                message += `\nTotal = Rp${totalPrice.toLocaleString('id-ID')}\n`;

                // Get address
                const address = document.getElementById('address').value.trim();
                if (address) {
                    message += `Alamat: ${address}`;
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Silakan masukkan alamat Anda terlebih dahulu!'
                    });
                    return; // Stop execution if no address is provided
                }

                // Get warung phone number
                const warungPhone = document.getElementById('warungPhone').value;

                // Format phone number
                let formattedPhone = warungPhone.replace(/\D/g, '');
                if (!formattedPhone.startsWith('62')) {
                    formattedPhone = formattedPhone.replace(/^0/, '62');
                }

                // Encode message for URL
                const encodedMessage = encodeURIComponent(message);

                // Open WhatsApp with pre-filled message
                window.open(`https://wa.me/${formattedPhone}?text=${encodedMessage}`, '_blank');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan pilih menu dan jumlah pesanan terlebih dahulu!'
                });
            }
        }
    </script>
      <script>
            // Inisialisasi peta
            var map = L.map('map').setView([{{ $warung->latitude }}, {{ $warung->longitude }}], 15);
            
            // Tambahkan layer peta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Tambahkan marker untuk lokasi warung
            var marker = L.marker([{{ $warung->latitude }}, {{ $warung->longitude }}])
                .addTo(map)
                .bindPopup("<b>{{ $warung->nama_warung }}</b><br>{{ $warung->alamat }}");
            
            // Buka popup marker secara otomatis
            marker.openPopup();
        </script>
        <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <script>$('#myTable').DataTable({
            pageLength: 5, // Default number of rows to show
            lengthMenu: [5, 10, 12], // Options for rows per page
            language: {
                lengthMenu: "Show _MENU_ entries per page"
            }
        });</script>
</body>

</html>