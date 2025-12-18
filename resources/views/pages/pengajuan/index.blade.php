@extends('layouts.app')

@section('title', 'Pengajuan Surat')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-0">Data Pengajuan Surat</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Pengajuan
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
                <h5 class="card-title mb-0">Filter Pengajuan</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('pengajuan.index') }}" class="mb-3">
                    <div class="row g-2">
                        {{-- FILTER STATUS --}}
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                @foreach ($statusList as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER JENIS SURAT --}}
                        <div class="col-md-3">
                            <select name="jenis_id" class="form-select">
                                <option value="">Semua Jenis Surat</option>
                                @foreach ($jenisSurat as $jenis)
                                    <option value="{{ $jenis->jenis_id }}"
                                        {{ request('jenis_id') == $jenis->jenis_id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER TANGGAL --}}
                        <div class="col-md-3">
                            <input type="date" name="tanggal_dari" class="form-control"
                                placeholder="Dari Tanggal" value="{{ request('tanggal_dari') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_sampai" class="form-control"
                                placeholder="Sampai Tanggal" value="{{ request('tanggal_sampai') }}">
                        </div>

                        {{-- SEARCH --}}
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nomor, nama warga, atau jenis surat..."
                                value="{{ request('search') }}">
                        </div>

                        {{-- BUTTONS --}}
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary w-100">
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
                <h5 class="card-title mb-0">Daftar Pengajuan</h5>
                <div class="text-muted">
                    <small>
                        <i class="fas fa-file-alt"></i> Total: {{ $pengajuan->total() }} pengajuan
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor</th>
                                <th>Warga</th>
                                <th>Jenis Surat</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuan as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}
                                    </td>
                                    <td>
                                        <strong>{{ $item->nomor_permohonan }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $item->warga->nama }}</strong>
                                            @if ($item->warga->no_ktp)
                                                <br>
                                                <small class="text-muted">
                                                    {{ $item->warga->no_ktp }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->jenisSurat->nama_jenis }}
                                        @if ($item->jenisSurat->kode)
                                            <br>
                                            <small class="text-muted">
                                                Kode: {{ $item->jenisSurat->kode }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $badgeColors = [
                                                'draft' => 'bg-secondary',
                                                'diajukan' => 'bg-primary',
                                                'diproses' => 'bg-warning',
                                                'selesai' => 'bg-success',
                                                'ditolak' => 'bg-danger',
                                            ];
                                            $statusTexts = [
                                                'draft' => 'Draft',
                                                'diajukan' => 'Diajukan',
                                                'diproses' => 'Diproses',
                                                'selesai' => 'Selesai',
                                                'ditolak' => 'Ditolak',
                                            ];
                                        @endphp
                                        <span class="badge {{ $badgeColors[$item->status] ?? 'bg-secondary' }}">
                                            {{ $statusTexts[$item->status] ?? $item->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('pengajuan.show', $item->permohonan_id) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pengajuan.edit', $item->permohonan_id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pengajuan.destroy', $item->permohonan_id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Hapus pengajuan ini?')" title="Hapus">
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
                                        <span class="text-muted">Tidak ada data pengajuan</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($pengajuan->hasPages())
                    <div class="mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination-fix">
                                {{-- Previous Page Link --}}
                                @if ($pengajuan->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pengajuan->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $current = $pengajuan->currentPage();
                                    $last = $pengajuan->lastPage();
                                    $start = max($current - 2, 1);
                                    $end = min($current + 2, $last);
                                @endphp

                                {{-- First Page --}}
                                @if ($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pengajuan->url(1) }}">1</a>
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
                                            <a class="page-link" href="{{ $pengajuan->url($i) }}">{{ $i }}</a>
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
                                        <a class="page-link" href="{{ $pengajuan->url($last) }}">{{ $last }}</a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($pengajuan->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pengajuan->nextPageUrl() }}" rel="next">&raquo;</a>
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
                                Halaman {{ $pengajuan->currentPage() }} dari {{ $pengajuan->lastPage() }}
                                | Data {{ $pengajuan->firstItem() }} - {{ $pengajuan->lastItem() }} dari
                                {{ $pengajuan->total() }}
                            </small>
                        </div>
                    </div>
                @endif

                {{-- STATS --}}
                @if (!$pengajuan->hasPages())
                    <div class="mt-3 text-muted">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            Menampilkan {{ $pengajuan->count() }} dari {{ $pengajuan->total() }} data
                            @if (request()->hasAny(['search', 'status', 'jenis_id', 'tanggal_dari', 'tanggal_sampai']))
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

@push('styles')
    <style>
        /* Pagination fix styles - Same as jenis surat */
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
@endpush

@push('scripts')
    <script>
        // Auto submit filter saat select berubah
        document.querySelectorAll('select[name="status"], select[name="jenis_id"]').forEach(select => {
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
