<section class="space-y-6 my-4">
    <header>
        <h2 class="text-lg font-medium">Hapus Akun</h2>
        <p class="mt-1 text-sm text-gray-600">Setelah akun Anda dihapus, semua data akan terhapus secara permanen.</p>
    </header>

    <form id="deleteForm" method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            Hapus Akun
        </button>
    </form>
    
</section>