@extends('layouts.app')

@section('title', 'Data Warga')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Data Warga</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('warga.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Warga
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

    {{-- FILTER CARD --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Filter Data Warga</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('warga.index') }}" class="mb-3">
                <div class="row g-2">
                    {{-- FILTER JENIS KELAMIN --}}
                    <div class="col-md-3">
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    {{-- FILTER AGAMA --}}
                    <div class="col-md-3">
                        <select name="agama" class="form-select">
                            <option value="">Semua Agama</option>
                            <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ request('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ request('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>

                    {{-- FILTER PEKERJAAN --}}
                    <div class="col-md-3">
                        <input type="text" name="pekerjaan" class="form-control"
                               placeholder="Pekerjaan" value="{{ request('pekerjaan') }}">
                    </div>

                    {{-- SEARCH --}}
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari NIK, nama, telp atau email..."
                               value="{{ request('search') }}">
                    </div>

                    {{-- BUTTONS --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DATA TABLE CARD --}}
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Warga</h5>
            <div class="text-muted">
                <small>
                    <i class="fas fa-users"></i> Total: {{ $warga->total() }} warga
                </small>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Agama</th>
                            <th>Pekerjaan</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warga as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($warga->currentPage() - 1) * $warga->perPage() }}</td>
                            <td>
                                <strong>{{ $item->no_ktp }}</strong>
                            </td>
                            <td>
                                <strong>{{ $item->nama }}</strong><br>
                                <small class="text-muted">
                                    {{ $item->alamat ? Str::limit($item->alamat, 30) : '-' }}
                                </small>
                            </td>
                            <td>
                                @php
                                    $jkBadge = $item->jenis_kelamin == 'L' ? 'primary' : 'danger';
                                    $jkText = $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
                                @endphp
                                <span class="badge bg-{{ $jkBadge }}">
                                    {{ $jkText }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $item->agama }}
                                </span>
                            </td>
                            <td>{{ $item->pekerjaan ?: '-' }}</td>
                            <td>{{ $item->telp ?: '-' }}</td>
                            <td>{{ $item->email ?: '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('warga.show', $item->warga_id) }}"
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('warga.edit', $item->warga_id) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('warga.destroy', $item->warga_id) }}"
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus data warga {{ $item->nama }}?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data warga</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION FIX --}}
            @if($warga->hasPages())
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
                        @if ($warga->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $warga->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $current = $warga->currentPage();
                            $last = $warga->lastPage();
                            $start = max($current - 2, 1);
                            $end = min($current + 2, $last);
                        @endphp

                        {{-- First Page --}}
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $warga->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $warga->url($i) }}">{{ $i }}</a>
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
                                <a class="page-link" href="{{ $warga->url($last) }}">{{ $last }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($warga->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $warga->nextPageUrl() }}" rel="next">&raquo;</a>
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
                        Halaman {{ $warga->currentPage() }} dari {{ $warga->lastPage() }}
                        | Data {{ $warga->firstItem() }} - {{ $warga->lastItem() }} dari {{ $warga->total() }}
                    </small>
                </div>
            </div>
            @endif

            {{-- STATS --}}
            @if(!$warga->hasPages())
            <div class="mt-3 text-muted">
                <small>
                    <i class="fas fa-info-circle"></i>
                    Menampilkan {{ $warga->count() }} dari {{ $warga->total() }} data
                    @if(request()->hasAny(['search', 'jenis_kelamin', 'agama', 'pekerjaan']))
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
    document.querySelectorAll('select[name="jenis_kelamin"], select[name="agama"]').forEach(select => {
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
