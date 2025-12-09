@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">📄 Daftar Data Warga</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTER + SEARCH --}}
    <form method="GET" action="{{ route('warga.index') }}" class="mb-3">
        <div class="row">

            {{-- FILTER JENIS KELAMIN --}}
            <div class="col-md-2">
                <select name="jenis_kelamin" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kelamin</option>
                    <option value="L" {{ request('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                </select>
            </div>

            {{-- FILTER AGAMA --}}
            <div class="col-md-2">
                <select name="agama" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Agama</option>
                    <option value="Islam" {{ request('agama')=='Islam'?'selected':'' }}>Islam</option>
                    <option value="Kristen" {{ request('agama')=='Kristen'?'selected':'' }}>Kristen</option>
                    <option value="Katolik" {{ request('agama')=='Katolik'?'selected':'' }}>Katolik</option>
                    <option value="Hindu" {{ request('agama')=='Hindu'?'selected':'' }}>Hindu</option>
                    <option value="Buddha" {{ request('agama')=='Buddha'?'selected':'' }}>Buddha</option>
                    <option value="Konghucu" {{ request('agama')=='Konghucu'?'selected':'' }}>Konghucu</option>
                </select>
            </div>

            {{-- SEARCH --}}
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        value="{{ request('search') }}" placeholder="Cari nama, KTP, pekerjaan, telp atau email">

                    <button type="submit" class="input-group-text">🔍</button>

                   @if(request()->hasAny(['search', 'jenis_kelamin', 'agama']))
            <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary ms-2">Clear</a>
        @endif
                </div>
            </div>
        </div>
    </form>


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
            @forelse ($warga as $p)
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
                            <a href="{{ route('warga.edit', $p->warga_id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('warga.destroy', $p->warga_id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $warga->links('pagination::bootstrap-5') }}
    </div>

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
