@extends('layouts.app')

@section('title', 'Edit Jenis Surat')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-0">Edit Jenis Surat</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('jenis_surat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('jenis_surat.update', $jenisSurat->jenis_id) }}" method="POST"
                    enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" name="kode" value="{{ old('kode', $jenisSurat->kode) }}" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_jenis" class="form-label">Nama Jenis Surat <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_jenis') is-invalid @enderror"
                                    id="nama_jenis" name="nama_jenis"
                                    value="{{ old('nama_jenis', $jenisSurat->nama_jenis) }}" required>
                                @error('nama_jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="syarat_json" class="form-label">Daftar Syarat (JSON Format)</label>
                        <textarea class="form-control @error('syarat_json') is-invalid @enderror" id="syarat_json" name="syarat_json"
                            rows="5" placeholder='["KTP", "KK", "Surat Pengantar"]'>{{ old('syarat_json', $jenisSurat->syarat_for_form) }}</textarea>
                        @error('syarat_json')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan dalam format JSON array. Contoh: ["KTP", "KK", "Surat
                            Pengantar"]</small>

                        <!-- ✅ Tampilkan preview syarat -->
                        <div id="syarat-preview" class="mt-2">
                            @if ($jenisSurat->syarat_json && is_array($jenisSurat->syarat_json))
                                <div class="alert alert-light">
                                    <strong>Syarat saat ini:</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($jenisSurat->syarat_json as $syarat)
                                            <li>{{ $syarat }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Template Files yang sudah ada -->
                    @if ($jenisSurat->mediaFiles && $jenisSurat->mediaFiles->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Template File Terupload</label>
                            <div class="list-group" id="mediaFilesList">
                                @foreach ($jenisSurat->mediaFiles as $media)
                                    <div class="list-group-item d-flex justify-content-between align-items-center"
                                        id="media-{{ $media->media_id }}">
                                        <div>
                                            <i class="{{ $media->getIcon() }} me-2"></i>
                                            <a href="{{ $media->getFileUrl() }}" target="_blank"
                                                class="text-decoration-none">
                                                {{ $media->caption ?? $media->file_name }}
                                            </a>
                                            <small class="text-muted ms-2">({{ $media->mime_type }})</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-media"
                                            data-media-id="{{ $media->media_id }}"
                                            data-jenis-id="{{ $jenisSurat->jenis_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="template_files" class="form-label">Tambah Template File Baru</label>
                        <input type="file" class="form-control @error('template_files') is-invalid @enderror"
                            id="template_files" name="template_files[]" multiple accept=".doc,.docx,.pdf,.jpg,.jpeg,.png">
                        @error('template_files')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('template_files.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Upload file tambahan (DOC, DOCX, PDF, JPG, PNG). Maks 10MB per
                            file.</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('jenis_surat.show', $jenisSurat->jenis_id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
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

@push('styles')
    <style>
        #mediaFilesList .list-group-item {
            transition: all 0.3s ease;
        }

        #mediaFilesList .list-group-item:hover {
            background-color: #f8f9fa;
        }

        #syarat-preview .alert {
            font-size: 0.9rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Validasi JSON format real-time
        const syaratTextarea = document.getElementById('syarat_json');
        const syaratPreview = document.getElementById('syarat-preview');

        function updateSyaratPreview() {
            const value = syaratTextarea.value.trim();

            if (!value) {
                syaratPreview.innerHTML = '';
                syaratTextarea.classList.remove('is-invalid', 'is-valid');
                return;
            }

            try {
                const parsed = JSON.parse(value);

                if (Array.isArray(parsed)) {
                    // Valid JSON array
                    syaratTextarea.classList.remove('is-invalid');
                    syaratTextarea.classList.add('is-valid');

                    // Update preview
                    let previewHtml = '<div class="alert alert-success mt-2">';
                    previewHtml += '<strong>Preview syarat yang akan disimpan:</strong>';
                    previewHtml += '<ul class="mb-0 mt-1">';

                    parsed.forEach(item => {
                        previewHtml += `<li>${item}</li>`;
                    });

                    previewHtml += '</ul></div>';
                    syaratPreview.innerHTML = previewHtml;
                } else {
                    throw new Error('Harus berupa array');
                }
            } catch (e) {
                // Invalid JSON
                syaratTextarea.classList.remove('is-valid');
                syaratTextarea.classList.add('is-invalid');

                // Clear preview
                syaratPreview.innerHTML = '<div class="alert alert-danger mt-2">Format JSON tidak valid: ' + e.message +
                    '</div>';
            }
        }

        // Event listeners
        syaratTextarea.addEventListener('input', updateSyaratPreview);
        syaratTextarea.addEventListener('blur', updateSyaratPreview);

        // Initial preview
        updateSyaratPreview();

        // Delete media via AJAX
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete-media')) {
                const button = e.target.closest('.btn-delete-media');
                const mediaId = button.getAttribute('data-media-id');
                const jenisId = button.getAttribute('data-jenis-id');

                if (confirm('Hapus file template ini?')) {
                    // Tampilkan loading
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;

                    fetch(`/jenis_surat/${jenisId}/media/${mediaId}`, {
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
                                const element = document.getElementById(`media-${mediaId}`);
                                if (element) {
                                    element.remove();
                                }

                                // Show success message
                                alert('File berhasil dihapus');

                                // Reload jika tidak ada file lagi
                                const mediaList = document.getElementById('mediaFilesList');
                                if (mediaList && mediaList.children.length === 0) {
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

        // Preview file sebelum upload
        document.getElementById('template_files').addEventListener('change', function(e) {
            const files = this.files;
            const fileList = document.getElementById('filePreview');

            if (!fileList) {
                const previewDiv = document.createElement('div');
                previewDiv.id = 'filePreview';
                previewDiv.className = 'mt-3';
                previewDiv.innerHTML = '<h6>File yang akan diupload:</h6>';
                this.parentNode.appendChild(previewDiv);
            } else {
                fileList.innerHTML = '<h6>File yang akan diupload:</h6>';
            }

            Array.from(files).forEach((file, index) => {
                const fileInfo = document.createElement('div');
                fileInfo.className =
                    'alert alert-light d-flex justify-content-between align-items-center mb-2';
                fileInfo.innerHTML = `
                <div>
                    <i class="fas fa-file me-2"></i>
                    ${file.name}
                    <small class="text-muted">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                </div>
                <span class="badge bg-info">${file.type || 'Unknown'}</span>
            `;
                fileList.appendChild(fileInfo);
            });
        });
    </script>
@endpush
