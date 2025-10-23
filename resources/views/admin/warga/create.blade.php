<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Warga - Sistem Administrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            background-color: #2c3e50;
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link:hover {
            background-color: #34495e;
        }
        .sidebar .nav-link.active {
            background-color: #3498db;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-white">Sistem Administrasi</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('warga.index') }}">
                            <i class="fas fa-users me-2"></i> Data Warga
                        </a>
                    </li>
                </ul>
            </nav>


            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4 py-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>Tambah Warga</h2>
                        <p class="mb-0 text-muted">Form untuk menambahkan data warga baru</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>Admin
                        </button>
                    </div>
                </div>


                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('warga.index') }}">Data Warga</a></li>
                        <li class="breadcrumb-item active">Tambah Warga</li>
                    </ol>
                </nav>


                <!-- Alert Success/Error -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                <!-- Form Tambah Warga -->
                <div class="card form-container">
                    <div class="card-body">
                       <form action="{{ route('warga.store') }}" method="POST">
    <form action="{{ route('warga.store') }}" method="POST">
    @csrf


    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-6">
            <!-- No KTP -->
            <div class="mb-3">
                <label for="no_ktp" class="form-label">No KTP <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                       id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}"
                       placeholder="Masukkan 16 digit No KTP" required maxlength="16">
                @error('no_ktp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                       id="nama" name="nama" value="{{ old('nama') }}"
                       placeholder="Masukkan nama lengkap" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                        id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <!-- Kolom Kanan -->
        <div class="col-md-6">
            <!-- Agama -->
            <div class="mb-3">
                <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                <select class="form-select @error('agama') is-invalid @enderror"
                        id="agama" name="agama" required>
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
                @error('agama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Pekerjaan -->
            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                       id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}"
                       placeholder="Masukkan pekerjaan" required>
                @error('pekerjaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Telepon -->
            <div class="mb-3">
                <label for="telp" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('telp') is-invalid @enderror"
                       id="telp" name="telp" value="{{ old('telp') }}"
                       placeholder="Masukkan nomor HP" required maxlength="15">
                @error('telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}"
                       placeholder="Contoh: nama@email.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>


    <!-- Tombol Aksi -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Data
                </button>
            </div>
        </div>
    </div>
</form>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        // Auto format untuk input telepon
        document.getElementById('telp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });


        // Auto format untuk input NIK (hanya angka)
        document.getElementById('no_ktp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>


