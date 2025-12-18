@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">Edit User</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom kiri: Data user -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-control @error('role') is-invalid @enderror"
                                    id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <!-- Kolom kanan: Upload foto profil -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Foto Profil</label>
                            <div class="card">
                                <div class="card-body text-center">
                                    <!-- Preview gambar -->
                                    <div class="mb-3">
                                        <img id="imagePreview"
                                             src="{{ $user->profile_picture ? $user->profile_picture_url : 'https://via.placeholder.com/150x150?text=Tidak+Ada+Foto' }}"
                                             class="img-thumbnail"
                                             style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                                    </div>

                                    <!-- Input file -->
                                    <input type="file"
                                           class="form-control @error('profile_picture') is-invalid @enderror"
                                           id="profile_picture"
                                           name="profile_picture"
                                           accept="image/jpeg,image/png,image/jpg,image/gif"
                                           onchange="previewImage(event)">

                                    @error('profile_picture')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <small class="text-muted d-block mt-2">
                                        Biarkan kosong jika tidak ingin mengganti foto<br>
                                        Format: JPG, PNG, GIF (Maksimal 2MB)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="reset" class="btn btn-secondary" onclick="resetImagePreview()">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview gambar sebelum upload
function previewImage(event) {
    const reader = new FileReader();
    const imagePreview = document.getElementById('imagePreview');

    reader.onload = function() {
        imagePreview.src = reader.result;
    }

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}

// Reset preview gambar
function resetImagePreview() {
    @if($user->profile_picture)
        document.getElementById('imagePreview').src = '{{ $user->profile_picture_url }}';
    @else
        document.getElementById('imagePreview').src = 'https://via.placeholder.com/150x150?text=Tidak+Ada+Foto';
    @endif
    document.getElementById('profile_picture').value = '';
}
</script>

<style>
.img-thumbnail {
    cursor: pointer;
    transition: all 0.3s;
}

.img-thumbnail:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

input[type="file"] {
    cursor: pointer;
}
</style>
 <div class="form-footer">
            <p>&copy; 2025 Sistem Layanan Mandiri. All rights reserved.</p>
        </div>
@endsection
