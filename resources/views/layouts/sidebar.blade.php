{{-- SIDEBAR --}}
<style>
    /* Tinggi navbar */
    :root {
        --navbar-height: 70px;
    }

    .sidebar {
        width: 260px;
        height: calc(100vh - var(--navbar-height));
        background: linear-gradient(180deg, #0f172a, #020617);
        padding: 20px 15px;
        position: fixed;
        top: var(--navbar-height); /* ⬅️ TURUN DI BAWAH NAVBAR */
        left: 0;
        font-family: 'Segoe UI', sans-serif;
        overflow-y: auto;
    }
.sidebar-header {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 25px;
}

.sidebar-logo {
    width: 300px;          /* BESAR tapi tetap rapi */
    height: auto;         /* jaga proporsi */
    max-width: 100%;
    object-fit: contain;
}


    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        margin-bottom: 10px;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #cbd5f5;
        text-decoration: none;
        border-radius: 14px;
        transition: all 0.2s ease;
        font-size: 14px;
    }

    .sidebar-menu a:hover {
        background-color: #1e293b;
        color: #fff;
    }

    .sidebar-menu a.active {
        background-color: #3b82f6;
        color: #fff;
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.45);
    }

    .sidebar-menu span {
        white-space: nowrap;
    }

</style>

<div class="sidebar">
    @auth
        {{-- LOGO --}}
       <div class="sidebar-header">
    <img src="{{ asset('assets-admin/images/logo.png') }}"
         alt="Logo Kota Pekanbaru"
         class="sidebar-logo">
</div>


        {{-- MENU --}}
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    🏠 <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
                    📄 <span>Pengajuan Surat</span>
                </a>
            </li>

            <li>
                <a href="{{ route('warga.index') }}" class="{{ request()->routeIs('warga.*') ? 'active' : '' }}">
                    👥 <span>Data Warga</span>
                </a>
            </li>

            <li>
                <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.*') ? 'active' : '' }}">
                    👤 <span>Data User</span>
                </a>
            </li>

            <li>
                <a href="{{ route('jenis_surat.index') }}" class="{{ request()->routeIs('jenis_surat.*') ? 'active' : '' }}">
                    📝 <span>Jenis Surat</span>
                </a>
            </li>

            <li>
                <a href="{{ route('berkas_persyaratan.index') }}" class="{{ request()->routeIs('berkas_persyaratan.*') ? 'active' : '' }}">
                    📎 <span>Berkas Persyaratan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('riwayat_status_surat.index') }}" class="{{ request()->routeIs('riwayat_status_surat.*') ? 'active' : '' }}">
                    📋 <span>Riwayat Status</span>
                </a>
            </li>
        </ul>
    @endauth
</div>
{{-- END SIDEBAR --}}
