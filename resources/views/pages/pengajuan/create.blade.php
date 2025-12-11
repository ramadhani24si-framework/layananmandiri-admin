@extends('layouts.app')

@section('title', 'Buat Pengajuan Surat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Buat Pengajuan Surat Baru</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomor_permohonan" class="form-label">Nomor Permohonan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_permohonan') is-invalid @enderror"
                                   id="nomor_permohonan" name="nomor_permohonan"
                                   value="{{ old('nomor_permohonan', $nomorPermohonan) }}" required readonly>
                            @error('nomor_permohonan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nomor otomatis di-generate</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror"
                                   id="tanggal_pengajuan" name="tanggal_pengajuan"
                                   value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}" required>
                            @error('tanggal_pengajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="warga_id" class="form-label">Warga Pemohon <span class="text-danger">*</span></label>
                            <select class="form-select @error('warga_id') is-invalid @enderror"
                                    id="warga_id" name="warga_id" required>
                                <option value="">-- Pilih Warga --</option>
                                @foreach($warga as $item)
                                <option value="{{ $item->warga_id }}" {{ old('warga_id') == $item->warga_id ? 'selected' : '' }}>
                                    {{ $item->nama }} (NIK: {{ $item->no_ktp }})
                                </option>
                                @endforeach
                            </select>
                            @error('warga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_id" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_id') is-invalid @enderror"
                                    id="jenis_id" name="jenis_id" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($jenisSurat as $item)
                                <option value="{{ $item->jenis_id }}" {{ old('jenis_id') == $item->jenis_id ? 'selected' : '' }}>
                                    {{ $item->nama_jenis }} ({{ $item->kode }})
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="diajukan" {{ old('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diproses" {{ old('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror"
                              id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Catatan tambahan untuk pengajuan ini</small>
                </div>

                <!-- ✅ MULTIPLE FILE UPLOAD SECTION -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-paperclip"></i> Lampiran Berkas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="lampiran_files" class="form-label">Upload Berkas Lampiran</label>
                            <input type="file"
                                   class="form-control @error('lampiran_files') is-invalid @enderror"
                                   id="lampiran_files"
                                   name="lampiran_files[]"
                                   multiple
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            @error('lampiran_files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('lampiran_files.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Upload berkas pendukung (PDF, JPG, PNG, DOC, DOCX). Maks 10MB per file.
                            </small>
                        </div>

                        <!-- Caption Inputs Container -->
                        <div id="lampiran-caption-container"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Set tanggal default hari ini
    document.getElementById('tanggal_pengajuan').value = new Date().toISOString().split('T')[0];

    // Handle lampiran file input change
    document.getElementById('lampiran_files').addEventListener('change', function(e) {
        const container = document.getElementById('lampiran-caption-container');
        container.innerHTML = '<h6 class="mt-3">Keterangan Lampiran:</h6>';

        Array.from(this.files).forEach((file, index) => {
            const div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = `
                <label class="form-label small">${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</label>
                <input type="text"
                       class="form-control form-control-sm"
                       name="lampiran_captions[]"
                       placeholder="Masukkan keterangan untuk ${file.name}">
            `;
            container.appendChild(div);
        });
    });
</script>
@endpush
@endsection
