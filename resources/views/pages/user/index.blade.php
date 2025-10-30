@extends('layouts.app')

@section('content')
<main class="container my-5" id="user">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Data User</h2>
        <p class="text-muted">Berikut adalah daftar user yang telah terdaftar dalam sistem.</p>
    </div>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse ($dataUser as $item)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">{{ $item->name }}</h5>
                        <p class="card-text text-muted">{{ $item->email }}</p>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('user.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada data user.</p>
        @endforelse
    </div>

    <div class="text-end mt-3">
        <a href="{{ route('user.create') }}" class="btn btn-primary">+ Tambah User</a>
    </div>
</main>
@endsection
