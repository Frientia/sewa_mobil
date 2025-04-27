<?php 
require_once '../database/koneksi.php';

// Ambil total mobil
$query_mobil = mysqli_query($conn, "SELECT COUNT(*) AS total_mobil FROM mobil");
$data_mobil = mysqli_fetch_assoc($query_mobil);

// Ambil total supir
$query_supir = mysqli_query($conn, "SELECT COUNT(*) AS total_supir FROM supir");
$data_supir = mysqli_fetch_assoc($query_supir);

// Ambil total user
$query_user = mysqli_query($conn, "SELECT COUNT(*) AS total_user FROM users");
$data_user = mysqli_fetch_assoc($query_user);

// Data penyewaan bulan ini
$bulan_ini = date('m');
$tahun_ini = date('Y');

$query_penyewaan_bulan_ini = mysqli_query($conn, "SELECT COUNT(*) AS total_penyewaan_bulan_ini FROM penyewaan 
JOIN pemesanan ON penyewaan.pemesanan_id = pemesanan.pemesanan_id 
WHERE MONTH(penyewaan.tgl_mulai) = '$bulan_ini' AND YEAR(penyewaan.tgl_mulai) = '$tahun_ini'");
$data_penyewaan_bulan_ini = mysqli_fetch_assoc($query_penyewaan_bulan_ini);

$queryBalance = mysqli_query($conn, "SELECT IFNULL(SUM(jumlah_bayar), 0) AS total_balance FROM pembayaran WHERE status_pembayaran='terkonfirmasi'");
$totalBalance = mysqli_fetch_assoc($queryBalance)['total_balance'];


// Data kategori penyewaan
// Anggap 'durasi' dari tabel `pemesanan` menentukan kategorinya:
$query_kategori = mysqli_query($conn, "
    SELECT
        SUM(CASE WHEN durasi >= 30 THEN 1 ELSE 0 END) AS bulanan,
        SUM(CASE WHEN durasi BETWEEN 7 AND 29 THEN 1 ELSE 0 END) AS mingguan,
        SUM(CASE WHEN durasi < 7 THEN 1 ELSE 0 END) AS harian
    FROM pemesanan
");
$data_kategori = mysqli_fetch_assoc($query_kategori);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rently Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            font-size: 14px;
        }

        .sidebar {
            width: 240px;
            background: linear-gradient(135deg, #0d1b2a, #1b263b, #415a77);
            min-height: 100vh;
            color: #fff;
            position: fixed;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            background-size: 400% 400%;
            animation: coolGradientBG 15s ease infinite;
        }

        @keyframes coolGradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .sidebar h2 {
            padding: 18px;
            font-weight: 700;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            letter-spacing: 1px;
            font-size: 18px;
        }

        .sidebar .profile {
            padding: 18px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar .profile img {
            border-radius: 50%;
            width: 65px;
            margin-bottom: 8px;
            border: 2px solid #fff;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            color: #dbe2ef;
            padding: 10px 18px;
            text-decoration: none;
            transition: background 0.3s, color 0.3s;
            font-weight: 500;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
        }

        .sidebar nav a i {
            margin-right: 10px;
            font-size: 16px;
        }

        .sidebar nav a.active,
        .sidebar nav a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .content {
            margin-left: 240px;
            padding: 25px;
        }

        h2, h4 {
            font-size: 18px;
        }

        table th, table td {
            font-size: 13px;
        }

        .small-card {
            padding: 20px;
            border-radius: 15px;
            background-color: #b71c1c; /* Hanya card yang berwarna merah elegan */
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .card-custom:not(canvas) {
            border-radius: 15px;
            padding: 20px;
            background-color: #ffffff; /* Card bawah grafik tidak berwarna merah */
            color: #333;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }

        canvas#revenueChart {
            max-height: 200px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div>
            <h2>Company Panel</h2>
            <div class="profile">
                <img src="https://via.placeholder.com/65" alt="Profile">
                <p><strong>Coyote Stark</strong></p>
                <p style="font-size: 12px;">Property Manager</p>
            </div>
            <nav>
                <a href="index.php" class="active"><i class="fas fa-home"></i>Dashboard</a>
                <a href="data_mobil.php"><i class="fas fa-car"></i>Data Mobil</a>
                <a href="data_supir.php"><i class="fas fa-user-tie"></i>Data Supir</a>
                <a href="data_pengguna.php"><i class="fas fa-users"></i>Data Pengguna</a>
                <a href="transaksi.php"><i class="fas fa-exchange-alt"></i>Transaksi</a>
                <a href="laporan.php"><i class="fas fa-file-alt"></i>Laporan</a>
                <a href="#"><i class="fas fa-cog"></i>Pengaturan</a>
            </nav>
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Selamat Datang</h4>
            </div>
            <p><?php echo date('l, d F Y'); ?></p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="small-card">
                    <h6>Total Mobil</h6>
                    <h3><?php echo $data_mobil['total_mobil']; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-card">
                    <h6>Total Supir</h6>
                    <h3><?php echo $data_supir['total_supir']; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-card">
                    <h6>Total User</h6>
                    <h3><?php echo $data_user['total_user']; ?></h3>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="card-custom">
                <h6>Data Penyewaan Bulan Ini</h6>
                <p>Total penyewaan bulan <?php echo date('F'); ?>: <strong><?php echo $data_penyewaan_bulan_ini['total_penyewaan_bulan_ini']; ?></strong></p>
            </div>
            <br>
            <canvas id="revenueChart"></canvas>
        </div>

        <div class="card-custom p-4">
            <h6>Total balance</h6>
            <h2>Rp <?= number_format($totalBalance, 0, ',', '.') ?></h2>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Bulanan', 'Mingguan', 'Harian'],
                datasets: [{
                    label: 'Jumlah Penyewaan',
                    data: [
                        <?php echo $data_kategori['bulanan']; ?>,
                        <?php echo $data_kategori['mingguan']; ?>,
                        <?php echo $data_kategori['harian']; ?>
                    ],
                    backgroundColor: ['#4caf50', '#2196f3', '#ff9800']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                layout: {
                    padding: 10
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
