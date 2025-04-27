<?php
$koneksi = mysqli_connect("localhost", "root", "", "basis_data");

function tampil($tabel)
{
    global $koneksi;
    $query = "SELECT * FROM $tabel";
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function simpan($tabel, $data)
{
    global $koneksi;

    if($tabel == 'mobil') {
        $mobil_id = $data['mobil_id'];
        $merk = $data['merk'];
        $model = $data['model'];
        $tahun = $data['tahun'];
        $kapasitas = $data['kapasitas'];
        $harga_perjam = $data['harga_per_jam'];
        $harga_perhari = $data['harga_per_hari'];
        $harga_perbulan = $data['harga_per_bulan'];
        $supir_id = $data['supir_id'];
        $status = $data['status'];

        $query = "INSERT INTO mobil (mobil_id, merk, model, tahun, kapasitas, harga_per_jam, harga_per_hari, harga_per_bulan, supir_id, status)
        VALUES ('$mobil_id', '$merk', '$model', '$tahun', '$kapasitas', '$harga_perjam', '$harga_perhari', '$harga_perbulan', '$supir_id', '$status')";

    } elseif ($tabel == 'supir') {
         $supir_id = $data['supir_id'];
         $nama = $data['nama'];
         $no_telp = $data['no_telp'];
         $pengalaman = $data['pengalaman'];
        
         $query = "INSERT INTO supir (supir_id, nama, no_telp, pengalaman)
         VALUES ('$supir_id', '$nama', '$no_telp', '$pengalaman')";

    }  elseif ($tabel == 'invoice') {
          $invoice_id = $data['invoice_id'];
          $pembayaran_id = $data['pembayaran_id'];
          $tgl_invoice = $data['tgl_invoice'];
          $total_tagihan = $data['total_tagihan'];

          $query = "INSERT INTO invoice (invoice_id, pembarayan_id, tgl_invoice, total_tagahin)
          VALUES ('$invoice_id', '$pembayaran_id', '$tgl_invoice', '$total_tagihan')";

    }  elseif ($tabel == 'users') {
          $user_id = $data['user_id'];
          $nama = $data['nama'];
          $email = $data['email'];
          $password = $data['password'];
          $no_hp = $data['no_hp'];
          $alamat = $data['alamat'];
          $role = $data['role'];

          $query = "INSERT INTO users (user_id, nama, email, password, no_hp, alamat, role)
          VALUES ('$user_id', '$nama', '$email', '$password', '$no_hp', '$alamat', '$role')";

    }  elseif ($tabel == 'pembayaran') {
        $pembayaran_id = $data['pembayaran_id'];
        $pemesanan_id = $data['pemesanan_id'];
        $jumlah_bayar = $data['jumlah_bayar'];
        $tgl_bayar = $data['tgl_bayar'];
        $bukti_transfer = $data['bukti_transfer'];
        $status_pembayaran = $data['status_pembayaran'];

        $query = "INSERT INTO pembayaran (pembayaran_id, pemesanan_id, jumlah_bayar, tgl_bayar, bukti_transfer, status_pembayaran)
        VALUES ('$pembayaran_id', '$pemesanan_id', '$jumlah_bayar', '$tgl_bayar', '$bukti_transfer', '$status_pembayaran' )"; 

    }  elseif ($tabel == 'pemesanan') {
        $pemesanan_id = $data['pemesanan_id'];
        $user_id = $data['user_id'];
        $mobil_id = $data['mobil_id'];
        $tgl_mulai = $data['tgl_mulai'];
        $durasi = $data['durasi'];
        $total_biaya = $data['total_biaya'];
        $status_pemesanan = $data['status_pemesanan'];

        $query = "INSERT INTO pemesanan(pemesanan_id, user_id, mobil_id, tgl_mulai, durasi, total_biaya, status_pemesanan)
        VALUES ('$pemesanan_id', '$user_id', '$mobil_id', '$tgl_mulai', '$durasi', '$total_biaya', '$status_pemesanan')";

    }  elseif ($tabel == 'penyewaan') {
        $penyewaan_id = $data['penyewaan_id'];
        $pemesanan_id = $data['pemesanan_id'];
        $tgl_mulai = $data['tgl_mulai'];
        $tgl_selesai = $data['tgl_selesai'];
        $status_penyewaan = $data['status_penyewaan'];

        $query = "INSERT INTO penyewaan(penyewaan_id, pemesanan_id, tgl_mulai, tgl_selesai, status_penyewaan)
        VALUES ('$penyewaan_id', '$pemesanan_id', '$tgl_mulai', '$tgl_selesai', '$status_penyewaan')";

    }  elseif ($tabel == 'perpanjangan_penyewaan') {
        $perpanjangan_id = $data['perpanjangan_id'];
        $penyewaan_id = $data['penyewaan_id'];
        $durasi_tambahan = $data['durasi_tambahan'];
        $biaya_tambahan = $data['biaya_tambahan'];
        $status == $data['status'];

        $query = "INSERT INTO perpanjangan(perpanjangan_id, penyewaan_id, durasi_tambahan, biaya_tambahan, status)
        VALUES ('$perpanjangan_id', '$penyewaan_id', '$durasi_tambahan', '$status')";
    }
    $result = mysqli_query ($koneksi, $query);
   var_dump($result);
   return $result;
}

function ubah($tabel, $data){
    global $koneksi;
    if ($tabel == 'mobil'){
        $mobil_id = $data['mobil_id'];
        $merk = $data['merk'];
        $model = $data['model'];
        $tahun = $data['tahun'];
        $kapasitas = $data['kapasitas'];
        $harga_perjam = $data['harga_per_jam'];
        $harga_perhari = $data['harga_per_hari'];
        $harga_perbulan = $data['harga_per_bulan'];
        $supir_id = $data['supir_id'];
        $status = $data['status'];
        $query = "UPDATE $tabel set mobil_id = '$mobil_id',merk = '$merk',model = '$model',tahun = '$tahun',kapasitas = '$kapasitas',harga_per_jam = '$harga_perjam',harga_per_hari = '$harga_perhari',harga_per_bulan = '$harga_perbulan',supir_id = '$supir_id',status = '$status' 
        WHERE mobil_id = '$mobil_id'"; 
    }elseif ($tabel == 'kategori'){
        $kode_kategori = $data['kode_kategori'];
        $nama_kategori = $data['nama_kategori'];
        $query = "UPDATE $tabel set nama_kategori = '$nama_kategori' WHERE kode_kategori = '$kode_kategori'";
    }
    $result = mysqli_query($koneksi, $query);
	return $result;
}


function hapus($tabel, $kondisi) {
    global $koneksi;
    $key = key($kondisi);
    $value = mysqli_real_escape_string($koneksi, $kondisi[$key]);
    $query = "DELETE FROM `$tabel` WHERE `$key` = '$value'";
    
    if (!mysqli_query($koneksi, $query)) {
        die("Error: " . mysqli_error($koneksi)); // Menampilkan error jika ada
    }
    
    return true;
}
?>
