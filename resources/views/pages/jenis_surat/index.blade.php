@extends('layouts.app')

@section('title', 'Daftar Jenis Surat')

@section('content')
<div class="container">

    <h1 class="mb-4">📄 Daftar Jenis Surat</h1>

    <a href="{{ route('jenis_surat.create') }}" class="btn btn-primary mb-3">+ Tambah Jenis Surat</a>

    <div class="table-responsive">

        {{-- FORM FILTER + SEARCH --}}
        <form method="GET" action="{{ route('jenis_surat.index') }}" class="mb-3">
            <div class="row">

                {{-- FILTER SELECT: kode --}}
                <div class="col-md-2">
                    <select name="kode" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kode</option>
                        @foreach($jenisSurat as $item)
                            <option value="{{ $item->kode }}" {{ request('kode') == $item->kode ? 'selected' : '' }}>
                                {{ $item->kode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SEARCH --}}
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                               value="{{ request('search') }}" placeholder="Search">

                        <button type="submit" class="input-group-text">🔍</button>

                        {{-- CLEAR SEARCH --}}
                        @if(request('search'))
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                class="btn btn-outline-secondary ms-2">
                                Clear
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </form>

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
                @foreach ($jenisSurat as $item)
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
                            <form action="{{ route('jenis_surat.destroy', $item->jenis_id) }}" method="POST" class="d-inline">
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

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $jenisSurat->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>
@endsection
