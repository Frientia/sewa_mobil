<?php
// Konfigurasi Koneksi Database
$host = 'localhost'; // Ganti dengan host Anda
$username = 'root';   // Ganti dengan username database Anda
$password = '';       // Ganti dengan password database Anda
$database = 'basis_data'; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
