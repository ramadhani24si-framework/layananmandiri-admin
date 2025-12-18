<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Suratku</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="background-pattern"></div>

    <div class="login-container">
        <!-- Logo & Brand -->
        <div class="brand-section">
            <div class="logo-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                    <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4Z"
                          fill="url(#gradient1)" />
                </svg>
            </div>
            <h1 class="brand-name">Suratku</h1>
            <p class="brand-tagline">Sistem Pelayanan Surat Digital</p>
        </div>

        <div class="login-header">
            <h2>Selamat Datang Kembali</h2>
            <p>Masuk untuk mengakses layanan pengajuan surat</p>
        </div>

        {{-- ALERT SUCCESS --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="login-form">
            @csrf {{-- FIX UTAMA 419 --}}

            <div class="form-group">
                <label for="email">
                    Alamat Email
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       required>
            </div>

            <div class="form-group">
                <label for="password">
                    Kata Sandi
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan kata sandi"
                       required>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <span>Masuk ke Akun</span>
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <div class="register-link">
            <p>Belum memiliki akun?
                <a href="{{ route('register') }}">Daftar Sekarang</a>
            </p>
        </div>

        <div class="form-footer">
            <p>&copy; 2025 Suratku. Sistem Pelayanan Surat Digital Desa</p>
        </div>
    </div>
</body>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
     background-image: url('https://images.pexels.com/photos/51159/letter-handwriting-family-letters-written-51159.jpeg');
background-size: cover;
background-position: center;
background-repeat: no-repeat;

        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        position: relative;
        overflow-x: hidden;
    }

    .background-pattern {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px);
        pointer-events: none;
        z-index: 0;
    }

    .login-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 480px;
        padding: 48px 40px;
        position: relative;
        z-index: 1;
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Brand Section */
    .brand-section {
        text-align: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f0f0f0;
    }

    .logo-icon {
        display: inline-flex;
        margin-bottom: 12px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .brand-name {
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(90deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 4px;
    }

    .brand-tagline {
        font-size: 13px;
        color: #888;
        font-weight: 500;
    }

    /* Login Header */
    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-header h2 {
        color: #1a1a1a;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .login-header p {
        color: #666;
        font-size: 14px;
    }

    /* Form Styles */
    .login-form {
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: #333;
        font-weight: 600;
        font-size: 14px;
    }

    .input-icon {
        color: #667eea;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e8e8e8;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background-color: #fafafa;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: #667eea;
        outline: none;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-control::placeholder {
        color: #aaa;
    }

    /* Form Options */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
        position: relative;
        padding-left: 28px;
        color: #555;
    }

    .remember-me input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #f0f0f0;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .remember-me:hover input ~ .checkmark {
        background-color: #e0e0e0;
    }

    .remember-me input:checked ~ .checkmark {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .remember-me input:checked ~ .checkmark:after {
        display: block;
    }

    .forgot-password {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }

    .forgot-password:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Button */
    .btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    /* Divider */
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 24px 0;
        color: #999;
        font-size: 13px;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e8e8e8;
    }

    .divider span {
        padding: 0 16px;
        font-weight: 500;
    }

    /* Register Link */
    .register-link {
        text-align: center;
        margin-bottom: 32px;
        font-size: 15px;
        color: #666;
    }

    .register-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .register-link a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Info Section */
    .layanan-info {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        border-radius: 16px;
        padding: 24px;
        border: 2px solid #e8ecff;
        margin-bottom: 24px;
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .info-title {
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }

    .info-text {
        font-size: 14px;
        color: #555;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        background: white;
        border-radius: 10px;
        font-size: 13px;
        color: #444;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #e8ecff;
    }

    .feature-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    /* Footer */
    .form-footer {
        text-align: center;
        font-size: 13px;
        color: #999;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }

    /* Alert Styles */
    .alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-icon {
        flex-shrink: 0;
    }

    /* Responsive */
    @media (max-width: 520px) {
        .login-container {
            padding: 32px 24px;
        }

        .brand-name {
            font-size: 24px;
        }

        .login-header h2 {
            font-size: 22px;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

</html>
