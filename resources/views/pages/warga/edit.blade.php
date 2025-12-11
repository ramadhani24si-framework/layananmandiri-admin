@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h3 class="mb-4">✏️ Edit Data Warga</h3>

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

    <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="no_ktp" class="form-label">No KTP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                           id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $warga->no_ktp) }}"
                           required maxlength="16">
                    @error('no_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                           id="nama" name="nama" value="{{ old('nama', $warga->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                            id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ $jenis_kelamin_form == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $jenis_kelamin_form == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                    <select class="form-select @error('agama') is-invalid @enderror"
                            id="agama" name="agama" required>
                        <option value="">-- Pilih Agama --</option>
                        @foreach($agamaList as $agama)
                        <option value="{{ $agama }}" {{ old('agama', $warga->agama) == $agama ? 'selected' : '' }}>
                            {{ $agama }}
                        </option>
                        @endforeach
                    </select>
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                           id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}" required>
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telp" class="form-label">Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telp') is-invalid @enderror"
                           id="telp" name="telp" value="{{ old('telp', $warga->telp) }}" required>
                    @error('telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email', $warga->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@push('scripts')
<script>
    // Format NIK (hanya angka)
    document.getElementById('no_ktp').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Format telepon (hanya angka)
    document.getElementById('telp').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush
@endsection
