{{-- Navbar --}}
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        {{-- LOGO + JUDUL --}}
        <a class="navbar-brand d-flex align-items-center gap-1 fw-bold"
           href="{{ route('dashboard') }}">
 <img src="{{ asset('assets-admin/images/logo.png') }}"
     alt="Logo Kota Pekanbaru"
                 style="height:60px; width:auto;">

            <span>Suratku</span>
        </a>

        {{-- USER --}}
        <div>
            @auth
                <span class="text-white me-3">
                    👋 Halo, {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                    Register
                </a>
            @endguest
        </div>
    </div>
</nav>
{{-- Navbar tutup --}}
