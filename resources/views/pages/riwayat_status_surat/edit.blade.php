@extends('layouts.app')

@section('title', 'Edit Riwayat Status Surat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Edit Riwayat Status</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('riwayat_status_surat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('riwayat_status_surat.update', $riwayat->riwayat_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="permohonan_id" class="form-label">Pengajuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('permohonan_id') is-invalid @enderror"
                                    id="permohonan_id" name="permohonan_id" required>
                                <option value="">-- Pilih Pengajuan --</option>
                                @foreach($pengajuanList as $item)
                                <option value="{{ $item->permohonan_id }}" {{ old('permohonan_id', $riwayat->permohonan_id) == $item->permohonan_id ? 'selected' : '' }}>
                                    {{ $item->nomor_permohonan }} - {{ $item->warga->nama ?? '-' }}
                                </option>
                                @endforeach
                            </select>
                            @error('permohonan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                @foreach($statusList as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $riwayat->status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="petugas_warga_id" class="form-label">Petugas</label>
                            <select class="form-select @error('petugas_warga_id') is-invalid @enderror"
                                    id="petugas_warga_id" name="petugas_warga_id">
                                <option value="">-- Pilih Petugas --</option>
                                @foreach($petugasList as $item)
                                <option value="{{ $item->warga_id }}" {{ old('petugas_warga_id', $riwayat->petugas_warga_id) == $item->warga_id ? 'selected' : '' }}>
                                    {{ $item->nama }} ({{ $item->role }})
                                </option>
                                @endforeach
                            </select>
                            @error('petugas_warga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="waktu" class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror"
                                   id="waktu" name="waktu"
                                   value="{{ old('waktu', $riwayat->waktu->format('Y-m-d\TH:i')) }}" required>
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $riwayat->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
