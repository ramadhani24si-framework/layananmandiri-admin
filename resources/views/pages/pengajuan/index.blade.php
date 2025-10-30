@extends('layouts.app')

@section('title', 'Daftar Pengajuan Surat')

@section('content')
<div class="container">
    <h1 class="mb-4">📄 Daftar Pengajuan Surat</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pengajuan.create') }}" class="btn btn-primary mb-3">+ Tambah Pengajuan</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Pemohon</th>
                <th>Jenis Surat</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $p)
                <tr>
                    <td>{{ $p->pengajuan_id }}</td>
                    <td>{{ $p->nama_pemohon }}</td>
                    <td>{{ $p->jenis_surat }}</td>
                    <td>{{ $p->keterangan }}</td>
                    <td>
                        <span class="badge bg-{{ $p->status == 'Menunggu' ? 'secondary' : ($p->status == 'Diproses' ? 'warning' : 'success') }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('pengajuan.edit', $p->pengajuan_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pengajuan.destroy', $p->pengajuan_id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada pengajuan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
