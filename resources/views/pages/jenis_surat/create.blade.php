@extends('layouts.app')

@section('title', 'Tambah Jenis Surat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Tambah Jenis Surat</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('jenis_surat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('jenis_surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                   id="kode" name="kode" value="{{ old('kode') }}"
                                   placeholder="Contoh: SK, SKTM, SP" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kode unik untuk jenis surat (max 10 karakter)</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_jenis" class="form-label">Nama Jenis Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_jenis') is-invalid @enderror"
                                   id="nama_jenis" name="nama_jenis" value="{{ old('nama_jenis') }}"
                                   placeholder="Contoh: Surat Keterangan" required>
                            @error('nama_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="syarat_json" class="form-label">Daftar Syarat (JSON Format)</label>
                    <textarea class="form-control @error('syarat_json') is-invalid @enderror"
                              id="syarat_json" name="syarat_json" rows="5"
                              placeholder='Contoh: ["KTP", "KK", "Surat Pengantar"]'>{{ old('syarat_json') }}</textarea>
                    @error('syarat_json')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        Masukkan dalam format JSON array. Contoh valid: ["KTP", "KK", "Surat Pengantar"]
                    </small>
                </div>

                <div class="mb-3">
                    <label for="template_files" class="form-label">Template File</label>
                    <input type="file" class="form-control @error('template_files') is-invalid @enderror"
                           id="template_files" name="template_files[]" multiple
                           accept=".doc,.docx,.pdf">
                    @error('template_files')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('template_files.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        Upload template surat (DOC, DOCX, PDF). Maks 10MB per file.
                    </small>
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
     <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi JSON format
    document.getElementById('syarat_json').addEventListener('blur', function() {
        const textarea = this;
        const value = textarea.value.trim();

        if (value) {
            try {
                JSON.parse(value);
                textarea.classList.remove('is-invalid');
                textarea.classList.add('is-valid');
            } catch (e) {
                textarea.classList.remove('is-valid');
                textarea.classList.add('is-invalid');
            }
        }
    });
</script>
@endpush
