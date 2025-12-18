{{-- Navbar --}}
<<<<<<< HEAD
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold"
           href="{{ route('dashboard') }}">
            <img src="{{ asset('assets-admin/images/logo.png') }}"
                 alt="Logo Kota Pekanbaru"
                 style="height:60px; width:auto;">
            <span>Suratku</span>
        </a>

        <div>
            @auth
                <span class="text-white me-3">
                    Halo, {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
            @endguest
=======
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Admin Panel</a>
            <div>
                @auth
                    <span class="text-white me-3">Halo, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>

                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Logout</a>

                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>

                @endguest
            </div>
>>>>>>> a43dd878468f4f25e4c38c7d35c4abe00c274396
        </div>
    </div>
</nav>
{{-- Navbar tutup --}}
