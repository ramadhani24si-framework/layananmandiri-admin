@extends('layouts.app')

@section('title', 'Jenis Surat')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-0">Data Jenis Surat</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('jenis_surat.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Jenis Surat
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- FILTER CARD --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Jenis Surat</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('jenis_surat.index') }}" class="mb-3">
                    <div class="row g-2">
                        {{-- FILTER KODE --}}
                        <div class="col-md-4">
                            <input type="text" name="kode" class="form-control" placeholder="Kode"
                                value="{{ request('kode') }}">
                        </div>

                        {{-- FILTER JUMLAH SYARAT --}}
                        <div class="col-md-4">
                            <select name="syarat_count" class="form-select">
                                <option value="">Jumlah Syarat</option>
                                <option value="0" {{ request('syarat_count') == '0' ? 'selected' : '' }}>Tanpa Syarat
                                </option>
                                <option value="1-3" {{ request('syarat_count') == '1-3' ? 'selected' : '' }}>1-3 Syarat
                                </option>
                                <option value="4-6" {{ request('syarat_count') == '4-6' ? 'selected' : '' }}>4-6 Syarat
                                </option>
                                <option value="7+" {{ request('syarat_count') == '7+' ? 'selected' : '' }}>7+ Syarat
                                </option>
                            </select>
                        </div>

                        {{-- SEARCH --}}
                        <div class="col-md-8">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari kode, nama jenis surat, atau keterangan..."
                                value="{{ request('search') }}">
                        </div>

                        {{-- BUTTONS --}}
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('jenis_surat.index') }}" class="btn btn-secondary w-100">
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
                <h5 class="card-title mb-0">Daftar Jenis Surat</h5>
                <div class="text-muted">
                    <small>
                        <i class="fas fa-file-alt"></i> Total: {{ $jenisSurat->total() }} jenis surat
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Kode</th>
                                <th>Nama Jenis Surat</th>
                                <th>Jumlah Syarat</th>
                                <th>Template Files</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jenisSurat as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($jenisSurat->currentPage() - 1) * $jenisSurat->perPage() }}
                                    </td>
                                    <td>
                                        <strong>{{ $item->kode }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $item->nama_jenis }}</strong>
                                        @if ($item->keterangan)
                                            <br>
                                            <small class="text-muted">
                                                {{ Str::limit($item->keterangan, 50) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->syarat_count > 0)
                                            <span class="badge bg-info" title="Klik detail untuk melihat syarat lengkap">
                                                {{ $item->syarat_count }} syarat
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $mediaCount = $item->mediaFiles ? $item->mediaFiles->count() : 0;
                                        @endphp
                                        @if ($mediaCount > 0)
                                            <span class="badge bg-success">
                                                <i class="fas fa-file"></i> {{ $mediaCount }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('jenis_surat.show', $item->jenis_id) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jenis_surat.edit', $item->jenis_id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('jenis_surat.destroy', $item->jenis_id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Hapus jenis surat {{ $item->nama_jenis }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data jenis surat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION FIX --}}
                @if ($jenisSurat->hasPages())
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
                                @if ($jenisSurat->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $jenisSurat->previousPageUrl() }}"
                                            rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $current = $jenisSurat->currentPage();
                                    $last = $jenisSurat->lastPage();
                                    $start = max($current - 2, 1);
                                    $end = min($current + 2, $last);
                                @endphp

                                {{-- First Page --}}
                                @if ($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $jenisSurat->url(1) }}">1</a>
                                    </li>
                                    @if ($start > 2)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endif

                                {{-- Page Numbers --}}
                                @for ($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                        @if ($i == $current)
                                            <span class="page-link">{{ $i }}</span>
                                        @else
                                            <a class="page-link"
                                                href="{{ $jenisSurat->url($i) }}">{{ $i }}</a>
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
                                        <a class="page-link"
                                            href="{{ $jenisSurat->url($last) }}">{{ $last }}</a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($jenisSurat->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $jenisSurat->nextPageUrl() }}"
                                            rel="next">&raquo;</a>
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
                                Halaman {{ $jenisSurat->currentPage() }} dari {{ $jenisSurat->lastPage() }}
                                | Data {{ $jenisSurat->firstItem() }} - {{ $jenisSurat->lastItem() }} dari
                                {{ $jenisSurat->total() }}
                            </small>
                        </div>
                    </div>
                @endif

                {{-- STATS --}}
                @if (!$jenisSurat->hasPages())
                    <div class="mt-3 text-muted">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            Menampilkan {{ $jenisSurat->count() }} dari {{ $jenisSurat->total() }} data
                            @if (request()->hasAny(['search', 'kode', 'syarat_count']))
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
        document.querySelectorAll('select[name="syarat_count"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
@endpush
