@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">📄 Daftar Data Warga</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('warga.create') }}" class="btn btn-primary mb-3">+ Tambah Data Warga</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>NO KTP</th>
                    <th>NAMA</th>
                    <th>Jenis Kelamin</th>
                    <th>Agama</th>
                    <th>Pekerjaan</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($warga as $p)
                    <tr>
                        <td>{{ $p->no_ktp }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->jenis_kelamin }}</td>
                        <td>{{ $p->agama }}</td>
                        <td>{{ $p->pekerjaan }}</td>
                        <td>{{ $p->telp }}</td>
                        <td>{{ $p->email }}</td>
                        <td>
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('warga.edit', $p->warga_id) }}" class="btn btn-warning btn-sm"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('warga.destroy', $p->warga_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tambahkan Font Awesome untuk icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
{{--index--}}
