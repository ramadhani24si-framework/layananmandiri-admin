@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Selamat Datang, {{ $userName }}!</h5>
                <p class="card-text">Jumlah Pengguna Terdaftar:</p>
                <p class="display-5 fw-bold">{{ $userCount }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
