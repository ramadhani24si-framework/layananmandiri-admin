@extends('layouts.app')

@section('title', 'Data User')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-0">Data User</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('user.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
        </div>

        {{-- ALERT SUCCESS --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ALERT WARNING (UNTUK PERINGATAN HAPUS AKUN SENDIRI) --}}
        @if (auth()->user() && session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- FILTER CARD --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter User</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('user.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-8">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary w-100">
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
                <h5 class="card-title mb-0">Daftar User</h5>
                <div class="text-muted">
                    <small>
                        <i class="fas fa-users"></i> Total: {{ $users->total() }} user
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>
                                        <strong>{{ $item->name }}</strong>
                                        @if ($item->id == auth()->id())
                                            <span class="badge bg-primary ms-2">Akun Anda</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('user.show', $item->id) }}" class="btn btn-sm btn-info"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- FORM DELETE DENGAN KONFIRMASI KHUSUS --}}
                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('{{ $item->id == auth()->id() ? '⚠️ PERINGATAN: Anda akan menghapus AKUN SENDIRI! Setelah dihapus, Anda akan otomatis logout. Yakin?' : 'Hapus user ' . $item->name . '?' }}')"
                                                    title="{{ $item->id == auth()->id() ? 'Hapus Akun Sendiri' : 'Hapus User' }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data user</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION FIX --}}
                @if($users->hasPages())
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
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $current = $users->currentPage();
                                $last = $users->lastPage();
                                $start = max($current - 2, 1);
                                $end = min($current + 2, $last);
                            @endphp

                            {{-- First Page --}}
                            @if ($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->url(1) }}">1</a>
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
                                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
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
                                    <a class="page-link" href="{{ $users->url($last) }}">{{ $last }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">&raquo;</a>
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
                            Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}
                            | Data {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }}
                        </small>
                    </div>
                </div>
                @endif

                {{-- STATS --}}
                @if(!$users->hasPages())
                <div class="mt-3 text-muted">
                    <small>
                        <i class="fas fa-info-circle"></i>
                        Menampilkan {{ $users->count() }} dari {{ $users->total() }} data
                        @if(request()->has('search'))
                            (dengan pencarian: "{{ request('search') }}")
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
        // Auto submit search saat tekan enter
        document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
@endpush
