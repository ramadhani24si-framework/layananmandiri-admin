@extends('layouts.app')

@section('title', 'Edit Pengajuan Surat')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">✏️ Edit Pengajuan Surat</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengajuan.update', $pengajuan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
                <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control"
                    value="{{ old('nama_pemohon', $pengajuan->nama_pemohon) }}" required>
            </div>

            {{-- Jenis Surat --}}
            <div class="mb-3">
                <label class="form-label">Jenis Surat</label>
                <select name="jenis_id" class="form-select" required>
                    @foreach ($jenisSurats as $jenis)
                        <option value="{{ $jenis->jenis_id }}"
                            {{ $pengajuan->jenis_id == $jenis->jenis_id ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="4">{{ old('keterangan', $pengajuan->keterangan) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Pengajuan</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Menunggu" {{ $pengajuan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ $pengajuan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $pengajuan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditolak" {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
