<?php
session_start();
include '../database/koneksi.php'; // Sesuaikan path ke koneksi database kamu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $role = 'pelanggan'; // Default role karyawan, kalau mau pilih, tinggal ubah.

    // Cek apakah email sudah terdaftar
    $cek_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($cek_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $cek_result = $stmt->get_result();

    if ($cek_result->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.location.href='register.php';</script>";
    } else {
        // Insert ke database
        $insert_query = "INSERT INTO users (nama, email, password, no_hp, alamat, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssssss", $nama, $email, $password, $no_hp, $alamat, $role);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!'); window.location.href='register.php';</script>";
        }
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi User</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru</h1>
                    </div>
                    <form method="POST" action="" class="user">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="nama" placeholder="Nama lengkap" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" name="email" placeholder="Alamat Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="no_hp" placeholder="Nomor HP" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control form-control-user" name="alamat" placeholder="Alamat" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Daftar Akun
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="login.php">Sudah punya akun? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sb-admin-2.min.js"></script>

</body>
</html>
