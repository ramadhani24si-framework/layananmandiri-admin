<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --dark-color: #1a1c2e;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
        }

        /* Navbar Style */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
            box-shadow: 0 4px 20px rgba(67, 97, 238, 0.2);
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700 !important;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: translateX(5px);
        }

        .navbar-brand::before {
            content: '📊';
            font-size: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        /* Sidebar Style */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-color) 0%, #0f1419 100%);
            color: white;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar h5 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0 15px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar h5::before {
            content: '';
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }

        .sidebar h5::after {
            content: '';
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.8);
            padding: 14px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 5px 15px;
            border-radius: 10px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-color);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            transform: translateX(8px);
            padding-left: 25px;
        }

        .sidebar a:hover::before {
            transform: scaleY(1);
        }

        .sidebar a.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
            font-weight: 600;
        }

        .sidebar a.active::before {
            transform: scaleY(1);
        }

        /* Content Area */
        .content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            flex: 1;
            min-height: calc(100vh - 70px);
            transition: all 0.3s ease;
        }

        /* User Info Styling */
        .navbar .text-white {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar .text-white::before {
            content: '👤';
            font-size: 1.2rem;
        }

        /* Button Styling */
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.6);
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-color), var(--accent-color));
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--accent-color), var(--primary-color));
        }

        /* Responsive - Sidebar collapses on small screens */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
                box-shadow: none;
            }

            .sidebar h5 {
                font-size: 1rem;
                margin-bottom: 15px;
            }

            .sidebar a {
                margin: 3px 10px;
                padding: 12px 15px;
                font-size: 0.95rem;
            }

            .content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .navbar .text-white::before {
                content: '';
            }
        }

        /* Content Animation */
        .content > * {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Card Styles for Content */
        .content .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .content .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* Navbar Actions Group */
        .navbar > div > div {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Guest Buttons */
        .navbar a.btn-outline-light {
            margin-left: 5px;
        }

        /* Smooth Transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Admin Panel</a>
            <div>
                @auth
                    <span class="text-white me-3">Halo, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- Wrapper untuk Sidebar + Konten --}}
    <div class="wrapper">
        {{-- Sidebar --}}
        @auth
        <div class="sidebar">
            <h5>📋 Menu Navigasi</h5>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.index') ? 'active' : '' }}">📄 Pengajuan Surat</a>
        </div>
        @endauth

        {{-- Konten Utama --}}
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
