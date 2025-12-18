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
                        class="badge bg-{{ $userRole == 'super_admin' ? 'danger' : ($userRole == 'warga' ? 'warning' : 'info') }}">
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
                                    @if (isset($userRole) && in_array($userRole, ['super_admin', 'warga']))
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
            @if (isset($userRole) && in_array($userRole, ['super_admin', 'warga']))
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
                                        @if ($userRole == 'super_admin' || $userRole == 'warga')
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
                                        @if ($userRole == 'super_admin' || $userRole == 'warga')
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

                            <!-- Menu hanya untuk warga -->
                            @if (isset($userRole) && in_array($userRole, ['super_admin', 'warga']))
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
                                            @if (isset($userRole) && in_array($userRole, ['super_admin', 'warga']))
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
                                                @if (isset($userRole) && in_array($userRole, ['super_admin', 'warga']))
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

        <!-- Bagian Identitas Pengembang -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-code"></i> Pengembang Sistem
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <!-- Single Developer Profile -->
                            <div class="col-lg-6 col-md-8">
                                <div class="developer-profile text-center">
                                    <div class="developer-photo mb-4">
                                        <!-- GANTI DENGAN PATH FOTO ANDA -->
                                        <img src="{{ asset('assets-admin/images/dedek.webp') }}"
                                             alt="Foto Pengembang"
                                             class="rounded-circle shadow-lg border border-4 border-white"
                                             width="180"
                                             height="180"
                                             style="object-fit: cover;">
                                    </div>

                                    <h4 class="font-weight-bold text-primary mb-2">Suci Ramadhani</h4>

                                    <div class="developer-info mb-4">
                                        <div class="info-item mb-2">
                                            <i class="fas fa-id-card text-muted me-2"></i>
                                            <span class="text-dark">NIM: 2457301138</span>
                                        </div>
                                        <div class="info-item mb-3">
                                            <i class="fas fa-graduation-cap text-muted me-2"></i>
                                            <span class="text-dark">Program Studi: Sistem Informasi</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-university text-muted me-2"></i>
                                            <span class="text-dark">Universitas: Politeknik Caltex Riau`</span>
                                        </div>
                                    </div>

                                    <div class="developer-skills mb-4">
                                        <h6 class="font-weight-bold mb-3">Keahlian:</h6>
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <span class="badge bg-primary">Laravel</span>
                                            <span class="badge bg-success">PHP</span>
                                            <span class="badge bg-info">JavaScript</span>
                                            <span class="badge bg-warning">Bootstrap</span>
                                            <span class="badge bg-secondary">MySQL</span>
                                        </div>
                                    </div>

                                    <div class="developer-social mt-4">
                                        <h6 class="font-weight-bold mb-3">Hubungi Saya:</h6>
                                        <div class="d-flex justify-content-center gap-3">
                                            <!-- LinkedIn -->
                                            <a href="https://linkedin.com/in/username"
                                               target="_blank"
                                               class="social-link linkedin"
                                               title="LinkedIn Profile">
                                                <i class="fab fa-linkedin fa-2x"></i>
                                            </a>
                                            <!-- GitHub -->
                                            <a href="https://github.com/username"
                                               target="_blank"
                                               class="social-link github"
                                               title="GitHub Profile">
                                                <i class="fab fa-github fa-2x"></i>
                                            </a>
                                            <!-- Instagram -->
                                            <a href="https://instagram.com/username"
                                               target="_blank"
                                               class="social-link instagram"
                                               title="Instagram Profile">
                                                <i class="fab fa-instagram fa-2x"></i>
                                            </a>
                                            <!-- Email -->
                                            <a href="mailto:email@example.com"
                                               class="social-link email"
                                               title="Email">
                                                <i class="fas fa-envelope fa-2x"></i>
                                            </a>
                                            <!-- WhatsApp -->
                                            <a href="https://wa.me/6281234567890"
                                               target="_blank"
                                               class="social-link whatsapp"
                                               title="WhatsApp">
                                                <i class="fab fa-whatsapp fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bagian Identitas Pengembang -->

    </div>

    <!-- Footer Copyright -->
    <div class="form-footer mt-4">
        <p class="text-center text-muted">
            &copy; 2025 Sistem Layanan Mandiri. All rights reserved.
        </p>
    </div>
@endsection

@push('styles')
<style>
    /* Styling untuk developer profile */
    .developer-profile {
        padding: 30px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .developer-photo img {
        transition: transform 0.3s ease;
    }

    .developer-photo img:hover {
        transform: scale(1.05);
    }

    .developer-info .info-item {
        background: white;
        padding: 10px 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        display: inline-block;
        min-width: 300px;
        text-align: left;
    }

    .developer-skills .badge {
        font-size: 0.9rem;
        padding: 8px 15px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .developer-skills .badge:hover {
        transform: translateY(-3px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }

    /* Styling untuk link media sosial */
    .social-link {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .social-link.linkedin {
        background-color: #0077B5;
        color: white;
    }

    .social-link.linkedin:hover {
        background-color: #005582;
    }

    .social-link.github {
        background-color: #333;
        color: white;
    }

    .social-link.github:hover {
        background-color: #222;
    }

    .social-link.instagram {
        background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);
        color: white;
    }

    .social-link.email {
        background-color: #DB4437;
        color: white;
    }

    .social-link.email:hover {
        background-color: #C23321;
    }

    .social-link.whatsapp {
        background-color: #25D366;
        color: white;
    }

    .social-link.whatsapp:hover {
        background-color: #1DA851;
    }

    /* Styling untuk form footer */
    .form-footer {
        padding: 20px;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        margin-top: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .developer-info .info-item {
            min-width: 100%;
        }

        .social-link {
            width: 45px;
            height: 45px;
        }

        .developer-photo img {
            width: 150px;
            height: 150px;
        }
    }
</style>
@endpush
