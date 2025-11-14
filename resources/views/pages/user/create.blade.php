@extends('layouts.app')

@section('content')
<section class="pt-5 pb-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-4">
            <h2 class="fw-bold">Tambah Data User</h2>
            <p class="text-muted">Isi data berikut untuk menambahkan user baru.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow border-0 p-4">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email') }}" placeholder="Masukkan email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Masukkan password" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
{{--create--}}
