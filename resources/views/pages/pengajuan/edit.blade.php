@extends('layouts.app')

@section('title', 'Edit Pengajuan Surat')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">✏️ Edit Pengajuan Surat</h3>

    {{-- Pesan sukses atau error --}}
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

    {{-- Form Edit Pengajuan --}}
    <form action="{{ route('pengajuan.update', $pengajuan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
            <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control"
                   value="{{ old('nama_pemohon', $pengajuan->nama_pemohon) }}" required>
        </div>

        <div class="mb-3">
            <label for="jenis_surat" class="form-label">Jenis Surat</label>
            <select name="jenis_surat" id="jenis_surat" class="form-select" required>
                <option value="">Pilih Jenis Surat</option>
                <option value="Surat Keterangan" {{ old('jenis_surat', $pengajuan->jenis_surat) == 'Surat Keterangan' ? 'selected' : '' }}>Surat Keterangan</option>
                <option value="Surat Pengantar" {{ old('jenis_surat', $pengajuan->jenis_surat) == 'Surat Pengantar' ? 'selected' : '' }}>Surat Pengantar</option>
                <option value="Surat Keterangan Usaha" {{ old('jenis_surat', $pengajuan->jenis_surat) == 'Surat Keterangan Usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                <option value="Surat Keterangan Domisili" {{ old('jenis_surat', $pengajuan->jenis_surat) == 'Surat Keterangan Domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                <option value="Surat Keterangan Tidak Mampu" {{ old('jenis_surat', $pengajuan->jenis_surat) == 'Surat Keterangan Tidak Mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                <option value="Lainnya" {{ old('jenis_surat', $pengajuan->jenis_surat) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="4"
                      placeholder="Masukkan keterangan tambahan...">{{ old('keterangan', $pengajuan->keterangan) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status Pengajuan</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Menunggu" {{ old('status', $pengajuan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ old('status', $pengajuan->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ old('status', $pengajuan->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Ditolak" {{ old('status', $pengajuan->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
