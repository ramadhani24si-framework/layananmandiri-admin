<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - Sistem Kami</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .register-container {
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 450px;
      padding: 40px;
      position: relative;
      overflow: hidden;
    }

    .register-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .register-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .register-header h2 {
      color: #333;
      margin-bottom: 10px;
      font-size: 28px;
      font-weight: 600;
    }

    .register-header p {
      color: #666;
      font-size: 15px;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #555;
      font-weight: 500;
      font-size: 14px;
    }

    .form-control {
      width: 100%;
      padding: 14px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s;
      background-color: #f9f9f9;
    }

    .form-control:focus {
      border-color: #667eea;
      outline: none;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      background-color: white;
    }

    .password-strength {
      height: 4px;
      background-color: #eee;
      border-radius: 2px;
      margin-top: 5px;
      overflow: hidden;
    }

    .password-strength-bar {
      height: 100%;
      width: 0%;
      transition: width 0.3s, background-color 0.3s;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 14px;
      background: linear-gradient(90deg, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .login-link {
      text-align: center;
      margin-top: 25px;
      font-size: 15px;
      color: #666;
    }

    .login-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .login-link a:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    .form-footer {
      margin-top: 20px;
      text-align: center;
      font-size: 12px;
      color: #999;
    }

    @media (max-width: 480px) {
      .register-container {
        padding: 30px 20px;
      }

      .register-header h2 {
        font-size: 24px;
      }
    }

    /* Animasi untuk form */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .register-container {
      animation: fadeIn 0.5s ease-out;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="register-header">
      <h2>Buat Akun Baru</h2>
      <p>Isi data diri Anda untuk mendaftar</p>
    </div>

    <form action="{{ route('register.post') }}" method="POST" id="registerForm">
      @csrf
      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
      </div>

      <div class="form-group">
        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan alamat email Anda" required>
      </div>

      <div class="form-group">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Buat kata sandi yang kuat" required>
        <div class="password-strength">
          <div class="password-strength-bar" id="passwordStrengthBar"></div>
        </div>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi Anda" required>
      </div>

      <button type="submit" class="btn">Daftar Sekarang</button>
    </form>

    <div class="login-link">
      <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
    </div>

    <div class="form-footer">
      <p>Dengan mendaftar, Anda menyetujui syarat dan ketentuan kami</p>
    </div>
  </div>

  <script>
    // Validasi kekuatan password
    document.getElementById('password').addEventListener('input', function() {
      const password = this.value;
      const strengthBar = document.getElementById('passwordStrengthBar');
      let strength = 0;

      if (password.length > 0) strength += 20;
      if (password.length >= 8) strength += 20;
      if (/[A-Z]/.test(password)) strength += 20;
      if (/[0-9]/.test(password)) strength += 20;
      if (/[^A-Za-z0-9]/.test(password)) strength += 20;

      strengthBar.style.width = strength + '%';

      if (strength < 40) {
        strengthBar.style.backgroundColor = '#e74c3c';
      } else if (strength < 80) {
        strengthBar.style.backgroundColor = '#f39c12';
      } else {
        strengthBar.style.backgroundColor = '#2ecc71';
      }
    });

    // Validasi konfirmasi password
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('password_confirmation').value;

      if (password !== confirmPassword) {
        e.preventDefault();
        alert('Kata sandi dan konfirmasi kata sandi tidak cocok!');
        document.getElementById('password_confirmation').focus();
      }
    });
  </script>
</body>
</html>
