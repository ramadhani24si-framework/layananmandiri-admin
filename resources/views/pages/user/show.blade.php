@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Detail User</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Foto Profil dan Info Singkat -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $user->profile_picture_url }}"
                         class="rounded-circle mb-3"
                         width="180"
                         height="180"
                         alt="{{ $user->name }}"
                         style="object-fit: cover; border: 3px solid #dee2e6;">

                    <h4 class="mb-2">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <div class="mb-3">
                        <span class="badge
                            @if($user->role == 'super_admin') bg-danger
                            @elseif($user->role == 'admin') bg-warning
                            @else bg-primary
                            @endif fs-6 px-3 py-2">
                            {{ $user->formatted_role }}
                        </span>
                    </div>

                    @if($user->id == auth()->id())
                        <div class="alert alert-info alert-sm mb-3">
                            <small><i class="fas fa-info-circle me-1"></i> Ini adalah akun Anda</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Aksi Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit User
                        </a>

                        @if($user->id !== auth()->id())
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Hapus user {{ $user->name }}?')">
                                <i class="fas fa-trash"></i> Hapus User
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-user-slash"></i> Tidak dapat menghapus akun sendiri
                        </button>
                        @endif
                    </div>

                    <div class="mt-3 text-center">
                        <small class="text-muted">ID: {{ $user->id }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Informasi -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi User</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th width="30%">Nama</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    {{ $user->email }}
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success ms-2">
                                            <i class="fas fa-check"></i> Verified
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    <span class="badge
                                        @if($user->role == 'super_admin') bg-danger
                                        @elseif($user->role == 'admin') bg-warning
                                        @else bg-primary
                                        @endif">
                                        {{ $user->formatted_role }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Verifikasi Email</th>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning">Belum diverifikasi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Foto Profil</th>
                                <td>
                                    @if($user->profile_picture)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Ada foto profil
                                        </span>
                                        <a href="{{ $user->profile_picture_url }}"
                                           target="_blank"
                                           class="btn btn-sm btn-info ms-2">
                                            <i class="fas fa-eye"></i> Lihat Foto
                                        </a>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-user-circle"></i> Menggunakan avatar default
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate</th>
                                <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Login Terakhir</th>
                                <td>
                                    @if($user->last_login_at)
                                        {{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">Belum pernah login</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Status Akun</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="border rounded p-3 mb-3">
                                <h5 class="mb-2">Status</h5>
                                @if($user->id == auth()->id())
                                    <span class="badge bg-info">Akun Aktif (Anda)</span>
                                @else
                                    <span class="badge bg-success">Akun Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 mb-3">
                                <h5 class="mb-2">Lama Bergabung</h5>
                                <p class="mb-0">{{ $user->created_at->diffInDays(now()) }} hari</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rounded-circle {
        transition: all 0.3s ease;
    }

    .rounded-circle:hover {
        transform: scale(1.05);
        border-color: #0d6efd !important;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.8em;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .border.rounded {
        transition: all 0.3s;
    }

    .border.rounded:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
    }
</style>
 <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
@endpush
