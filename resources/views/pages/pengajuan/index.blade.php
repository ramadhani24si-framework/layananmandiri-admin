@extends('layouts.app')

@section('title', 'Daftar Pengajuan Surat')

@section('content')
    <div class="container">
        <h1 class="mb-4">📄 Daftar Pengajuan Surat</h1>

        @if (session('success'))
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
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $p)
                    <tr>
                        <td>{{ $p->pengajuan_id }}</td>
                        <td>{{ $p->nama_pemohon }}</td>
                        <td>{{ $p->jenisSurat->nama_jenis ?? '-' }}</td> <!-- UBAH INI -->
                        <td>{{ $p->keterangan }}</td>
                        <td>
                            <span
                                class="badge bg-{{ $p->status == 'Menunggu' ? 'secondary' : ($p->status == 'Diproses' ? 'warning' : 'success') }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('pengajuan.edit', $p->pengajuan_id) }}" class="btn btn-warning btn-action"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pengajuan.destroy', $p->pengajuan_id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-action"
                                        onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pengajuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tambahkan Font Awesome untuk icons -->
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
        table th:nth-child(6),
        table td:nth-child(6) {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endsection
