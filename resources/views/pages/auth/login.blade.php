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
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 8L12 13L4 8V6L12 11L20 6V8Z" fill="url(#gradient1)"/>
                    <defs>
                        <linearGradient id="gradient1" x1="2" y1="4" x2="22" y2="20" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#667eea"/>
                            <stop offset="1" stop-color="#764ba2"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <h1 class="brand-name">Suratku</h1>
            <p class="brand-tagline">Sistem Pelayanan Surat Digital</p>
        </div>

        <div class="login-header">
            <h2>Selamat Datang Kembali</h2>
            <p>Masuk untuk mengakses layanan pengajuan surat</p>
        </div>

        <!-- Alerts would go here in actual implementation -->
        <!-- @if (session('success'))
            <div class="alert alert-success">
                <svg class="alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif -->

        <form action="{{ route('login.post') }}" method="POST" class="login-form">
            <!-- @csrf -->
            <div class="form-group">
                <label for="email">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M3 8L10.89 13.26C11.5148 13.6728 12.4852 13.6728 13.11 13.26L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Alamat Email
                </label>
                <input type="email" id="email" name="email" class="form-control"
                    placeholder="nama@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M16 12V8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8V12M5 12H19C20.1046 12 21 12.8954 21 14V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V14C3 12.8954 3.89543 12 5 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kata Sandi
                </label>
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Masukkan kata sandi" required>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <span class="checkmark"></span>
                    Ingat saya
                </label>
                <a href="#" class="forgot-password">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn btn-primary">
                <span>Masuk ke Akun</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M14 5L21 12M21 12L14 19M21 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <div class="register-link">
            <p>Belum memiliki akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
        </div>

        <!-- Info Section -->
        <div class="layanan-info">
            <div class="info-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M13 16H12V12H11M12 8H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h4 class="info-title">Tentang Suratku</h4>
            </div>

            <p class="info-text">
                Platform digital yang memudahkan masyarakat mengakses layanan administratif desa seperti pembuatan surat keterangan, surat domisili, dan layanan kependudukan secara online.
            </p>

            <div class="features-grid">
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M13 10V3L4 14H11L11 21L20 10L13 10Z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Proses cepat & efisien</span>
                </div>
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V13C20 11.8954 19.1046 11 18 11H6C4.89543 11 4 11.8954 4 13V19C4 20.1046 4.89543 21 6 21ZM16 11V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V11H16Z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Data aman & terintegrasi</span>
                </div>
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M9 12H15M9 16H15M17 21H7C5.89543 21 5 20.1046 5 19V5C5 3.89543 5.89543 3 7 3H12.5858C12.851 3 13.1054 3.10536 13.2929 3.29289L18.7071 8.70711C18.8946 8.89464 19 9.149 19 9.41421V19C19 20.1046 18.1046 21 17 21Z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Upload berkas mudah</span>
                </div>
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5M12 12H15M12 16H15M9 12H9.01M9 16H9.01" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Lacak status real-time</span>
                </div>
            </div>
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
