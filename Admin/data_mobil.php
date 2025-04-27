<?php
include 'database/koneksi.php';
$data = tampil('mobil');


if (isset($_POST['update'])) {
    if (ubah('mobil', $_POST)) {
        echo "<script> 
            alert('Data berhasil diubah!!');
            window.location = 'data_mobil.php';
        </script>";
    } else {
        echo "<script> 
            alert('Gagal mengubah data!!');
            window.location = 'data_mobil.php';
        </script>";
    }
}



if (isset($_POST['submit'])){
    if(simpan('mobil', $_POST)) {
        echo "<script> alert('Data Berhasil Disimpan !!');
        window.location = 'data_mobil.php'</script>";
    }
}

// Fungsi hapus didefinisikan di luar blok if


// Memeriksa apakah ada 'mobil_id' di URL
if (isset($_GET['mobil_id'])) {
    $mobil_id = $_GET['mobil_id'];

    // Pastikan parameter yang diterima aman dengan mysqli_real_escape_string
    $mobil_id = mysqli_real_escape_string($koneksi, $mobil_id);

    // Panggil fungsi hapus untuk menghapus data mobil berdasarkan mobil_id
    if (hapus('mobil', ['mobil_id' => $mobil_id])) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='data_mobil.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location.href='data_mobil.php';</script>";
    }
}

?>

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
                <a href="index.php" ><i class="fas fa-home"></i>Dashboard</a>
                <a href="data_mobil.php"><i class="fas fa-car"></i>Data Mobil</a>
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
            <h2 class="mb-4">Data Mobil</h2>
            <div class="d-flex justify-content-end mb-3">
                <input type="text" class="form-control w-25" placeholder="Cari...">
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title mb-0">Daftar Mobil</h4>
                    <button class="btn btn-primary btn-sm ms-auto" 
        data-bs-toggle="modal" 
        data-bs-target="#tambahModal">
    <i class="fa fa-plus"></i> Tambah Data
</button>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mobil ID</th>
                                    <th>Merk</th>
                                    <th>Model</th>
                                    <th>Tahun</th>
                                    <th>Kapasitas</th>
                                    <th>Harga Perjam</th>
                                    <th>Harga Perhari</th>
                                    <th>Harga Perbulan</th>
                                    <th>Supir ID </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data as $rows) :
                                        ?>
                                        <tr>
                                            <td> <?= $i; ?> </td>
                                            <td> <?= $rows['mobil_id'] ?> </td>
                                            <td> <?= $rows['merk'] ?> </td>
                                            <td> <?= $rows['model'] ?></td>
                                            <td> <?= $rows['tahun'] ?> </td>
                                            <td> <?= $rows['kapasitas'] ?> </td>
                                            <td> <?= $rows['harga_per_jam'] ?> </td>
                                            <td> <?= $rows['harga_per_hari'] ?> </td>
                                            <td> <?= $rows['harga_per_bulan'] ?> </td>
                                            <td> <?= $rows['supir_id'] ?> </td>
                                            <td> <?= $rows['status'] ?> </td>
                                            <td class="text-center"> 
                          <!-- tombol edit -->
                          <button class="btn btn-success btn-custom" 
                                                onclick="showEditForm(
                                                    '<?= $rows['mobil_id']; ?>', 
                                                    '<?= $rows['merk']; ?>', 
                                                    '<?= $rows['model']; ?>', 
                                                    '<?= $rows['tahun']; ?>', 
                                                    '<?= $rows['kapasitas']; ?>',
                                                    '<?= $rows['harga_per_jam']; ?>',
                                                    '<?= $rows['harga_per_hari']; ?>',
                                                    '<?= $rows['harga_per_bulan']; ?>',
                                                     '<?= $rows['supir_id']; ?>',
                                                      '<?= $rows['status']; ?>',
                                                )" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal">
                                                <i class="fas fa-edit"></i> Ubah
                                            </button>

                          <!-- tombol hapus -->
                          <a href="data_mobil.php?mobil_id=<?= $rows['mobil_id'];?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title=""> <i class="fa fa-trash"></i> Hapus</a>	
                        </td>
                                        </tr>
                                        <?php 
                    $i++;
                    endforeach; 
                    ?>
                                        
                                    </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mobil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                <div class="mb-3">
                        <label class="form-label">Mobil ID</label>
                        <input type="text" class="form-control" id="mobi_id" name="mobil_id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="merk" name="merk" required>
                    </div>
                    <div class="mb-3">
    <label class="form-label">Model</label>
    <select name="model" onchange="this.form.submit()" id="jabatanSelect" class="select">
        <option value="">Pilih Model</option>
        <option value="elf" <?php echo (isset($_GET['model']) && $_GET['model'] == 'elf') ? 'selected' : ''; ?>>Elf</option>
        <option value="mitsubishi" <?php echo (isset($_GET['model']) && $_GET['model'] == 'mitsubishi') ? 'selected' : ''; ?>>Mitsubishi</option>
        <option value="avanza" <?php echo (isset($_GET['model']) && $_GET['model'] == 'avanza') ? 'selected' : ''; ?>>Avanza</option>
    </select>
</div>
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Perjam</label>
                        <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Perhari</label>
                        <input type="number" class="form-control" id="harga_per_hari" name="harga_per_hari" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Perbulan</label>
                        <input type="number" class="form-control" id="harga_per_bulan" name="harga_per_bulan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Supir ID</label>
                        <input type="text" class="form-control" id="supir_id" name="supir_id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" hidden>Pilih Status</option>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mobil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <!-- Mobil ID (hidden) -->
                    <input type="hidden" class="form-control" id="mobil_id" name="mobil_id">

                    <div class="mb-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" id="merk" name="merk" required>
                    </div>

                    <div class="mb-3">
    <label class="form-label">Model</label>
    <select name="model" onchange="this.form.submit()" id="jabatanSelect" class="select">
        <option value="">Pilih Model</option>
        <option value="elf" <?php echo (isset($_GET['model']) && $_GET['model'] == 'elf') ? 'selected' : ''; ?>>Elf</option>
        <option value="mitsubishi" <?php echo (isset($_GET['model']) && $_GET['model'] == 'mitsubishi') ? 'selected' : ''; ?>>Mitsubishi</option>
        <option value="avanza" <?php echo (isset($_GET['model']) && $_GET['model'] == 'avanza') ? 'selected' : ''; ?>>Avanza</option>
    </select>
</div>

                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Perjam</label>
                        <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Perhari</label>
                        <input type="number" class="form-control" id="harga_per_hari" name="harga_per_hari" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Perbulan</label>
                        <input type="number" class="form-control" id="harga_per_bulan" name="harga_per_bulan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Supir ID</label>
                        <input type="text" class="form-control" id="supir_id" name="supir_id" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>

                    <button type="update" name="update" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       
function showEditForm(mobil_id, merk, model, tahun, kapasitas, harga_perjam, harga_perhari, harga_perbulan, supir_id, status) {
    document.getElementById('edit_mobil_id').value = mobil_id;
    document.getElementById('edit_merk').value = merk;
    document.getElementById('edit_model').value = model;
    document.getElementById('edit_tahun').value = tahun;
    document.getElementById('edit_kapasitas').value = kapasitas;
    document.getElementById('edit_harga_perjam').value = harga_perjam;
    document.getElementById('edit_harga_perhari').value = harga_perhari;
    document.getElementById('edit_harga_perbulan').value = harga_perbulan;
    document.getElementById('edit_supir_id').value = supir_id;
    document.getElementById('edit_status').value = status;
}


    </script>
</body>

</html>