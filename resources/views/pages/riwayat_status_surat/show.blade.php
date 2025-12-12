@extends('layouts.app')

@section('title', 'Detail Riwayat Status Surat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Detail Riwayat Status</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('riwayat_status_surat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('riwayat_status_surat.edit', $riwayat->riwayat_id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Riwayat</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">ID Riwayat</th>
                            <td>{{ $riwayat->riwayat_id }}</td>
                        </tr>
                        <tr>
                            <th>Pengajuan</th>
                            <td>
                                @if($riwayat->pengajuan)
                                    <strong>{{ $riwayat->pengajuan->nomor_permohonan }}</strong><br>
                                    <small class="text-muted">
                                        Warga: {{ $riwayat->pengajuan->warga->nama ?? '-' }}<br>
                                        Jenis: {{ $riwayat->pengajuan->jenisSurat->nama_jenis ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $riwayat->status_badge }}">
                                    {{ ucfirst($riwayat->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Petugas</th>
                            <td>
                                @if($riwayat->petugas)
                                    {{ $riwayat->petugas->nama }}<br>
                                    <small class="text-muted">
                                        {{ $riwayat->petugas->role ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-muted">System / Automatis</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Waktu</th>
                            <td>{{ $riwayat->waktu_formatted }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $riwayat->keterangan ?: '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Pengajuan Terkini</h5>
                </div>
                <div class="card-body">
                    @if($riwayat->pengajuan)
                        <div class="mb-3">
                            <strong>Status Saat Ini:</strong><br>
                            <span class="badge bg-{{ $riwayat->pengajuan->status_badge }}">
                                {{ $riwayat->pengajuan->status_text }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>Tanggal Pengajuan:</strong><br>
                            {{ $riwayat->pengajuan->tanggal_pengajuan->format('d/m/Y') }}
                        </div>
                        <div class="mb-3">
                            <strong>Catatan:</strong><br>
                            {{ $riwayat->pengajuan->catatan ?: '-' }}
                        </div>
                        <a href="{{ route('pengajuan.show', $riwayat->permohonan_id) }}"
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt"></i> Lihat Pengajuan
                        </a>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                            <p>Data pengajuan tidak ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
