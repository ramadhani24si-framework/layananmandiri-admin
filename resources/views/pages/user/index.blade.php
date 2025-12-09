@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<div class="container">
    <h1 class="mb-4">👤 Daftar User</h1>

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTER + SEARCH --}}
    <form method="GET" action="{{ route('user.index') }}" class="mb-3">
        <div class="row">

            {{-- FILTER URUTAN --}}
            <div class="col-md-3">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Urutkan</option>
                    <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected':'' }}>Nama A → Z</option>
                    <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected':'' }}>Nama Z → A</option>
                    <option value="latest" {{ request('sort')=='latest' ? 'selected':'' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort')=='oldest' ? 'selected':'' }}>Terlama</option>
                </select>
            </div>

            {{-- SEARCH --}}
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Cari nama atau email">

                    <button type="submit" class="input-group-text">🔍</button>

                    {{-- TOMBOL CLEAR --}}
                    @if(request()->hasAny(['search', 'sort']))
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary ms-2">Clear</a>
                    @endif
                </div>
            </div>

        </div>
    </form>

    <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">+ Tambah User</a>

    {{-- TABEL --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Dibuat</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataUser as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-action">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-action"
                                    onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $dataUser->links('pagination::bootstrap-5') }}
    </div>

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .d-flex.gap-1 {
        gap: 4px;
    }

    .btn-action {
        padding: 6px 8px;
        font-size: 12px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
