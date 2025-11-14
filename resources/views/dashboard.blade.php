@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-user-circle me-2"></i>
                    Selamat Datang, {{ $userName }}!
                </h5>
                <p class="card-text">
                    <i class="fas fa-users me-1"></i> Jumlah Pengguna Terdaftar:
                </p>
                <p class="display-5 fw-bold">
                    <i class="fas fa-user-friends me-2"></i>{{ $userCount }}
                </p>
            </div>
        </div>
    </div>
</div>
{{-- ini link wa --}}
<a href="https://wa.me/6281234567890" class="whatsapp-float" target="_blank" title="Hubungi kami di WhatsApp">
    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp">
</a>
@endsection
{{--dashboard--}}

