@extends('layouts.app')

@section('title', 'Daftar Jenis Surat')

@section('content')
    <div class="container">
        <h1 class="mb-4">📄 Daftar Jenis Surat</h1>

        <a href="{{ route('jenis_surat.create') }}" class="btn btn-primary mb-3">+ Tambah Jenis Surat</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Jenis</th>
                    <th>Syarat</th>
                    <th width="160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->nama_jenis }}</td>
                        <td>
                            @if ($item->syarat_json)
                                @php
                                    $syarat = json_decode($item->syarat_json, true);
                                @endphp
                                @if (is_array($syarat))
                                    {{ implode(', ', $syarat) }}
                                @else
                                    {{ $syarat }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('jenis_surat.edit', $item->jenis_id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('jenis_surat.destroy', $item->jenis_id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
