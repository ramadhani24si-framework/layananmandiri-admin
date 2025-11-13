@extends('layouts.app')

@section('title', 'Edit Data User')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">✏️ Edit Data User</h3>

    {{-- Pesan sukses atau error --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit User --}}
    <form action="{{ route('user.update', $dataUser->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $dataUser->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', $dataUser->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (opsional)</label>
            <input type="password" name="password" id="password" class="form-control"
                   placeholder="Kosongkan jika tidak ingin mengganti password">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
