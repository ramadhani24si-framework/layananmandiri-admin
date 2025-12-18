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
                    $syaratArray = $pengajuan->jenisSurat->syarat_json;
                    $syaratCount = is_array($syaratArray) ? count($syaratArray) : 0;
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

                <!-- ✅ LAMPIRAN PENGAJUAN -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-paperclip"></i> Lampiran Berkas
                            <span class="badge bg-primary">{{ $pengajuan->lampiran_count }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($pengajuan->lampiran_count > 0)
                        <div class="row">
                            @foreach($pengajuan->lampiranFiles as $media)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="{{ $media->getIcon() }} fa-3x text-primary"></i>
                                        </div>
                                        <h6 class="card-title text-truncate" title="{{ $media->caption ?? $media->file_name }}">
                                            {{ $media->caption ?? $media->file_name }}
                                        </h6>
                                        <small class="text-muted d-block mb-2">{{ $media->mime_type }}</small>

                                        <div class="mt-2">
                                            <a href="{{ $media->getFileUrl() }}"
                                               target="_blank" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ $media->getFileUrl() }}"
                                               download class="btn btn-sm btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
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
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-print"></i> Cetak Surat
                            </a>
                            <a href="#" class="btn btn-outline-success">
                                <i class="fas fa-download"></i> Unduh Berkas
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
                                <option value="draft" {{ $pengajuan->status == 'draft' ? 'selected' : '' }}>Draft
                                </option>
                                <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>Diajukan
                                </option>
                                <option value="diproses" {{ $pengajuan->status == 'diproses' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="selesai" {{ $pengajuan->status == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
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
        </style>
    @endpush
     <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
@endsection
