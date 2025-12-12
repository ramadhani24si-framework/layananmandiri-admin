@extends('layouts.app')

@section('title', 'Tambah Berkas Persyaratan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Tambah Berkas Persyaratan</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('berkas_persyaratan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('berkas_persyaratan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="permohonan_id" class="form-label">Permohonan <span class="text-danger">*</span></label>
                    <select class="form-select @error('permohonan_id') is-invalid @enderror"
                            id="permohonan_id" name="permohonan_id" required>
                        <option value="">-- Pilih Permohonan --</option>
                        @foreach($pengajuan as $item)
                        <option value="{{ $item->permohonan_id }}" {{ old('permohonan_id') == $item->permohonan_id ? 'selected' : '' }}>
                            {{ $item->nomor_permohonan }} - {{ $item->warga->nama ?? '-' }}
                        </option>
                        @endforeach
                    </select>
                    @error('permohonan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_berkas" class="form-label">Nama Berkas <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_berkas') is-invalid @enderror"
                           id="nama_berkas" name="nama_berkas" value="{{ old('nama_berkas') }}"
                           placeholder="Contoh: KTP, KK, Surat Pengantar" required>
                    @error('nama_berkas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="valid" class="form-label">Status Validasi <span class="text-danger">*</span></label>
                    <select class="form-select @error('valid') is-invalid @enderror"
                            id="valid" name="valid" required>
                        <option value="menunggu" {{ old('valid') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="valid" {{ old('valid') == 'valid' ? 'selected' : '' }}>Valid</option>
                        <option value="tidak_valid" {{ old('valid') == 'tidak_valid' ? 'selected' : '' }}>Tidak Valid</option>
                    </select>
                    @error('valid')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 🔥 MULTIPLE FILE UPLOAD --}}
                <div class="mb-4">
                    <label class="form-label">Upload File <span class="text-danger">*</span></label>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Dapat upload multiple file. Format: PDF, JPG, PNG, DOC, DOCX (max 10MB per file)
                    </div>

                    <div id="fileUploadContainer">
                        <div class="file-upload-row row g-3 mb-3">
                            <div class="col-md-10">
                                <input type="file" name="berkas_files[]" class="form-control file-input"
                                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success add-file-btn w-100">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('fileUploadContainer');
    let fileCount = 1;

    // Tambah field file baru
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-file-btn')) {
            e.preventDefault();

            const newRow = document.createElement('div');
            newRow.className = 'file-upload-row row g-3 mb-3';
            newRow.innerHTML = `
                <div class="col-md-10">
                    <input type="file" name="berkas_files[]" class="form-control file-input"
                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-file-btn w-100">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            `;

            container.appendChild(newRow);
            fileCount++;
        }

        // Hapus field file
        if (e.target.classList.contains('remove-file-btn')) {
            e.preventDefault();
            const row = e.target.closest('.file-upload-row');
            if (document.querySelectorAll('.file-upload-row').length > 1) {
                row.remove();
                fileCount--;
            } else {
                alert('Minimal harus ada satu file');
            }
        }
    });
});
</script>
@endpush
