<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Warung</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <style>
            .form-group {
                margin-top: 15px;
                margin-bottom: 15px;
            }

            .form-container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            #map {
                height: 300px;
                margin-top: 15px;
                border-radius: 8px;
            }
        </style>
    </head>

    <body>
        <div class="form-container" style="margin-top: 120px">
            <x-slot name="header">  
                {{ __('Edit Warung') }}
            </x-slot>
            <form action="{{ route('warung.update', $warung->warung_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Warung -->
                <div class="form-group">
                    <label for="nama_warung"><b>Nama Warung</b></label>
                    <input type="text" class="form-control" id="nama_warung" name="nama_warung"
                        value="{{ old('nama_warung', $warung->nama_warung) }}" placeholder="Masukkan nama warung" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat"><b>Alamat</b></label>
                    <input type="text" class="form-control" id="alamat" name="alamat"
                        value="{{ old('alamat', $warung->alamat) }}" placeholder="Masukkan alamat warung">
                </div>

                <!-- Nomor Whatsapp -->
                <div class="form-group">
                    <label for="no_wa"><b>Nomor Whatsapp</b></label>
                    <input type="text" class="form-control" id="no_wa" name="no_wa"
                        value="{{ old('no_wa', $warung->no_wa) }}" placeholder="Masukkan nomor Whatsapp" required>
                </div>

                <!-- Status Pengantaran -->
                <div class="form-group">
                    <label for="status_pengantaran"><b>Status Pengantaran</b></label>
                    <select class="form-control" id="status_pengantaran" name="status_pengantaran" required>
                        <option value="aktif" {{ $warung->status_pengantaran == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ $warung->status_pengantaran == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <!-- Gambar Menu -->
                <div class="form-group">
                    <label for="image"><b>Gambar Menu</b></label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>

                <!-- Peta Lokasi -->
                <div class="form-group">
                    <label for="map"><b>Lokasi Warung</b></label>
                    <div id="map"></div>
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $warung->latitude) }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $warung->longitude) }}">
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a  href="{{ route('warung.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>

        <script>
            // Map Initialization
            var map = L.map('map').setView([{{ $warung->latitude ?? -6.200000 }}, {{ $warung->longitude ?? 106.816666 }}], 10);
            var marker;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            // Set existing marker if coordinates exist
            if ({{ $warung->latitude ?? 'null' }} && {{ $warung->longitude ?? 'null' }}) {
                marker = L.marker([{{ $warung->latitude }}, {{ $warung->longitude }}]).addTo(map);
            }

            // Event to place marker and update hidden input fields
            map.on('click', function (e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        </script>
    </body>

    </html>
</x-app-layout>
