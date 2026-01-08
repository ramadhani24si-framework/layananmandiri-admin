<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Suratku</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="background-pattern"></div>

    <div class="container-wrapper">
        <!-- Slideshow Section -->
        <div class="slideshow-container">
            <div class="slideshow-wrapper">
                <!-- Slide 1 -->
                <div class="slide active">
                    <div class="slide-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="slide-title">Tentang Suratku</h3>
                    <p class="slide-description">
                        Suratku adalah sistem digital yang dirancang untuk memudahkan masyarakat dalam mengakses berbagai pelayanan administratif desa, seperti pembuatan surat keterangan, surat domisili, dan layanan kependudukan lainnya secara online.
                    </p>
                </div>

                <!-- Slide 2 -->
                <div class="slide">
                    <div class="slide-icon">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <h3 class="slide-title">Akses Online Mudah</h3>
                    <p class="slide-description">
                        Melalui platform ini, warga dapat melakukan pengajuan dokumen tanpa harus datang langsung ke kantor desa, cukup dengan beberapa klik dari perangkat Anda.
                    </p>
                </div>

                <!-- Slide 3 -->
                <div class="slide">
                    <div class="slide-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="slide-title">Proses Cepat & Efisien</h3>
                    <p class="slide-description">
                        Proses pembuatan surat lebih cepat dan efisien. Data warga tersimpan secara aman dan terintegrasi. Pelayanan terbuka, transparan, dan mudah digunakan oleh semua kalangan.
                    </p>
                </div>

                <!-- Slide 4 -->
                <div class="slide">
                    <div class="slide-icon">
                        <i class="fas fa-upload"></i>
                    </div>
                    <h3 class="slide-title">Upload Multiple File</h3>
                    <p class="slide-description">
                        Upload multiple file untuk berkas pendukung dengan mudah. Lacak riwayat status permohonan secara real-time.
                    </p>
                </div>

                <!-- Slide Indicators -->
                <div class="slide-indicators">
                    <span class="indicator active" data-slide="0"></span>
                    <span class="indicator" data-slide="1"></span>
                    <span class="indicator" data-slide="2"></span>
                    <span class="indicator" data-slide="3"></span>
                </div>

                <!-- Slide Navigation -->
                <button class="slide-nav prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="slide-nav next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Branding Slideshow -->
            <div class="slideshow-branding">
                <div class="slideshow-logo">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h2 class="slideshow-title">Suratku</h2>
                <p class="slideshow-subtitle">Sistem Pelayanan Surat Digital Desa</p>
            </div>
        </div>

        <!-- Register Form Section -->
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
                <h2>Daftar Akun Baru</h2>
                <p>Buat akun untuk mengakses layanan pengajuan surat</p>
            </div>

            {{-- Pesan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="name">
                        Nama Lengkap
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama lengkap"
                           required>
                </div>

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

                <div class="form-group">
                    <label for="password_confirmation">
                        Konfirmasi Kata Sandi
                    </label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi kata sandi"
                           required>
                </div>

                <div class="form-options">
                    <div class="terms-checkbox">
                        <label class="remember-me">
                            <input type="checkbox" name="terms" required>
                            <span class="checkmark"></span>
                            Saya menyetujui Syarat & Ketentuan
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <span>Daftar Akun</span>
                </button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="register-link">
                <p>Sudah memiliki akun?
                    <a href="{{ route('login') }}">Masuk Sekarang</a>
                </p>
            </div>

            <div class="form-footer">
                <p>&copy; 2025 Suratku. Sistem Pelayanan Surat Digital Desa</p>
            </div>
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
        /* GAMBAR BACKGROUND ASLI DIPERTAHANKAN */
        background-image: url('https://images.pexels.com/photos/51159/letter-handwriting-family-letters-written-51159.jpeg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        position: relative;
        overflow-x: hidden;
    }

    /* Overlay untuk meningkatkan keterbacaan */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4); /* Overlay gelap untuk kontras */
        z-index: 0;
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
        z-index: 1;
    }

    .container-wrapper {
        display: flex;
        width: 100%;
        max-width: 1100px;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
        animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        z-index: 2;
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

    /* Slideshow Styles */
    .slideshow-container {
        flex: 1;
        background: linear-gradient(135deg, rgba(79, 109, 245, 0.9) 0%, rgba(58, 86, 214, 0.9) 100%);
        color: white;
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .slideshow-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(255,255,255,0.08) 0%, transparent 20%),
            radial-gradient(circle at 90% 80%, rgba(255,255,255,0.08) 0%, transparent 20%);
        pointer-events: none;
    }

    .slideshow-wrapper {
        position: relative;
        height: 400px;
        overflow: hidden;
        margin-bottom: 40px;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s ease, transform 0.8s ease;
        transform: translateX(50px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-right: 10px;
    }

    .slide.active {
        opacity: 1;
        transform: translateX(0);
    }

    .slide-icon {
        font-size: 60px;
        margin-bottom: 25px;
        color: rgba(255, 255, 255, 0.95);
        animation: float 3s ease-in-out infinite;
    }

    .slide-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
        color: white;
    }

    .slide-description {
        font-size: 16px;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.9);
        max-width: 95%;
    }

    .slide-indicators {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 20px;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator.active {
        background-color: white;
        transform: scale(1.2);
    }

    .slide-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.15);
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .slide-nav:hover {
        background-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-50%) scale(1.1);
    }

    .slide-nav.prev {
        left: 0;
    }

    .slide-nav.next {
        right: 0;
    }

    .slideshow-branding {
        text-align: center;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .slideshow-logo {
        font-size: 50px;
        margin-bottom: 15px;
        color: white;
    }

    .slideshow-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: white;
    }

    .slideshow-subtitle {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Login Container Styles */
    .login-container {
        flex: 1;
        padding: 50px 45px;
        max-width: 500px;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
    }

    /* Brand Section */
    .brand-section {
        text-align: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(240, 240, 240, 0.8);
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
        color: #666;
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
        border: 2px solid rgba(232, 232, 232, 0.8);
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background-color: rgba(250, 250, 250, 0.9);
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
        font-size: 13px;
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
        height: 18px;
        width: 18px;
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
        left: 6px;
        top: 2px;
        width: 4px;
        height: 8px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .remember-me input:checked ~ .checkmark:after {
        display: block;
    }

    .terms-checkbox {
        width: 100%;
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
        border-bottom: 1px solid rgba(232, 232, 232, 0.8);
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

    /* Footer */
    .form-footer {
        text-align: center;
        font-size: 13px;
        color: #999;
        padding-top: 20px;
        border-top: 1px solid rgba(240, 240, 240, 0.8);
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
    @media (max-width: 900px) {
        .container-wrapper {
            flex-direction: column;
            max-width: 500px;
        }

        .slideshow-container {
            padding: 40px 30px;
        }

        .slideshow-wrapper {
            height: 300px;
        }

        .slide-icon {
            font-size: 50px;
        }

        .slide-title {
            font-size: 22px;
        }

        .slide-description {
            font-size: 15px;
        }
    }

    @media (max-width: 520px) {
        body {
            padding: 10px;
            background-attachment: scroll;
        }

        .container-wrapper {
            max-width: 100%;
            border-radius: 15px;
        }

        .login-container {
            padding: 32px 24px;
        }

        .brand-name {
            font-size: 24px;
        }

        .login-header h2 {
            font-size: 22px;
        }

        .slideshow-container {
            padding: 30px 20px;
        }

        .slideshow-wrapper {
            height: 280px;
        }

        .slide-title {
            font-size: 20px;
        }

        .slide-description {
            font-size: 14px;
        }

        .remember-me {
            font-size: 12px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Slideshow functionality
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        const prevBtn = document.querySelector('.slide-nav.prev');
        const nextBtn = document.querySelector('.slide-nav.next');
        let currentSlide = 0;
        let slideInterval;

        // Function to show a specific slide
        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => {
                slide.classList.remove('active');
            });

            // Remove active class from all indicators
            indicators.forEach(indicator => {
                indicator.classList.remove('active');
            });

            // Show the selected slide
            slides[index].classList.add('active');
            indicators[index].classList.add('active');
            currentSlide = index;
        }

        // Next slide function
        function nextSlide() {
            let nextIndex = (currentSlide + 1) % slides.length;
            showSlide(nextIndex);
        }

        // Previous slide function
        function prevSlide() {
            let prevIndex = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }

        // Start automatic slideshow
        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        // Stop automatic slideshow
        function stopSlideshow() {
            clearInterval(slideInterval);
        }

        // Event listeners for navigation buttons
        nextBtn.addEventListener('click', function() {
            stopSlideshow();
            nextSlide();
            startSlideshow();
        });

        prevBtn.addEventListener('click', function() {
            stopSlideshow();
            prevSlide();
            startSlideshow();
        });

        // Event listeners for indicators
        indicators.forEach(indicator => {
            indicator.addEventListener('click', function() {
                stopSlideshow();
                const slideIndex = parseInt(this.getAttribute('data-slide'));
                showSlide(slideIndex);
                startSlideshow();
            });
        });

        // Pause slideshow on hover
        const slideshowWrapper = document.querySelector('.slideshow-wrapper');
        slideshowWrapper.addEventListener('mouseenter', stopSlideshow);
        slideshowWrapper.addEventListener('mouseleave', startSlideshow);

        // Initialize slideshow
        showSlide(0);
        startSlideshow();

        // Terms checkbox validation
        const form = document.querySelector('.login-form');
        const termsCheckbox = document.querySelector('input[name="terms"]');

        form.addEventListener('submit', function(e) {
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat & Ketentuan untuk mendaftar.');
                termsCheckbox.focus();
            }
        });
    });
</script>

</html>
