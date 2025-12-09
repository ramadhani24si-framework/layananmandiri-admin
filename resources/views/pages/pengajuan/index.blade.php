@extends('layouts.app')

@section('title', 'Daftar Pengajuan Surat')

@section('content')
    <div class="container">
        <h1 class="mb-4">📄 Daftar Pengajuan Surat</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- FILTER + SEARCH --}}
        <form method="GET" action="{{ route('pengajuan.index') }}" class="mb-3">
            <div class="row">

                {{-- FILTER STATUS --}}
                <div class="col-md-2">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status')=='Menunggu'?'selected':'' }}>Menunggu</option>
                        <option value="Diproses" {{ request('status')=='Diproses'?'selected':'' }}>Diproses</option>
                        <option value="Selesai" {{ request('status')=='Selesai'?'selected':'' }}>Selesai</option>
                    </select>
                </div>

                {{-- FILTER JENIS SURAT --}}
                <div class="col-md-3">
                    <select name="jenis_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Jenis Surat</option>
                        @foreach(\App\Models\JenisSurat::all() as $js)
                            <option value="{{ $js->jenis_id }}"
                                {{ request('jenis_id') == $js->jenis_id ? 'selected':'' }}>
                                {{ $js->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SEARCH --}}
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            value="{{ request('search') }}" placeholder="Search nama/keterangan">

                        <button type="submit" class="input-group-text">🔍</button>

                        @if(request('search'))
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary ms-2">Clear</a>
                        @endif
                    </div>
                </div>

            </div>
        </form>

        {{-- TABEL --}}
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
                        <td>{{ $p->jenisSurat->nama_jenis ?? '-' }}</td>
                        <td>{{ $p->keterangan }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status == 'Menunggu' ? 'secondary' : ($p->status == 'Diproses' ? 'warning' : 'success') }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('pengajuan.edit', $p->pengajuan_id) }}"
                                   class="btn btn-warning btn-action">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('pengajuan.destroy', $p->pengajuan_id) }}"
                                      method="POST" class="d-inline">
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
                        <td colspan="6" class="text-center">Belum ada pengajuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $pengajuans->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- ICONS --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .btn-action {
            padding: 6px 8px;
            font-size: 12px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .d-flex.gap-1 {
            gap: 4px;
        }
    </style>
@endsection
