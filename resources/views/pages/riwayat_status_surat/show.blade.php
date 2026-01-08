@extends('layouts.app')

@section('title', 'Detail Riwayat Status Surat')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Detail Riwayat Status</h2>
            @if(isset($riwayat) && $riwayat->pengajuan)
                <p class="text-muted mb-0">
                    Pengajuan: <strong>{{ $riwayat->pengajuan->nomor_permohonan ?? 'N/A' }}</strong>
                </p>
            @endif
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('riwayat_status_surat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    @if(!isset($riwayat) || !$riwayat)
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle"></i> Data tidak ditemukan!</h5>
            <p>Riwayat status yang dimaksud tidak ditemukan di database.</p>
            <a href="{{ route('riwayat_status_surat.index') }}" class="btn btn-sm btn-secondary">
                Kembali ke Daftar
            </a>
        </div>
    @else
    <div class="row">
        <!-- Informasi Utama -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informasi Riwayat Status</h5>
                    @if($riwayat->pengajuan)
                        <a href="{{ route('pengajuan.show', $riwayat->permohonan_id) }}"
                           class="btn btn-light btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat Pengajuan
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th width="35%">ID Riwayat</th>
                                <td>{{ $riwayat->riwayat_id }}</td>
                            </tr>
                            <tr>
                                <th>Pengajuan Terkait</th>
                                <td>
                                    @if($riwayat->pengajuan)
                                        <div>
                                            <strong>{{ $riwayat->pengajuan->nomor_permohonan ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">
                                                <i class="fas fa-user"></i>
                                                {{ $riwayat->pengajuan->warga->nama ?? 'N/A' }}<br>
                                                <i class="fas fa-file-alt"></i>
                                                {{ $riwayat->pengajuan->jenisSurat->nama_jenis ?? 'N/A' }}
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-circle"></i> Pengajuan sudah dihapus
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-{{ $riwayat->status_badge }} fs-6">
                                        {{ ucfirst($riwayat->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Petugas</th>
                                <td>
                                    @if($riwayat->petugas)
                                        <div>
                                            <strong>{{ $riwayat->petugas->nama }}</strong><br>
                                            <small class="text-muted">
                                                NIK: {{ $riwayat->petugas->no_ktp ?? '-' }}<br>
                                                Telp: {{ $riwayat->petugas->telp ?? '-' }}
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-robot"></i> System / Automatis
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Waktu Perubahan</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <div>
                                            <div>{{ $riwayat->waktu->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $riwayat->waktu->format('H:i:s') }}</small>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>
                                    @if($riwayat->keterangan)
                                        <div class="card card-body bg-light mt-2">
                                            <i class="fas fa-quote-left text-muted me-2"></i>
                                            {{ $riwayat->keterangan }}
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Status Pengajuan Sekarang -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Status Pengajuan Saat Ini
                    </h5>
                </div>
                <div class="card-body">
                    @if($riwayat->pengajuan)
                        <div class="text-center mb-4">
                            <span class="badge bg-{{ $riwayat->pengajuan->status_badge }} fs-5 p-3 mb-3 d-block">
                                {{ $riwayat->pengajuan->status_text }}
                            </span>

                            <div class="mb-3">
                                <small class="text-muted d-block">Tanggal Pengajuan</small>
                                <strong>{{ \Carbon\Carbon::parse($riwayat->pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</strong>
                            </div>

                            @if($riwayat->pengajuan->catatan)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Catatan Pengajuan</small>
                                    <div class="mt-1 p-2 bg-light rounded small">
                                        {{ Str::limit($riwayat->pengajuan->catatan, 100) }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                            <p>Pengajuan sudah dihapus dari sistem</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Aksi Cepat -->
            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt"></i> Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($riwayat->pengajuan)
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#createStatusModal">
                                <i class="fas fa-plus-circle"></i> Buat Status Baru
                            </button>
                        @endif

                        <form action="{{ route('riwayat_status_surat.destroy', $riwayat->riwayat_id) }}"
                              method="POST" class="d-grid"
                              onsubmit="return confirm('Hapus riwayat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i> Hapus Riwayat
                            </button>
                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    @endif

    <!-- Modal untuk Buat Status Baru -->
    @if(isset($riwayat) && $riwayat->pengajuan)
    <div class="modal fade" id="createStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('riwayat_status_surat.create-from-pengajuan', $riwayat->permohonan_id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-plus-circle me-2"></i>Buat Status Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            Mengubah status untuk pengajuan:
                            <strong>{{ $riwayat->pengajuan->nomor_permohonan }}</strong>
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Status Baru <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="draft">Draft</option>
                                <option value="diajukan">Diajukan</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control"
                                      rows="3" placeholder="Alasan perubahan status..."></textarea>
                            <small class="text-muted">Opsional</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Status
                        </button>
                    </div>
                </form>
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
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
    }
    .card-header.bg-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
    .badge.fs-5 {
        font-size: 1.1rem;
        padding: 0.5em 1em;
    }
    .badge.fs-6 {
        font-size: 1rem;
        padding: 0.4em 0.8em;
    }
    .btn-light {
        background-color: rgba(255, 255, 255, 0.9);
        border-color: rgba(255, 255, 255, 0.5);
    }
    .btn-light:hover {
        background-color: #fff;
        border-color: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Riwayat ID: {{ $riwayat->riwayat_id ?? "N/A" }}');

        // Auto-focus pada modal select
        $('#createStatusModal').on('shown.bs.modal', function () {
            $(this).find('select[name="status"]').focus();
        });
    });
</script>
@endpush
@endsection
