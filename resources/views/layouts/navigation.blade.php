<nav class="navbar bg-merahtua navbar-expand-lg fixed-top navbar-dark" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand me-5">
            <img src="{{ asset('img/logo_FoodExplore.png') }}" alt="FoodExplore Logo" class="img-fluid"
                style="max-width: 110px; height: auto;">
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas Menu -->
        <div class="offcanvas offcanvas-end bg-merahtua" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>

            <div class="offcanvas-header" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <a href="{{ route('profile.edit') }}" role="button"
                    class="nav-link text-white d-flex align-items-center gap-3">
                    <!-- Foto Profil -->
                    <img src="{{ auth()->user()->photo_profile ? asset(auth()->user()->photo_profile) : asset('img/profile-user.png') }}" 
                    alt="Profile" 
                    class="rounded-circle"
                    style="width: 65px; height: 65px; object-fit: cover;">

                    <!-- Nama dan Peran -->
                    <div>
                        <p class="fs-4 mb-0">{{ Auth::user()->name }}</p>
                        <small class="text-white-50">{{ Auth::user()->getRoleNames() }}</small>
                    </div>
                </a>
            </div>

            <div class="offcanvas-body">
                <!-- Navigation Links -->
                @auth
                    <ul class="navbar-nav me-auto ms-0 ms-lg-5 fs-5">
                        <li class="nav-item me-5">
                            <a class="{{ request()->is('dashboard') ? 'nav-link text-warning active' : 'nav-link' }}"
                                aria-current="page" href="{{ route('dashboard') }}">Beranda</a>
                        </li>

                        <hr class="my-2 text-light opacity-50">

                        <li class="nav-item me-5">
                            <a class="{{ request()->is('warung') ? 'nav-link text-warning active' : 'nav-link' }}"
                                aria-current="page" href="{{ route('warung.index') }}">Warung</a>
                        </li>

                        <hr class="my-2 text-light opacity-50">

                        @auth
                        @if (Auth::user()->hasRole('Admin'))
                        <li class="nav-item me-5">
                            @auth
                                @if (Auth::user()->hasRole('Admin'))
                                    <a class="{{ request()->is('manageAccount') ? 'nav-link text-warning active' : 'nav-link' }}"
                                       aria-current="page" href="{{ route('manageAccount.index') }}">Manage Account</a>
                                @endif
                            @endauth
                        </li>

                        <hr class="my-2 text-light opacity-50">

                        @endif
                        @endauth
                        
                        <li class="nav-item me-5 mb-2 mb-lg-0">
                            @auth
                                @if (Auth::user()->hasRole('Admin'))
                                    <a class="{{ request()->is('manage-role') ? 'nav-link text-warning active' : 'nav-link' }}"
                                       aria-current="page" href="{{ route('manageRole.list') }}">Manage Role</a>
                                @endif
                            @endauth
                        </li>
                    </ul>
                @endauth

                <!-- Search and Profile Section -->
                @auth
                    <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-3">
                        <!-- Search Form -->
                        @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('User'))
                            <form class="d-flex flex-grow-1" role="search" action="{{ route('warung.search') }}"
                                method="GET">
                                <input class="form-control me-2" type="search" placeholder="Cari Warung"
                                    aria-label="Search" name="search_query" value="{{ request('search_query') }}">
                                <button class="btn btn-warning" type="submit">Cari</button>
                            </form>
                        @endif

                        <!-- Foto Profil -->
                        <a href="{{ route('profile.edit') }}" class="d-none d-lg-flex align-items-center mx-3" role="button">
                            <img src="{{ auth()->user()->photo_profile ? asset(auth()->user()->photo_profile) : asset('img/profile-user.png') }}" 
                                 alt="Profile" 
                                 class="rounded-circle"
                                 style="width: 65px; height: 65px; object-fit: cover;">
                        </a>
                    </div>
                @endauth
            </div>

            <div class="d-lg-none pt-2 text-center" style="box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none text-white">
                        <p class="fs-4 ">Keluar</p>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
