  @auth
        <div class="sidebar">
            <h5>📋 Menu Navigasi</h5>


            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.index') ? 'active' : '' }}">📄 Pengajuan Surat</a>
            <a href="{{ route('warga.index') }}" class="{{ request()->routeIs('warga.index') ? 'active' : '' }}">📄 Data Warga</a>
        </div>
        @endauth
