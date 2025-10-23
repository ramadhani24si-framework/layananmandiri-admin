<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga - Sistem Administrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar min-vh-100">
                <div class="position-sticky pt-3">
                    <div class="p-3">
                        <h4 class="text-white">Sistem Administrasi</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="{{ route('warga.index') }}">
                                <i class="fas fa-users me-2"></i> Data Warga
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>


            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Data Warga</h2>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>Admin
                        </button>
                    </div>
                </div>


                <!-- Alert Success -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                <!-- Card Data Warga -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Warga</h5>
                        <a href="{{ route('warga.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Warga
                        </a>
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
    <table class="table table-centered table-nowrap mb-0 rounded">
        <thead class="thead-light">
            <tr>
                <th class="border-0 rounded-start">No</th>
                <th class="border-0">No KTP</th>
                <th class="border-0">Nama</th>
                <th class="border-0">Jenis Kelamin</th>
                <th class="border-0">Agama</th>
                <th class="border-0">Pekerjaan</th>
                <th class="border-0">Telepon</th>
                <th class="border-0">Email</th>
                <th class="border-0 rounded-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warga as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->no_ktp }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    @if($item->jenis_kelamin == 'L')
                        Laki-laki
                    @else
                        Perempuan
                    @endif
                </td>
                <td>{{ $item->agama }}</td>
                <td>{{ $item->pekerjaan }}</td>
                <td>{{ $item->telp }}</td>
                <td>{{ $item->email ?: '-' }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-users fa-2x text-muted mb-2"></i>
                        <span class="text-muted">Belum ada data warga</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>







