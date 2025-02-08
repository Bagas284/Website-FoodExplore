<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form with Spacing</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <style>
            .form-group {
                margin-top: 15px;
                margin-bottom: 15px;
            }
            /* Membuat form lebih lebar dan terpusat */
            .form-container {
                max-width: 600px;
                margin: 0 auto; /* Mengatur form berada di tengah */
                padding: 20px;
                background-color: #f8f9fa; /* Warna latar belakang untuk form */
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            #map {
                height: 250px;
                width: 100%;
                margin: 15px 0;
                border-radius: 4px;
                border: 1px solid #ddd;
            }
        </style>
    </head>

    <body>
        <div class="form-container" style="margin-top: 120px">

            <x-slot name="header">  
                {{ __('Tambah Warung') }}
            </x-slot>

            <form action="{{ route('warung.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Nama Warung -->
                <div class="form-group">
                    <label for="nama_warung"><b>Nama Warung</b></label>
                    <input type="text" class="form-control" id="nama_warung" name="nama_warung"
                        placeholder="Masukkan nama warung" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat"><b>Alamat</b></label>
                    <input type="text" class="form-control" id="alamat" name="alamat"
                        placeholder="Masukkan alamat warung">
                </div>

                <!-- Nomor Whatsapp -->
                <div class="form-group">
                    <label for="no_wa"><b>Nomor Whatsapp</b></label>
                    <input type="text" class="form-control" id="no_wa" name="no_wa"
                        placeholder="Masukkan nomor Whatsapp" required>
                </div>

                <!-- Status Pengantaran -->
                <div class="form-group">
                    <label for="status_pengantaran"><b>Status Pengantaran</b></label>
                    <select class="form-control" id="status_pengantaran" name="status_pengantaran" required>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>

                <!-- Gambar Menu -->
                <div class="form-group">
                    <label for="image"><b>Gambar Menu</b></label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>

                <!-- Peta Lokasi -->
                <div class="form-group">
                    <label for="map"><b>Lokasi Warung</b></label>
                    <div id="map"></div>
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $warung->latitude ?? '') }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $warung->longitude ?? '') }}">
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    <a  href="{{ route('warung.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
 
    <script>
    // Inisialisasi default koordinat (contoh: Jakarta)
    const defaultLat = -6.200000;
    const defaultLng = 106.816666;
    
    // Inisialisasi peta
    var map = L.map('map').setView([defaultLat, defaultLng], 12);
    var marker = null;

    // Tambahkan layer OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Fungsi untuk update marker dan koordinat
    function updateMarker(lat, lng) {
        // Hapus marker lama jika ada
        if (marker !== null) {
            map.removeLayer(marker);
        }

        // Tambah marker baru
        marker = L.marker([lat, lng], {
            draggable: true // Marker bisa di-drag
        }).addTo(map);

        // Update nilai input
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Event ketika marker di-drag
        marker.on('dragend', function(e) {
            const position = e.target.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });
    }

    // Event ketika map diklik
    map.on('click', function(e) {
        updateMarker(e.latlng.lat, e.latlng.lng);
    });

    // Tambahkan kontrol pencarian lokasi
    var searchControl = L.Control.extend({
        options: {
            position: 'topleft'
        },

        onAdd: function() {
            var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
            var button = L.DomUtil.create('a', '', container);
            button.innerHTML = '📍';
            button.href = '#';
            button.style.width = '30px';
            button.style.height = '30px';
            button.style.lineHeight = '30px';
            button.style.textAlign = 'center';
            button.style.backgroundColor = 'white';
            button.title = 'Temukan lokasi saya';

            button.onclick = function(e) {
                e.preventDefault();
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 16);
                        updateMarker(lat, lng);
                    });
                }
                return false;
            };

            return container;
        }
    });

    // Tambahkan kontrol pencarian ke map
    map.addControl(new searchControl());

    // Tambahkan kontrol zoom
    L.control.zoom({
        position: 'topright'
    }).addTo(map);

    // Set marker awal jika ada nilai latitude dan longitude
    const initialLat = document.getElementById('latitude').value;
    const initialLng = document.getElementById('longitude').value;
    
    if (initialLat && initialLng) {
        updateMarker(parseFloat(initialLat), parseFloat(initialLng));
    }
</script>

</body>

</html>

</x-app-layout>
