<div class="sidebar">
    @auth
        <div class="sidebar-menu">
            <h5>📋 Layanan Admin</h5>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.index') ? 'active' : '' }}">📄 Pengajuan Surat</a>
            <a href="{{ route('warga.index') }}" class="{{ request()->routeIs('warga.index') ? 'active' : '' }}">👥 Data Warga</a>
            <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.index') ? 'active' : '' }}">👤 Data User</a>
            <a href="{{ route('jenis_surat.index') }}" class="{{ request()->routeIs('jenis_surat.index') ? 'active' : '' }}">📝 Jenis Surat</a>
        </div>
    @endauth
</div>
{{--sidebar--}}
