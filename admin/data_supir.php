<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rently Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <a href="index.html" ><i class="fas fa-home"></i>Dashboard</a>
                <a href="data_mobil.html"><i class="fas fa-car"></i>Data Mobil</a>
                <a href="data_supir.html" class="active"><i class="fas fa-user-tie"></i>Data Supir</a>
                <a href="data_pengguna.html" ><i class="fas fa-users"></i>Data Pengguna</a>
                <a href="transaksi.html"><i class="fas fa-exchange-alt"></i>Transaksi</a>
                <a href="laporan.html"><i class="fas fa-file-alt"></i>Laporan</a>
                <a href="#"><i class="fas fa-cog"></i>Pengaturan</a>
            </nav>
        </div>
    </div>

    <div class="content">
        <div class="container py-5">
            <h2 class="mb-4">Data Supir</h2>
            <div class="d-flex justify-content-end mb-3">
                <input type="text" class="form-control w-25" placeholder="Cari...">
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title mb-0">Daftar Supir</h4>
                    <button class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                <td>Agus Santoso</td>
                                <td>0887433225489</td>
                                <td>Tersedia</td>
                                    <td>
                                        <button class="btn btn-success btn-action me-2" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-action" title="Hapus">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>B 5678 ABC</td>
                                    <td>Honda Mobilio</td>
                                    <td>Beroperasi</td>
                                    <td>
                                        <button class="btn btn-success btn-action me-2" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-action" title="Hapus">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>