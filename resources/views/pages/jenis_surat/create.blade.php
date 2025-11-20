@extends('layouts.app')

@section('title', 'Tambah Jenis Surat')

@section('content')
<div class="container">
    <h1 class="mb-4">📝 Tambah Jenis Surat</h1>

    <form action="{{ route('jenis_surat.store') }}" method="POST">
        @csrf

        {{-- Kode Surat --}}
        <div class="mb-3">
            <label class="form-label">Kode Surat</label>
            <input type="text" name="kode" class="form-control" placeholder="Contoh: SKTM01" required>
        </div>

        {{-- Nama Jenis Surat --}}
        <div class="mb-3">
            <label class="form-label">Nama Jenis Surat</label>
            <input type="text" name="nama_jenis" class="form-control" placeholder="Contoh: Surat Keterangan Tidak Mampu" required>
        </div>

        {{-- Syarat JSON --}}
        <div class="mb-3">
            <label class="form-label">Syarat (JSON)</label>
            <textarea name="syarat_json" class="form-control" rows="4" placeholder='Contoh: ["KTP", "KK", "Surat Pengantar RT"]'></textarea>
            <small class="text-muted">Isi dalam bentuk JSON array.</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jenis_surat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
