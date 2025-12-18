@extends('layouts.app')

@section('title', 'Detail Berkas Persyaratan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('berkas_persyaratan.index') }}">Berkas Persyaratan</a>
                    </li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Detail Berkas Persyaratan</h2>
                <div>
                    <a href="{{ route('berkas_persyaratan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('berkas_persyaratan.edit', $berkas->berkas_id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Berkas
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th width="40%">ID Berkas</th>
                            <td>{{ $berkas->berkas_id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Berkas</th>
                            <td>
                                <strong>{{ $berkas->nama_berkas }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Status Validasi</th>
                            <td>
                                @php
                                    $badgeClass = [
                                        'menunggu' => 'bg-warning',
                                        'valid' => 'bg-success',
                                        'tidak_valid' => 'bg-danger',
                                    ][$berkas->valid] ?? 'secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $berkas->status_text }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Pengajuan</th>
                            <td>
                                @if($berkas->pengajuan)
                                    <a href="{{ route('pengajuan.show', $berkas->pengajuan->permohonan_id) }}"
                                       class="text-decoration-none">
                                        <strong>{{ $berkas->pengajuan->nomor_permohonan }}</strong>
                                    </a>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $berkas->pengajuan->warga->nama ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-muted">  -</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah File</th>
                            <td>
                                <span class="badge bg-info">
                                    <i class="fas fa-file me-1"></i>
                                    {{ $berkas->media->count() }} file
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $berkas->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diupdate</th>
                            <td>{{ $berkas->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Quick Status Update --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sync-alt me-2"></i>Ubah Status
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('berkas_persyaratan.update', $berkas->berkas_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="permohonan_id" value="{{ $berkas->permohonan_id }}">
                        <input type="hidden" name="nama_berkas" value="{{ $berkas->nama_berkas }}">

                        <div class="mb-3">
                            <select name="valid" class="form-select" onchange="this.form.submit()">
                                <option value="menunggu" {{ $berkas->valid == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="valid" {{ $berkas->valid == 'valid' ? 'selected' : '' }}>Valid</option>
                                <option value="tidak_valid" {{ $berkas->valid == 'tidak_valid' ? 'selected' : '' }}>Tidak Valid</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- File List --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file me-2"></i>File Terlampir
                        <span class="badge bg-primary ms-2">{{ $berkas->media->count() }}</span>
                    </h5>
                    <a href="{{ route('berkas_persyaratan.edit', $berkas->berkas_id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah File
                    </a>
                </div>
                <div class="card-body">
                    @if($berkas->media->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama File</th>
                                        <th>Tipe</th>
                                        <th>Ukuran</th>
                                        <th>Keterangan</th>
                                        <th width="120" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($berkas->media as $index => $media)
                                        @php
                                            $filePath = 'media/berkas_persyaratan/' . $berkas->berkas_id . '/' . $media->file_name;
                                            $fileUrl = asset('storage/' . $filePath);
                                            $isImage = in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/jpg']);
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($isImage)
                                                        <i class="fas fa-image text-success me-2"></i>
                                                    @elseif($media->mime_type == 'application/pdf')
                                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                                    @elseif(str_contains($media->mime_type, 'word'))
                                                        <i class="fas fa-file-word text-primary me-2"></i>
                                                    @else
                                                        <i class="fas fa-file me-2"></i>
                                                    @endif
                                                    <div>
                                                        <a href="{{ $fileUrl }}" target="_blank"
                                                           class="text-decoration-none" title="{{ $media->caption }}">
                                                            {{ Str::limit($media->caption, 30) }}
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $media->file_name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ pathinfo($media->file_name, PATHINFO_EXTENSION) }}
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    @if(Storage::disk('public')->exists($filePath))
                                                        {{ round(Storage::disk('public')->size($filePath) / 1024, 1) }} KB
                                                    @else
                                                        -
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $media->caption ? Str::limit($media->caption, 25) : '-' }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ $fileUrl }}" target="_blank"
                                                       class="btn btn-sm btn-info" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('berkas_persyaratan.downloadMedia', [$berkas->berkas_id, $media->media_id]) }}"
                                                       class="btn btn-sm btn-success" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <form action="{{ route('berkas_persyaratan.destroyMedia', [$berkas->berkas_id, $media->media_id]) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus file ini?')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5>Tidak ada file terlampir</h5>
                            <p class="text-muted">Belum ada file yang diupload untuk berkas ini</p>
                            <a href="{{ route('berkas_persyaratan.edit', $berkas->berkas_id) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Tambah File
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- File Preview Area --}}
            @if($berkas->media->count() > 0)
                @php
                    $firstMedia = $berkas->media->first();
                    $firstFilePath = 'media/berkas_persyaratan/' . $berkas->berkas_id . '/' . $firstMedia->file_name;
                    $firstFileUrl = asset('storage/' . $firstFilePath);
                    $isImage = in_array($firstMedia->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/jpg']);
                @endphp
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-eye me-2"></i>Preview File
                            <small class="text-muted ms-2">{{ $firstMedia->caption }}</small>
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        @if($isImage && Storage::disk('public')->exists($firstFilePath))
                            <img src="{{ $firstFileUrl }}" alt="{{ $firstMedia->caption }}"
                                 class="img-fluid rounded" style="max-height: 400px;">
                        @elseif($firstMedia->mime_type == 'application/pdf')
                            <div class="py-4">
                                <i class="fas fa-file-pdf fa-5x text-danger mb-3"></i>
                                <p class="mb-0">File PDF</p>
                                <small class="text-muted">Klik tombol "Lihat" untuk membuka file</small>
                                <div class="mt-3">
                                    <a href="{{ $firstFileUrl }}" target="_blank" class="btn btn-primary">
                                        <i class="fas fa-external-link-alt me-2"></i> Buka PDF
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="py-4">
                                <i class="fas fa-file fa-5x text-secondary mb-3"></i>
                                <p class="mb-0">File {{ pathinfo($firstMedia->file_name, PATHINFO_EXTENSION) }}</p>
                                <small class="text-muted">File dapat diunduh atau dilihat dengan aplikasi yang sesuai</small>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
     <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
</div>
@endsection

@push('styles')
<style>
    .file-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        margin-right: 10px;
    }
    .pdf-icon { background-color: #fee; color: #d32f2f; }
    .image-icon { background-color: #e8f5e9; color: #388e3c; }
    .doc-icon { background-color: #e3f2fd; color: #1976d2; }
</style>
@endpush
