<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Layanan Mandiri Desa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #0D47A1 0%, #42A5F5 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #0D47A1;
        }

        .login-container {
            display: flex;
            width: 900px;
            height: 500px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Kiri: Informasi */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #0D47A1 0%, #42A5F5 100%);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left h1 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .login-left p {
            font-size: 1rem;
            opacity: 0.95;
            line-height: 1.6;
        }

        .features {
            margin-top: 25px;
            list-style: none;
        }

        .features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .features li::before {
            content: '📄';
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Kanan: Form login */
        .login-right {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #F5F8FF;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 1.8rem;
            color: #0D47A1;
            margin-bottom: 8px;
        }

        .logo p {
            color: #42A5F5;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #0D47A1;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #BBDEFB;
            border-radius: 10px;
            background: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #42A5F5;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #0D47A1;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #1565C0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 71, 161, 0.3);
        }

        .alert-danger {
            background: #E3F2FD;
            color: #D32F2F;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #BBDEFB;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .password-requirements {
            font-size: 0.8rem;
            color: #1565C0;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-left">
        <h1>💼 LAYANAN MANDIRI DESA</h1>
        <p>Masuk untuk mengelola permohonan surat, data warga, dan administrasi pelayanan publik desa.</p>

        <ul class="features">
            <li>Permohonan Surat Online</li>
            <li>Verifikasi dan Arsip Surat</li>
            <li>Data Warga Terintegrasi</li>
            <li>Laporan Pelayanan Cepat</li>
        </ul>
    </div>

    <div class="login-right">
        <div class="logo">
            <h1>Admin Panel</h1>
            <p>Masuk ke sistem Layanan Mandiri</p>
        </div>

        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text"
                       name="username"
                       id="username"
                       class="form-control"
                       placeholder="Masukkan username Anda"
                       value="{{ old('username') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="form-control"
                       placeholder="Masukkan password Anda"
                       required>
                <div class="password-requirements">
                    • Minimal 3 karakter • Mengandung huruf kapital
                </div>
            </div>

            <button type="submit" class="btn-login">🔑 Masuk ke Sistem</button>
        </form>
    </div>
</div>

</body>
</html>
