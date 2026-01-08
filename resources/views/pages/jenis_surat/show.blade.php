@extends('layouts.app')

@section('title', 'Detail Jenis Surat')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-0">Detail Jenis Surat</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('jenis_surat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Informasi Jenis Surat</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th width="30%">Kode</th>
                                <td>
                                    <span class="badge bg-info fs-6">{{ $jenisSurat->kode }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Jenis Surat</th>
                                <td><strong>{{ $jenisSurat->nama_jenis }}</strong></td>
                            </tr>
                            <tr>
                                <th>Total Pengajuan</th>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $jenisSurat->pengajuans->count() }} pengajuan
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Syarat</th>
                                <td>
                                    <span class="badge bg-{{ $jenisSurat->syarat_count > 0 ? 'success' : 'warning' }}">
                                        {{ $jenisSurat->syarat_count }} syarat
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $jenisSurat->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate</th>
                                <td>{{ $jenisSurat->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($jenisSurat->syarat_count > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list-check"></i> Daftar Syarat
                            </h5>
                        </div>
                        <div class="card-body">
                            <ol class="mb-0 ps-3">
                                @php
                                    $syaratArray = is_string($jenisSurat->syarat_json)
                                        ? json_decode($jenisSurat->syarat_json, true) ?? []
                                        : $jenisSurat->syarat_json ?? [];
                                @endphp
                                @foreach ($syaratArray as $index => $syarat)
                                    <li class="mb-2">{{ $syarat }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-alt"></i> Template Files
                            @if($jenisSurat->mediaFiles->count() > 0)
                                <span class="badge bg-light text-dark">{{ $jenisSurat->mediaFiles->count() }}</span>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($jenisSurat->mediaFiles->count() > 0)
                            <div class="list-group">
                                @foreach ($jenisSurat->mediaFiles as $media)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-1">
                                                    @php
                                                        $extension = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
                                                        $icons = [
                                                            'pdf' => 'fas fa-file-pdf text-danger',
                                                            'doc' => 'fas fa-file-word text-primary',
                                                            'docx' => 'fas fa-file-word text-primary',
                                                            'xls' => 'fas fa-file-excel text-success',
                                                            'xlsx' => 'fas fa-file-excel text-success',
                                                            'jpg' => 'fas fa-image text-warning',
                                                            'jpeg' => 'fas fa-image text-warning',
                                                            'png' => 'fas fa-image text-warning',
                                                        ];
                                                        $icon = $icons[$extension] ?? 'fas fa-file text-secondary';
                                                    @endphp
                                                    <i class="{{ $icon }} me-2"></i>
                                                    <strong>{{ $media->caption ?? $media->file_name }}</strong>
                                                </div>
                                                <small class="text-muted d-block">
                                                    {{ strtoupper($extension) }} •
                                                    @php
                                                        $filePath = 'media/jenis_surat/' . $media->file_name;
                                                        $fullPath = storage_path('app/public/' . $filePath);
                                                        if(file_exists($fullPath)) {
                                                            echo round(filesize($fullPath) / 1024, 2) . ' KB';
                                                        }
                                                    @endphp
                                                </small>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2 mt-2">
                                            <!-- Tombol Lihat (hanya untuk file yang bisa dilihat di browser) -->
                                            @if(in_array($extension, ['pdf', 'jpg', 'jpeg', 'png']))
                                                <a href="{{ asset('storage/' . $filePath) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-info flex-fill"
                                                   title="Lihat File">
                                                    <i class="fas fa-eye me-1"></i> Lihat
                                                </a>
                                            @endif

                                            <!-- Tombol Download -->
                                            <a href="{{ route('download.template', $media->media_id) }}"
                                               class="btn btn-sm btn-success flex-fill"
                                               title="Download File">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada template file</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- <!-- Aksi Cepat -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt"></i> Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('jenis_surat.edit', $jenisSurat->jenis_id) }}"
                               class="btn btn-outline-warning">
                                <i class="fas fa-edit me-1"></i> Edit Jenis Surat
                            </a>

                            <!-- Tombol Lihat Pengajuan -->
                            <a href="{{ route('pengajuan.index', ['jenis_id' => $jenisSurat->jenis_id]) }}"
                               class="btn btn-outline-primary">
                                <i class="fas fa-list me-1"></i> Lihat Pengajuan
                            </a> --}}

                            <!-- Tombol Download All (hanya jika ada lebih dari 1 template) -->
                            {{-- @if($jenisSurat->mediaFiles->count() > 1)
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#downloadAllModal">
                                    <i class="fas fa-file-archive me-1"></i> Download Semua Template
                                </button>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Download All -->
        @if($jenisSurat->mediaFiles->count() > 1)
        <div class="modal fade" id="downloadAllModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-download me-2"></i> Pilih Template untuk Download
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-3">Pilih file yang ingin diunduh:</p>
                        <div class="list-group">
                            @foreach($jenisSurat->mediaFiles as $media)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @php
                                            $extension = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
                                            $icons = [
                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                'doc' => 'fas fa-file-word text-primary',
                                                'docx' => 'fas fa-file-word text-primary',
                                                'xls' => 'fas fa-file-excel text-success',
                                                'xlsx' => 'fas fa-file-excel text-success',
                                            ];
                                            $icon = $icons[$extension] ?? 'fas fa-file text-secondary';
                                        @endphp
                                        <i class="{{ $icon }} me-2"></i>
                                        <span>{{ $media->caption ?? $media->file_name }}</span>
                                    </div>
                                    <div>
                                        <!-- Tombol Lihat untuk file tertentu -->
                                        @if(in_array($extension, ['pdf', 'jpg', 'jpeg', 'png']))
                                            <a href="{{ asset('storage/media/jenis_surat/' . $media->file_name) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-info me-1"
                                               title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif

                                        <!-- Tombol Download -->
                                        <a href="{{ route('download.template', $media->media_id) }}"
                                           class="btn btn-sm btn-outline-success"
                                           title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
    </div>

    @push('styles')
    <style>
        .card-header.bg-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }
        .card-header.bg-info {
            background: linear-gradient(135deg, #0dcaf0 0%, #0ba2c0 100%);
        }
        .badge.fs-6 {
            font-size: 0.9rem;
            padding: 0.3em 0.6em;
        }
        .text-danger { color: #dc3545 !important; }
        .text-primary { color: #0d6efd !important; }
        .text-success { color: #198754 !important; }
        .text-warning { color: #ffc107 !important; }
        .text-secondary { color: #6c757d !important; }
        .list-group-item .btn {
            min-width: 80px;
        }
        .list-group-item {
            border-left: 3px solid #dee2e6;
            transition: all 0.2s;
        }
        .list-group-item:hover {
            border-left-color: #0d6efd;
            background-color: #f8f9fa;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Detail Jenis Surat: {{ $jenisSurat->kode }} - {{ $jenisSurat->nama_jenis }}');
        });
    </script>
    @endpush
@endsection
