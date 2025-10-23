@extends('layouts.app')

@section('title', 'Edit Pengajuan Surat')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Edit Pengajuan Surat</h1>

    <form action="{{ route('pengajuan.update', $pengajuan->pengajuan_id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama Pemohon</label>
            <input type="text" name="nama_pemohon" class="form-control" value="{{ $pengajuan->nama_pemohon }}" required>
        </div>

        <div class="mb-3">
            <label>Jenis Surat</label>
            <input type="text" name="jenis_surat" class="form-control" value="{{ $pengajuan->jenis_surat }}" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ $pengajuan->keterangan }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="Menunggu" {{ $pengajuan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ $pengajuan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ $pengajuan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
