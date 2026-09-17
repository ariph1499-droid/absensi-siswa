<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $nik      = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Enkripsi MD5
    $telp     = mysqli_real_escape_string($koneksi, $_POST['telp']);

    // Cek apakah NIK sudah terdaftar sebelumnya
    $cek_nik = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE nik='$nik'");
    
    if (mysqli_num_rows($cek_nik) > 0) {
        echo "<script>alert('NIK sudah terdaftar! Silakan gunakan NIK lain.');</script>";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO masyarakat (nik, nama, username, password, telp) 
                                        VALUES ('$nik', '$nama', '$username', '$password', '$telp')");
        
        if ($query) {
            echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi Gagal!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - E-Lapor</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="text-center fw-bold mb-4">Daftar Akun Masyarakat</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">NIK (Sesuai KTP)</label>
                            <input type="text" name="nik" class="form-control" maxlength="16" required placeholder="Masukkan 16 digit NIK">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Nama lengkap Anda">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required placeholder="Pilih username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Pilih password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="telp" class="form-control" required placeholder="Contoh: 08123456789">
                        </div>
                        <button type="submit" name="register" class="btn btn-success w-100 py-2">Daftar Sekarang</button>
                    </form>
                    <div class="text-center mt-3">
                        <small>Sudah punya akun? <a href="login.php">Login di sini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>