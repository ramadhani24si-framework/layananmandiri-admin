@extends('layouts.app')

@section('title', 'Edit Pengajuan Surat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Edit Pengajuan Surat</h2>
            <p class="text-muted mb-0">{{ $pengajuan->nomor_permohonan }}</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('pengajuan.show', $pengajuan->permohonan_id) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> Lihat Detail
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
            <form action="{{ route('pengajuan.update', $pengajuan->permohonan_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomor_permohonan" class="form-label">Nomor Permohonan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor_permohonan') is-invalid @enderror"
                                   id="nomor_permohonan" name="nomor_permohonan"
                                   value="{{ old('nomor_permohonan', $pengajuan->nomor_permohonan) }}" required>
                            @error('nomor_permohonan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror"
                                   id="tanggal_pengajuan" name="tanggal_pengajuan"
                                   value="{{ old('tanggal_pengajuan', $pengajuan->tanggal_pengajuan) }}" required>
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
                                <option value="{{ $item->warga_id }}" {{ old('warga_id', $pengajuan->warga_id) == $item->warga_id ? 'selected' : '' }}>
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
                                <option value="{{ $item->jenis_id }}" {{ old('jenis_id', $pengajuan->jenis_id) == $item->jenis_id ? 'selected' : '' }}>
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
                                @foreach($statusList as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $pengajuan->status) == $value ? 'selected' : '' }}>
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

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror"
                              id="catatan" name="catatan" rows="3">{{ old('catatan', $pengajuan->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ MULTIPLE FILE UPLOAD SECTION -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-paperclip"></i> Lampiran Berkas
                            @if($pengajuan->lampiranFiles && $pengajuan->lampiranFiles->count() > 0)
                                <span class="badge bg-primary">{{ $pengajuan->lampiranFiles->count() }}</span>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Lampiran yang sudah ada -->
                        @if($pengajuan->lampiranFiles && $pengajuan->lampiranFiles->count() > 0)
                        <div class="mb-4">
                            <h6>Lampiran Terupload:</h6>
                            <div class="list-group" id="lampiranFilesList">
                                @foreach($pengajuan->lampiranFiles as $media)
                                <div class="list-group-item d-flex justify-content-between align-items-center" id="lampiran-{{ $media->media_id }}">
                                    <div>
                                        <i class="{{ $media->getIcon() }} me-2"></i>
                                        <a href="{{ $media->getFileUrl() }}"
                                           target="_blank" class="text-decoration-none">
                                            {{ $media->caption ?? $media->file_name }}
                                        </a>
                                        <small class="text-muted ms-2">({{ $media->mime_type }})</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-lampiran"
                                            data-media-id="{{ $media->media_id }}"
                                            data-pengajuan-id="{{ $pengajuan->permohonan_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Upload lampiran baru -->
                        <div class="mb-3">
                            <label for="lampiran_files" class="form-label">Tambah Lampiran Baru</label>
                            <input type="file"
                                   class="form-control @error('lampiran_files') is-invalid @enderror"
                                   id="lampiran_files"
                                   name="lampiran_files[]"
                                   multiple
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            @error('lampiran_files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Upload berkas tambahan (PDF, JPG, PNG, DOC, DOCX). Maks 10MB per file.
                            </small>
                        </div>

                        <!-- Caption Inputs Container -->
                        <div id="lampiran-caption-container"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Delete lampiran via AJAX
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-lampiran')) {
            const button = e.target.closest('.btn-delete-lampiran');
            const mediaId = button.getAttribute('data-media-id');
            const pengajuanId = button.getAttribute('data-pengajuan-id');

            if (confirm('Hapus file lampiran ini?')) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;

                fetch(`/pengajuan/${pengajuanId}/lampiran/${mediaId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Remove element from DOM
                        const element = document.getElementById(`lampiran-${mediaId}`);
                        if (element) {
                            element.remove();
                        }
                        alert('File berhasil dihapus');

                        // Reload jika tidak ada file lagi
                        const lampiranList = document.getElementById('lampiranFilesList');
                        if (lampiranList && lampiranList.children.length === 0) {
                            location.reload();
                        }
                    } else {
                        alert('Gagal menghapus file: ' + data.message);
                        button.innerHTML = '<i class="fas fa-trash"></i>';
                        button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus file');
                    button.innerHTML = '<i class="fas fa-trash"></i>';
                    button.disabled = false;
                });
            }
        }
    });

    // Handle lampiran file input change
    document.getElementById('lampiran_files').addEventListener('change', function(e) {
        const container = document.getElementById('lampiran-caption-container');
        container.innerHTML = '<h6 class="mt-3">Keterangan Lampiran Baru:</h6>';

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
 <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
@endsection
