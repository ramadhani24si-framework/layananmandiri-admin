@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div>
                @if (isset($userRole))
                    <span
                        class="badge bg-{{ $userRole == 'super_admin' ? 'danger' : ($userRole == 'admin' ? 'warning' : 'info') }}">
                        <i class="fas fa-user"></i> {{ ucfirst($userRole) }}
                    </span>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Welcome Card -->
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Selamat Datang, {{ $userName }}!</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Anda login sebagai
                                    <span class="text-primary">
                                        {{ isset($userRole) ? ucfirst($userRole) : 'User' }}
                                    </span>
                                </div>
                                <p class="mt-2 mb-0 text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    @if (isset($userRole) && in_array($userRole, ['super_admin', 'admin']))
                                        Anda memiliki akses penuh ke sistem administrasi.
                                    @else
                                        Anda dapat mengajukan surat dan melacak status pengajuan.
                                    @endif
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row - Statistik -->
        <div class="row">
            @if (isset($userRole) && in_array($userRole, ['super_admin', 'admin']))
                <!-- Data untuk Admin/Super Admin -->

                <!-- Total User (hanya admin) -->
                @if (isset($userCount))
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total User</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                                        @if ($userRole == 'super_admin' || $userRole == 'admin')
                                            <div class="mt-2">
                                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Total Warga (hanya admin) -->
                @if (isset($wargaCount))
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Warga</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $wargaCount }}</div>
                                        @if ($userRole == 'super_admin' || $userRole == 'admin')
                                            <div class="mt-2">
                                                <a href="{{ route('warga.index') }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Total Pengajuan -->
                @if (isset($pengajuanCount))
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Pengajuan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengajuanCount }}</div>
                                        <div class="mt-2">
                                            <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Jenis Surat -->
                @if (isset($jenisSuratCount))
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Jenis Surat</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jenisSuratCount }}</div>
                                        <div class="mt-2">
                                            <a href="{{ route('jenis_surat.index') }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-signature fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Data untuk User Biasa -->

                <!-- Total Pengajuan User -->
                @if (isset($pengajuanCount))
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pengajuan Saya</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengajuanCount }}</div>
                                        <div class="mt-2">
                                            <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Lihat Semua
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pending -->
                @if (isset($pengajuanPending))
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Pending</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengajuanPending }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Selesai -->
                @if (isset($pengajuanSelesai))
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Selesai</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengajuanSelesai }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @endif
        </div>

        <!-- Status Pengajuan -->
        @if (isset($pengajuanPending) || isset($pengajuanDiproses) || isset($pengajuanSelesai) || isset($pengajuanDitolak))
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie"></i> Status Pengajuan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if (isset($pengajuanPending))
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Pending</h6>
                                                <h2>{{ $pengajuanPending }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($pengajuanDiproses))
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="card bg-info text-white">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Diproses</h6>
                                                <h2>{{ $pengajuanDiproses }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($pengajuanSelesai))
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Selesai</h6>
                                                <h2>{{ $pengajuanSelesai }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($pengajuanDitolak))
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Ditolak</h6>
                                                <h2>{{ $pengajuanDitolak }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions Berdasarkan Role -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-bolt"></i> Menu Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Menu untuk semua user -->
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('pengajuan.create') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-plus"></i> Buat Pengajuan
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('pengajuan.index') }}" class="btn btn-info btn-block">
                                    <i class="fas fa-list"></i> Lihat Pengajuan
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('jenis_surat.index') }}" class="btn btn-success btn-block">
                                    <i class="fas fa-file-signature"></i> Jenis Surat
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('berkas_persyaratan.index') }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-file-pdf"></i> Persyaratan
                                </a>
                            </div>

                            <!-- Menu hanya untuk admin -->
                            @if (isset($userRole) && in_array($userRole, ['super_admin', 'admin']))
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('user.index') }}" class="btn btn-dark btn-block">
                                        <i class="fas fa-users-cog"></i> Manajemen User
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('warga.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-users"></i> Data Warga
                                    </a>
                                </div>
                            @endif

                            <!-- Menu hanya untuk super_admin -->
                            @if (isset($userRole) && $userRole == 'super_admin')
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.settings') }}" class="btn btn-danger btn-block">
                                        <i class="fas fa-cogs"></i> Pengaturan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Pengajuan -->
        @if (isset($recentPengajuan) && $recentPengajuan->count() > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history"></i> Pengajuan Terbaru
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            @if (isset($userRole) && in_array($userRole, ['super_admin', 'admin']))
                                                <th>Nama Warga</th>
                                            @endif
                                            <th>Jenis Surat</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentPengajuan as $index => $pengajuan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                                                @if (isset($userRole) && in_array($userRole, ['super_admin', 'admin']))
                                                    <td>{{ $pengajuan->warga->nama ?? '-' }}</td>
                                                @endif
                                                <td>{{ $pengajuan->jenisSurat->nama ?? '-' }}</td>
                                                <td>
                                                    @if ($pengajuan->status == 'draft')
                                                        <span class="badge bg-secondary">Draft</span>
                                                    @elseif($pengajuan->status == 'diajukan')
                                                        <span class="badge bg-info">Diajukan</span>
                                                    @elseif($pengajuan->status == 'diproses')
                                                        <span class="badge bg-warning">Diproses</span>
                                                    @elseif($pengajuan->status == 'selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif($pengajuan->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pengajuan->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pengajuan->catatan ? Str::limit($pengajuan->catatan, 50) : '-' }}
                                                </td>
                                                <td>
                                                    <!-- PERBAIKAN: gunakan permohonan_id bukan id -->
                                                    <a href="{{ route('pengajuan.show', $pengajuan->permohonan_id) }}"
                                                        class="btn btn-sm btn-info" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <!-- PERBAIKAN: gunakan permohonan_id bukan id -->
                                                    @if ($pengajuan->status == 'draft' || $pengajuan->status == 'diajukan')
                                                        <a href="{{ route('pengajuan.edit', $pengajuan->permohonan_id) }}"
                                                            class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
