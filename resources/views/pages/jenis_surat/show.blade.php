@extends('layouts.app')

@section('title', 'Detail Jenis Surat')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-0">Detail Jenis Surat</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('jenis_surat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('jenis_surat.edit', $jenisSurat->jenis_id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Jenis Surat</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Kode</th>
                                <td>{{ $jenisSurat->kode }}</td>
                            </tr>
                            <tr>
                                <th>Nama Jenis Surat</th>
                                <td>{{ $jenisSurat->nama_jenis }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $jenisSurat->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate</th>
                                <td>{{ $jenisSurat->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @php
                    $syaratArray = $jenisSurat->syarat_json;
                    $syaratCount = is_array($syaratArray) ? count($syaratArray) : 0;
                @endphp

                @if ($syaratCount > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Daftar Syarat</h5>
                        </div>
                        <div class="card-body">
                            <ol class="mb-0">
                                @foreach ($syaratArray as $syarat)
                                    <li>{{ $syarat }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Template Files
                            <span class="badge bg-primary">{{ $jenisSurat->mediaFiles->count() }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($jenisSurat->mediaFiles->count() > 0)
                            <div class="list-group">
                                @foreach ($jenisSurat->mediaFiles as $media)
                                    <a href="{{ $media->getFileUrl() }}" target="_blank"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="{{ $media->getIcon() }} me-2"></i>
                                                {{ $media->caption ?? $media->file_name }}
                                            </div>
                                            <span class="badge bg-info">
                                                {{ strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada template file</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
         <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
    </div>
@endsection
