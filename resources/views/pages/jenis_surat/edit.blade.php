@extends('layouts.app')

@section('title', 'Edit Jenis Surat')

@section('content')
    <div class="container">
        <h1 class="mb-4">✏️ Edit Jenis Surat</h1>

        <form action="{{ route('jenis_surat.update', $jenis_surat->jenis_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kode Surat --}}
            <div class="mb-3">
                <label class="form-label">Kode Surat</label>
                <input type="text" name="kode" value="{{ $jenis_surat->kode }}" class="form-control" required>
            </div>

            {{-- Nama Jenis Surat --}}
            <div class="mb-3">
                <label class="form-label">Nama Jenis Surat</label>
                <input type="text" name="nama_jenis" value="{{ $jenis_surat->nama_jenis }}" class="form-control"
                    required>
            </div>

            {{-- Syarat JSON --}}
            <div class="mb-3">
                <label class="form-label">Syarat (pisahkan dengan koma)</label>
                <textarea name="syarat_json" class="form-control" rows="4" placeholder="Contoh: KTP, KK, Surat Pengantar RT">
    @if (isset($jenis_surat) && $jenis_surat->syarat_json)
@php
    $syaratArray = json_decode($jenis_surat->syarat_json, true);
@endphp
        {{ is_array($syaratArray) ? implode(', ', $syaratArray) : $jenis_surat->syarat_json }}
@endif
</textarea>
                <small class="text-muted">Pisahkan setiap syarat dengan koma</small>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('jenis_surat.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
