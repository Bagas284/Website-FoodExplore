<x-app-layout>
    <!-- Add SweetAlert2 CDN in head -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="row border border-secondary-subtle rounded-4 mx-5 my-4 shadow-sm">
        <div class="col-12 col-md-3 d-flex flex-column justify-content-center align-items-center py-4">
            <div class="mb-4">
                <img src="{{ auth()->user()->photo_profile ? asset(auth()->user()->photo_profile) : asset('img/profile-user.png') }}"
                    alt="Profile" class="rounded-circle" style="width: 140px; height: 140px; object-fit: cover;">
            </div>

            <form id="photoForm" method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="file" name="photo_profile" id="photo_profile" class="d-none" onchange="previewFile()">
                <div>
                    <button type="button" class="btn btn-warning"
                        onclick="document.getElementById('photo_profile').click()">Unggah Foto</button>
                    <button type="button" class="btn btn-success d-none" id="submit-photo"
                        onclick="submitPhoto()">Simpan</button>
                </div>
            </form>
        </div>

        <div class="col">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="row border border-secondary-subtle rounded-4 mx-5 my-4 shadow-sm">
        @include('profile.partials.update-password-form')
    </div>

    <div class="row border border-secondary-subtle rounded-4 mx-5 my-4 shadow-sm">
        @include('profile.partials.delete-user-form')
    </div>

    <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="mx-5 mb-4">
        @csrf
        <button type="button" onclick="confirmLogout()" class="btn btn-outline-warning w-100">Keluar</button>
    </form>

    <script>
        function previewFile() {
            const fileInput = document.getElementById('photo_profile');
            const submitButton = document.getElementById('submit-photo');

            if (fileInput.files && fileInput.files[0]) {
                submitButton.classList.remove('d-none');
            }
        }

        function submitPhoto() {
            Swal.fire({
                title: 'Simpan foto?',
                text: "Foto profil Anda akan diperbarui",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('photoForm').submit();
                }
            });
        }

        // Add this to update-profile-information-form.blade.php
        function submitProfile(formId) {
            Swal.fire({
                title: 'Perbarui profil?',
                text: "Data profil Anda akan diperbarui",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Add this to update-password-form.blade.php
        function submitPassword(formId) {
            Swal.fire({
                title: 'Perbarui password?',
                text: "Password Anda akan diperbarui",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Keluar?',
                text: "Anda akan keluar dari sistem",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        // Add success/error alerts
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('status') }}",
                timer: 3000
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ $errors->first() }}",
                timer: 3000
            });
        @endif

        function confirmDelete() {
    Swal.fire({
        title: 'Hapus akun?',
        text: "Akun Anda akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the delete form
            document.querySelector('form[action="{{ route('profile.destroy') }}"]').submit();
        }
    });
}

function confirmDelete() {
            const form = document.getElementById('deleteForm');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
        
            if (!email || !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Email dan password harus diisi',
                });
                return;
            }
        
            Swal.fire({
                title: 'Hapus akun?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus akun!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
        
        // Add error handling
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ $errors->first() }}",
                timer: 3000
            });
        @endif



    </script>
</x-app-layout>
