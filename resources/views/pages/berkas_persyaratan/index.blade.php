@extends('layouts.app')

@section('title', 'Berkas Persyaratan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Data Berkas Persyaratan</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('berkas_persyaratan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Berkas
            </a>
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

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Filter Berkas</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('berkas_persyaratan.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-3">
                        <select name="valid" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach($statusList as $value => $label)
                            <option value="{{ $value }}" {{ request('valid') == $value ? 'selected' : '' }}>
                                {{ $label }}
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
                               placeholder="Cari nama berkas, nama warga, atau nomor permohonan..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('berkas_persyaratan.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Berkas Persyaratan</h5>
            <div class="text-muted">
                <small>
                    <i class="fas fa-file-alt"></i> Total: {{ $berkas->total() }} berkas
                </small>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Berkas</th>
                            <th>Pengajuan</th>
                            <th>Jumlah File</th>
                            <th>Status Validasi</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($berkas as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($berkas->currentPage() - 1) * $berkas->perPage() }}</td>
                            <td>
                                <strong>{{ $item->nama_berkas }}</strong>
                                @if($item->media->count() > 0)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-paperclip me-1"></i>
                                        {{ $item->media->count() }} file terlampir
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($item->pengajuan)
                                    <strong>{{ $item->pengajuan->nomor_permohonan }}</strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $item->pengajuan->warga->nama ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->media->count() > 0)
                                    <span class="badge bg-info">
                                        <i class="fas fa-file me-1"></i>
                                        {{ $item->media->count() }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">0</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = [
                                        'menunggu' => 'bg-warning',
                                        'valid' => 'bg-success',
                                        'tidak_valid' => 'bg-danger',
                                    ][$item->valid] ?? 'secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $statusList[$item->valid] ?? $item->valid }}
                                </span>
                            </td>
                            <td>
                                {{ $item->created_at->format('d/m/Y') }}<br>
                                <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('berkas_persyaratan.show', $item->berkas_id) }}"
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('berkas_persyaratan.edit', $item->berkas_id) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('berkas_persyaratan.destroy', $item->berkas_id) }}"
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus berkas ini beserta semua file?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i><br>
                                <span class="text-muted">Tidak ada data berkas</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($berkas->hasPages())
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
                        @if ($berkas->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $berkas->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $current = $berkas->currentPage();
                            $last = $berkas->lastPage();
                            $start = max($current - 2, 1);
                            $end = min($current + 2, $last);
                        @endphp

                        {{-- First Page --}}
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $berkas->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $berkas->url($i) }}">{{ $i }}</a>
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
                                <a class="page-link" href="{{ $berkas->url($last) }}">{{ $last }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($berkas->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $berkas->nextPageUrl() }}" rel="next">&raquo;</a>
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
                        Halaman {{ $berkas->currentPage() }} dari {{ $berkas->lastPage() }}
                        | Data {{ $berkas->firstItem() }} - {{ $berkas->lastItem() }} dari {{ $berkas->total() }}
                    </small>
                </div>
            </div>
            @endif

            {{-- STATS --}}
            @if(!$berkas->hasPages())
            <div class="mt-3 text-muted">
                <small>
                    <i class="fas fa-info-circle"></i>
                    Menampilkan {{ $berkas->count() }} dari {{ $berkas->total() }} data
                    @if(request()->hasAny(['search', 'valid', 'tanggal_dari', 'tanggal_sampai']))
                        (dengan filter)
                    @endif
                </small>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto submit filter saat select berubah
    document.querySelectorAll('select[name="valid"]').forEach(select => {
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
