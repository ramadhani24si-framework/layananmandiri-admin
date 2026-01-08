@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Detail Pengajuan Surat</h2>
                <p class="text-muted mb-0">{{ $pengajuan->nomor_permohonan }}</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('pengajuan.edit', $pengajuan->permohonan_id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal">
                    <i class="fas fa-sync"></i> Ubah Status
                </button>
            </div>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Informasi Utama -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Informasi Pengajuan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Nomor Permohonan</th>
                                        <td>: <strong>{{ $pengajuan->nomor_permohonan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pengajuan</th>
                                        <td>: {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge bg-{{ $pengajuan->status_badge }}">
                                                {{ $pengajuan->status_text }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Surat</th>
                                        <td>: {{ $pengajuan->jenisSurat->nama_jenis }} ({{ $pengajuan->jenisSurat->kode }})
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Nama Warga</th>
                                        <td>: {{ $pengajuan->warga->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>: {{ $pengajuan->warga->no_ktp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>: {{ $pengajuan->warga->telp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>: {{ $pengajuan->warga->email ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Catatan -->
                        @if ($pengajuan->catatan)
                            <div class="mt-3">
                                <h6>Catatan:</h6>
                                <div class="card card-body bg-light">
                                    {{ $pengajuan->catatan }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Syarat yang diperlukan -->
                @php
                    $syaratArray = is_string($pengajuan->jenisSurat->syarat_json)
                        ? json_decode($pengajuan->jenisSurat->syarat_json, true) ?? []
                        : $pengajuan->jenisSurat->syarat_json ?? [];
                    $syaratCount = count($syaratArray);
                @endphp

                @if($syaratCount > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Syarat yang Diperlukan</h5>
                    </div>
                    <div class="card-body">
                        <ol class="mb-0">
                            @foreach($syaratArray as $syarat)
                            <li>{{ $syarat }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif

                <!-- ✅ LAMPIRAN PENGAJUAN - VERSI FIXED -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-paperclip"></i> Lampiran Berkas
                            <span class="badge bg-primary">{{ $pengajuan->lampiranFiles->count() }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($pengajuan->lampiranFiles->count() > 0)
                        <div class="row">
                            @foreach($pengajuan->lampiranFiles as $media)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            @php
                                                $extension = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
                                                $icons = [
                                                    'pdf' => 'fas fa-file-pdf text-danger',
                                                    'doc' => 'fas fa-file-word text-primary',
                                                    'docx' => 'fas fa-file-word text-primary',
                                                    'xls' => 'fas fa-file-excel text-success',
                                                    'xlsx' => 'fas fa-file-excel text-success',
                                                    'jpg' => 'fas fa-file-image text-info',
                                                    'jpeg' => 'fas fa-file-image text-info',
                                                    'png' => 'fas fa-file-image text-info',
                                                    'txt' => 'fas fa-file-alt text-secondary',
                                                ];
                                                $icon = $icons[$extension] ?? 'fas fa-file text-secondary';
                                            @endphp
                                            <i class="{{ $icon }} fa-3x"></i>
                                        </div>
                                        <h6 class="card-title text-truncate" title="{{ $media->caption ?? $media->file_name }}">
                                            {{ $media->caption ?? $media->file_name }}
                                        </h6>
                                        <small class="text-muted d-block mb-2">{{ $media->mime_type }}</small>

                                        @php
                                            // Path file sesuai dengan controller Anda
                                            $filePath = 'media/pengajuan/' . $media->file_name;
                                            $fullPath = storage_path('app/public/' . $filePath);
                                            $fileExists = file_exists($fullPath);
                                        @endphp

                                        <small class="text-muted d-block mb-2">
                                            @if($fileExists)
                                                {{ round(filesize($fullPath) / 1024, 2) }} KB
                                            @else
                                                File tidak ditemukan
                                            @endif
                                        </small>

                                        <div class="mt-2">
                                            @if($fileExists)
                                                <a href="{{ asset('storage/' . $filePath) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-info"
                                                   title="Lihat">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <a href="{{ route('download.file', $media->media_id) }}"
                                                   class="btn btn-sm btn-success"
                                                   title="Download">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                <span class="badge bg-danger">File tidak ditemukan di storage</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada lampiran yang diunggah</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Timeline Status -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Riwayat Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @php
                                $statusHistory = [
                                    [
                                        'status' => 'draft',
                                        'label' => 'Draft',
                                        'time' => $pengajuan->created_at->format('d/m/Y H:i'),
                                        'active' => true,
                                    ],
                                    ['status' => 'diajukan', 'label' => 'Diajukan', 'time' => '-', 'active' => false],
                                    ['status' => 'diproses', 'label' => 'Diproses', 'time' => '-', 'active' => false],
                                    ['status' => 'selesai', 'label' => 'Selesai', 'time' => '-', 'active' => false],
                                ];
                            @endphp

                            @foreach ($statusHistory as $item)
                                <div class="timeline-item {{ $pengajuan->status == $item['status'] ? 'active' : '' }}">
                                    <div
                                        class="timeline-marker bg-{{ $pengajuan->status == $item['status'] ? 'primary' : 'secondary' }}">
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0">{{ $item['label'] }}</h6>
                                        <small class="text-muted">{{ $item['time'] }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($pengajuan->lampiranFiles->count() > 0)
                                @if($pengajuan->lampiranFiles->count() == 1)
                                    <a href="{{ route('download.file', $pengajuan->lampiranFiles->first()->media_id) }}"
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-download"></i> Download Lampiran
                                    </a>
                                @else
                                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#downloadAllModal">
                                        <i class="fas fa-file-archive"></i> Download Semua Lampiran
                                    </a>
                                @endif
                            @endif

                            <a href="#" class="btn btn-outline-success">
                                <i class="fas fa-print"></i> Cetak Surat
                            </a>

                            <form action="{{ route('pengajuan.destroy', $pengajuan->permohonan_id) }}" method="POST"
                                class="d-grid">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Hapus pengajuan ini?')">
                                    <i class="fas fa-trash"></i> Hapus Pengajuan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Status -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pengajuan.update-status', $pengajuan->permohonan_id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Ubah Status Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Baru</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft" {{ $pengajuan->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diproses" {{ $pengajuan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengajuan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Alasan perubahan status..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Download All -->
    <div class="modal fade" id="downloadAllModal" tabindex="-1" aria-labelledby="downloadAllModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadAllModalLabel">Download Semua Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Pilih format download:</p>
                    <div class="list-group">
                        @foreach($pengajuan->lampiranFiles as $media)
                            <a href="{{ route('download.file', $media->media_id) }}"
                               class="list-group-item list-group-item-action"
                               target="_blank">
                               <i class="fas fa-file me-2"></i> {{ $media->caption ?? $media->file_name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .timeline {
                position: relative;
                padding-left: 30px;
            }

            .timeline-item {
                position: relative;
                padding-bottom: 20px;
            }

            .timeline-marker {
                position: absolute;
                left: -30px;
                top: 0;
                width: 20px;
                height: 20px;
                border-radius: 50%;
            }

            .timeline-content {
                padding-left: 10px;
            }

            .timeline-item.active .timeline-marker {
                background-color: #0d6efd !important;
            }

            .timeline-item:not(:last-child)::after {
                content: '';
                position: absolute;
                left: -21px;
                top: 20px;
                width: 2px;
                height: calc(100% - 20px);
                background-color: #dee2e6;
            }

            .text-danger { color: #dc3545 !important; }
            .text-primary { color: #0d6efd !important; }
            .text-success { color: #198754 !important; }
            .text-info { color: #0dcaf0 !important; }
            .text-secondary { color: #6c757d !important; }
        </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Debug: Tampilkan info file di console
            @foreach($pengajuan->lampiranFiles as $media)
                @php
                    $path = 'media/pengajuan/' . $media->file_name;
                    $exists = file_exists(storage_path('app/public/' . $path));
                @endphp
                console.log('File: {{ $media->file_name }}');
                console.log('URL: {{ asset("storage/" . $path) }}');
                console.log('Exists: {{ $exists ? "Ya" : "Tidak" }}');
                console.log('---');
            @endforeach
        });
    </script>
    @endpush

    <div class="form-footer">
        <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
    </div>
@endsection
