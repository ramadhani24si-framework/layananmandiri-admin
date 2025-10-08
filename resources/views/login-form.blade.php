<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e3c54, #7db0ca);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #0c2d48;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            box-shadow: 5px 0 15px rgba(0,0,0,0.1);
            padding-top: 30px;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }

        .sidebar h4 {
            color: #f8fbfd;
            text-align: center;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            padding: 12px 25px;
            color: #f8fbfd;
            text-decoration: none;
            transition: 0.3s;
            border-radius: 8px;
            margin: 5px 15px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Header */
        .header {
            margin-left: 240px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header h5 {
            color: #fff;
            font-weight: 500;
            margin: 0;
        }

        .header .btn-logout {
            background: linear-gradient(90deg, #1e5076, #2f6f9b);
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            color: #fff;
            font-size: 14px;
            transition: all 0.3s;
        }

        .header .btn-logout:hover {
            background: linear-gradient(90deg, #2f6f9b, #1e5076);
        }

        /* Konten utama */
        .main-content {
            margin-left: 240px;
            padding: 40px;
            color: #0c2d48;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }

        .card h5 {
            color: #1e5076;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card p {
            color: #43586b;
        }

        /* Responsif */
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: flex;
                justify-content: center;
            }
            .sidebar a {
                margin: 5px;
                padding: 10px 15px;
            }
            .header {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin Panel</h4>
        <a href="#" class="active">Dashboard</a>
        <a href="#">Kelola Pengguna</a>
        <a href="#">Data Surat</a>
        <a href="#">Laporan</a>
        <a href="#">Pengaturan</a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5>Selamat Datang, Admin!</h5>
        <button class="btn btn-logout">Logout</button>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <h3 class="mb-4 fw-semibold">Dashboard</h3>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <h5>Total Pengguna</h5>
                    <p class="display-6 fw-semibold text-primary">125</p>
                    <p>Jumlah pengguna terdaftar di sistem</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h5>Permohonan Surat</h5>
                    <p class="display-6 fw-semibold text-primary">48</p>
                    <p>Surat yang sedang diproses</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h5>Surat Selesai</h5>
                    <p class="display-6 fw-semibold text-primary">77</p>
                    <p>Surat yang sudah selesai diverifikasi</p>
                </div>
            </div>
        </div>

        <div class="card mt-5">
            <h5>Aktivitas Terbaru</h5>
            <ul class="mt-3">
                <li>Admin menambahkan pengguna baru.</li>
                <li>Permohonan surat “Surat Keterangan Usaha” telah disetujui.</li>
                <li>Backup data otomatis berhasil dilakukan.</li>
            </ul>
        </div>
    </div>

</body>
</html>
