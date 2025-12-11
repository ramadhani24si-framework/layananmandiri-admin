@extends('layouts.app')

@section('title', 'Edit Berkas Persyaratan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('berkas_persyaratan.index') }}">Berkas Persyaratan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('berkas_persyaratan.show', $berkas->berkas_id) }}">Detail</a>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Edit Berkas Persyaratan</h2>
                <div>
                    <a href="{{ route('berkas_persyaratan.show', $berkas->berkas_id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Detail
                    </a>
                </div>
            </div>
            <p class="text-muted mb-0">ID: {{ $berkas->berkas_id }} | {{ $berkas->media->count() }} file terlampir</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('berkas_persyaratan.update', $berkas->berkas_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>Informasi Berkas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="permohonan_id" class="form-label">Permohonan <span class="text-danger">*</span></label>
                            <select class="form-select @error('permohonan_id') is-invalid @enderror"
                                    id="permohonan_id" name="permohonan_id" required>
                                <option value="">-- Pilih Permohonan --</option>
                                @foreach($pengajuan as $item)
                                <option value="{{ $item->permohonan_id }}" {{ old('permohonan_id', $berkas->permohonan_id) == $item->permohonan_id ? 'selected' : '' }}>
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
                                   id="nama_berkas" name="nama_berkas"
                                   value="{{ old('nama_berkas', $berkas->nama_berkas) }}" required>
                            @error('nama_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="valid" class="form-label">Status Validasi <span class="text-danger">*</span></label>
                            <select class="form-select @error('valid') is-invalid @enderror"
                                    id="valid" name="valid" required>
                                @foreach($statusList as $value => $label)
                                <option value="{{ $value }}" {{ old('valid', $berkas->valid) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @error('valid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                {{-- Existing Files --}}
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file me-2"></i>File Yang Sudah Ada
                            <span class="badge bg-primary ms-2">{{ $berkas->media->count() }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($berkas->media->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama File</th>
                                            <th>Tipe</th>
                                            <th>Ukuran</th>
                                            <th width="100" class="text-center">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($berkas->media as $index => $media)
                                            @php
                                                $filePath = 'media/berkas_persyaratan/' . $berkas->berkas_id . '/' . $media->file_name;
                                                $fileUrl = asset('storage/' . $filePath);
                                                $isImage = in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/jpg']);
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($isImage)
                                                            <i class="fas fa-image text-success me-2"></i>
                                                        @elseif($media->mime_type == 'application/pdf')
                                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                                        @elseif(str_contains($media->mime_type, 'word'))
                                                            <i class="fas fa-file-word text-primary me-2"></i>
                                                        @else
                                                            <i class="fas fa-file me-2"></i>
                                                        @endif
                                                        <div>
                                                            <a href="{{ $fileUrl }}" target="_blank"
                                                               class="text-decoration-none small">
                                                                {{ Str::limit($media->caption, 25) }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ pathinfo($media->file_name, PATHINFO_EXTENSION) }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        @if(Storage::disk('public')->exists($filePath))
                                                            {{ round(Storage::disk('public')->size($filePath) / 1024, 1) }} KB
                                                        @else
                                                            -
                                                        @endif
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('berkas_persyaratan.destroyMedia', [$berkas->berkas_id, $media->media_id]) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus file ini?')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada file terlampir</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Add New Files --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Tambah File Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Dapat menambahkan file baru. Format: PDF, JPG, PNG, DOC, DOCX (max 10MB per file)
                        </div>

                        <div id="newFilesContainer">
                            {{-- Template untuk file baru --}}
                            <template id="fileRowTemplate">
                                <div class="new-file-row row g-3 mb-3">
                                    <div class="col-md-8">
                                        <input type="file" name="new_files[]" class="form-control file-input"
                                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="new_captions[]" class="form-control"
                                               placeholder="Keterangan file">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-file-btn w-100">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            {{-- Baris pertama --}}
                            <div class="new-file-row row g-3 mb-3">
                                <div class="col-md-8">
                                    <input type="file" name="new_files[]" class="form-control file-input"
                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="new_captions[]" class="form-control"
                                           placeholder="Keterangan file">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-success add-file-btn w-100">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo me-2"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('newFilesContainer');
    const template = document.getElementById('fileRowTemplate');

    // Tambah field file baru
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-file-btn') ||
            e.target.closest('.add-file-btn')) {
            e.preventDefault();

            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('.new-file-row');

            // Ubah tombol terakhir menjadi hapus
            const lastBtn = row.querySelector('button');
            lastBtn.classList.remove('btn-success', 'add-file-btn');
            lastBtn.classList.add('btn-danger', 'remove-file-btn');
            lastBtn.innerHTML = '<i class="fas fa-times"></i>';

            container.appendChild(row);
        }

        // Hapus field file
        if (e.target.classList.contains('remove-file-btn') ||
            e.target.closest('.remove-file-btn')) {
            e.preventDefault();
            const row = e.target.closest('.new-file-row');
            if (document.querySelectorAll('.new-file-row').length > 1) {
                row.remove();
            } else {
                alert('Minimal harus ada satu baris file');
            }
        }
    });

    // Preview nama file saat dipilih
    container.addEventListener('change', function(e) {
        if (e.target.classList.contains('file-input')) {
            const input = e.target;
            const captionInput = input.closest('.new-file-row').querySelector('input[name="new_captions[]"]');

            if (input.files.length > 0 && !captionInput.value) {
                const fileName = input.files[0].name;
                const nameWithoutExt = fileName.replace(/\.[^/.]+$/, ""); // Hapus extension
                captionInput.value = nameWithoutExt;
            }
        }
    });
});
</script>
@endpush
