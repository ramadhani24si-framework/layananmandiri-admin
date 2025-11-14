<div class="sidebar">
    @auth
        <div class="sidebar-menu">
            <h5>📋 Layanan Admin</h5>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.index') ? 'active' : '' }}">📄 Pengajuan Surat</a>
            <a href="{{ route('warga.index') }}" class="{{ request()->routeIs('warga.index') ? 'active' : '' }}">👥 Data Warga</a>
            <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.index') ? 'active' : '' }}">👤 Data User</a>
        </div>
    @endauth
</div>
{{--sidebar--}}
