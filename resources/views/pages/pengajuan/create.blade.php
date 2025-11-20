@extends('layouts.app')

@section('title', 'Tambah Pengajuan Surat')

@section('content')
    <div class="container">
        <h1 class="mb-4">📝 Tambah Pengajuan Surat</h1>

        <form action="{{ route('pengajuan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Pemohon</label>
                <input type="text" name="nama_pemohon" class="form-control" required>
            </div>

            {{-- Jenis Surat --}}
            <div class="mb-3">
                <label class="form-label">Jenis Surat</label>
                <select name="jenis_surat_id" class="form-select" required> {{-- UBAH form-control MENJADI form-select --}}
                    @foreach ($jenisSurats as $jenis)
                        <option value="{{ $jenis->jenis_id }}"
                            {{ isset($pengajuan) && $pengajuan->jenis_surat_id == $jenis->jenis_id ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="Menunggu">Menunggu</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
{{-- create --}}
