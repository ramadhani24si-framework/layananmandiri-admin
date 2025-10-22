<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0D47A1 0%, #42A5F5 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .success-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 480px;
        }
        .success-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .btn-dashboard {
            background: #0D47A1;
            border: none;
        }
        .btn-dashboard:hover {
            background: #1565C0;
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-icon">🎉</div>
    <h2 class="text-primary mb-3">Login Berhasil!</h2>
    <p class="mb-3">Selamat datang, <strong>{{ $username }}</strong>!</p>
    <p class="text-muted mb-4">Anda berhasil login ke sistem Layanan Mandiri Desa.</p>

    <!-- ✅ GANTI ROUTE SESUAI YANG ADA DI PROJECT -->
    <a href="{{ route('auth.index') }}" class="btn btn-dashboard btn-lg text-white">
        🚀 Lanjut ke Dashboard
    </a>
</div>

</body>
</html>
