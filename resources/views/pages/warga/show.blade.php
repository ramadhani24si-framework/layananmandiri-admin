@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">👤 Detail Data Warga</h1>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Warga</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">NIK</th>
                            <td>: {{ $warga->no_ktp }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>: {{ $warga->nama }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $warga->jenis_kelamin_full }}</td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>: {{ $warga->agama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Pekerjaan</th>
                            <td>: {{ $warga->pekerjaan }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>: {{ $warga->telp }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $warga->email }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>: {{ $warga->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('warga.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
     <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
</div>
@endsection
