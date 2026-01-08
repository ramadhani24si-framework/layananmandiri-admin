@extends('layouts.app')

@section('title', 'Riwayat Status Surat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Riwayat Status Surat</h2>
        </div>
        {{-- <div class="col-md-6 text-end">
            <a href="{{ route('riwayat_status_surat.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Riwayat
            </a>
        </div>
    </div> --}}

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

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Filter Riwayat</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('riwayat_status_surat.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach($statusList as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="permohonan_id" class="form-select">
                            <option value="">Semua Pengajuan</option>
                            @foreach($pengajuanList as $pengajuan)
                            <option value="{{ $pengajuan->permohonan_id }}" {{ request('permohonan_id') == $pengajuan->permohonan_id ? 'selected' : '' }}>
                                {{ $pengajuan->nomor_permohonan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="tanggal_dari" class="form-control"
                               placeholder="Dari Tanggal" value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="tanggal_sampai" class="form-control"
                               placeholder="Sampai Tanggal" value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari status, keterangan, nomor pengajuan..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('riwayat_status_surat.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Riwayat Status</h5>
            <div class="text-muted">
                <small>
                    <i class="fas fa-history"></i> Total: {{ $riwayatStatus->total() }} riwayat
                </small>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pengajuan</th>
                            <th>Status</th>
                            <th>Petugas</th>
                            <th>Keterangan</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatStatus as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($riwayatStatus->currentPage() - 1) * $riwayatStatus->perPage() }}</td>
                            <td>
                                @if($item->pengajuan)
                                    <strong>{{ $item->pengajuan->nomor_permohonan }}</strong><br>
                                    <small class="text-muted">
                                        {{ $item->pengajuan->warga->nama ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->status_badge }}">
                                    {{ $statusList[$item->status] ?? $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->petugas->nama ?? 'System' }}</td>
                            <td>{{ Str::limit($item->keterangan, 50) }}</td>
                            <td>{{ $item->waktu_formatted }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('riwayat_status_surat.show', $item->riwayat_id) }}"
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- <a href="{{ route('riwayat_status_surat.edit', $item->riwayat_id) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}
                                    <form action="{{ route('riwayat_status_surat.destroy', $item->riwayat_id) }}"
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus riwayat ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data riwayat</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION FIX --}}
            @if($riwayatStatus->hasPages())
            <div class="mt-4">
                <style>
                    /* Pagination fix styles */
                    .pagination-fix {
                        display: flex !important;
                        justify-content: center !important;
                        flex-wrap: wrap !important;
                        padding-left: 0 !important;
                        list-style: none !important;
                        margin: 0 !important;
                        gap: 4px !important;
                    }

                    .pagination-fix .page-item {
                        display: inline-block !important;
                        margin: 0 !important;
                    }

                    .pagination-fix .page-link {
                        display: block !important;
                        padding: 0.5rem 0.75rem !important;
                        border: 1px solid #dee2e6 !important;
                        border-radius: 0.25rem !important;
                        color: #0d6efd !important;
                        text-decoration: none !important;
                        background: white !important;
                        transition: all 0.15s ease !important;
                        min-width: 38px;
                        text-align: center;
                    }

                    .pagination-fix .page-item.active .page-link {
                        background: #0d6efd !important;
                        color: white !important;
                        border-color: #0d6efd !important;
                        font-weight: 500;
                    }

                    .pagination-fix .page-item.disabled .page-link {
                        color: #6c757d !important;
                        background: #f8f9fa !important;
                        pointer-events: none !important;
                        opacity: 0.7;
                    }

                    .pagination-fix .page-link:hover:not(.active) {
                        background: #e9ecef !important;
                        border-color: #dee2e6 !important;
                        color: #0a58ca !important;
                    }
                </style>

                <nav aria-label="Page navigation">
                    <ul class="pagination-fix">
                        {{-- Previous Page Link --}}
                        @if ($riwayatStatus->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $riwayatStatus->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $current = $riwayatStatus->currentPage();
                            $last = $riwayatStatus->lastPage();
                            $start = max($current - 2, 1);
                            $end = min($current + 2, $last);
                        @endphp

                        {{-- First Page --}}
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $riwayatStatus->url(1) }}">1</a>
                            </li>
                            @if ($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        {{-- Page Numbers --}}
                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ ($i == $current) ? 'active' : '' }}">
                                @if ($i == $current)
                                    <span class="page-link">{{ $i }}</span>
                                @else
                                    <a class="page-link" href="{{ $riwayatStatus->url($i) }}">{{ $i }}</a>
                                @endif
                            </li>
                        @endfor

                        {{-- Last Page --}}
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $riwayatStatus->url($last) }}">{{ $last }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($riwayatStatus->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $riwayatStatus->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>

                {{-- Page info --}}
                <div class="text-center text-muted mt-2">
                    <small>
                        Halaman {{ $riwayatStatus->currentPage() }} dari {{ $riwayatStatus->lastPage() }}
                        | Data {{ $riwayatStatus->firstItem() }} - {{ $riwayatStatus->lastItem() }} dari {{ $riwayatStatus->total() }}
                    </small>
                </div>
            </div>
            @endif

            {{-- STATS --}}
            @if(!$riwayatStatus->hasPages())
            <div class="mt-3 text-muted">
                <small>
                    <i class="fas fa-info-circle"></i>
                    Menampilkan {{ $riwayatStatus->count() }} dari {{ $riwayatStatus->total() }} data
                    @if(request()->hasAny(['search', 'status', 'permohonan_id', 'tanggal_dari', 'tanggal_sampai']))
                        (dengan filter)
                    @endif
                </small>
            </div>
            @endif
        </div>
    </div>
     <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto submit filter saat select berubah
    document.querySelectorAll('select[name="status"], select[name="permohonan_id"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Auto submit search saat tekan enter
    document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
</script>
@endpush
