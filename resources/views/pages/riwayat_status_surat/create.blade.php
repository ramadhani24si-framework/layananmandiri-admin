@extends('layouts.app')

@section('title', 'Tambah Riwayat Status Surat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Tambah Riwayat Status</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('riwayat_status_surat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('riwayat_status_surat.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="permohonan_id" class="form-label">Pengajuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('permohonan_id') is-invalid @enderror"
                                    id="permohonan_id" name="permohonan_id" required>
                                <option value="">-- Pilih Pengajuan --</option>
                                @foreach($pengajuanList as $item)
                                <option value="{{ $item->permohonan_id }}" {{ old('permohonan_id') == $item->permohonan_id ? 'selected' : '' }}>
                                    {{ $item->nomor_permohonan }} - {{ $item->warga->nama ?? '-' }} ({{ $item->status_text }})
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
                                <option value="">-- Pilih Status --</option>
                                @foreach($statusList as $value => $label)
                                <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
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
                                <option value="{{ $item->warga_id }}" {{ old('petugas_warga_id') == $item->warga_id ? 'selected' : '' }}>
                                    {{ $item->nama }} ({{ $item->role }})
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">Biarkan kosong untuk sistem</div>
                            @error('petugas_warga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="waktu" class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror"
                                   id="waktu" name="waktu" value="{{ old('waktu', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan" rows="3"
                              placeholder="Masukkan keterangan perubahan status...">{{ old('keterangan') }}</textarea>
                    <div class="form-text">Maksimal 500 karakter</div>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Perhatian:</strong> Status pengajuan akan otomatis diperbarui sesuai status yang dipilih.
                </div>

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set waktu default ke sekarang
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('waktu').value) {
            document.getElementById('waktu').value = new Date().toISOString().slice(0, 16);
        }
    });
</script>
@endpush
