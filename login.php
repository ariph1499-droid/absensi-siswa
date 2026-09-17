<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Menggunakan MD5 sesuai database

    // 1. Cek di tabel Masyarakat
    $cek_masyarakat = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($cek_masyarakat) > 0) {
        $data = mysqli_fetch_array($cek_masyarakat);
        $_SESSION['nik']    = $data['nik'];
        $_SESSION['nama']   = $data['nama'];
        $_SESSION['role']   = 'masyarakat';
        header("location:user/index.php");
    } else {
        // 2. Jika tidak ada di masyarakat, cek di tabel Petugas
        $cek_petugas = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username' AND password='$password'");
        
        if (mysqli_num_rows($cek_petugas) > 0) {
            $data = mysqli_fetch_array($cek_petugas);
            $_SESSION['id_petugas'] = $data['id_petugas'];
            $_SESSION['nama']       = $data['nama_petugas'];
            $_SESSION['role']       = $data['level']; // Akan berisi 'admin' atau 'petugas'
            header("location:admin/index.php");
        } else {
            // 3. Jika dua-duanya tidak ketemu
            echo "<script>alert('Gagal! Username atau Password salah.'); window.location='login.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Portal Pengaduan</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .login-container { margin-top: 100px; max-width: 400px; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow border-0">
        <div class="card-body p-4">
            <h3 class="text-center fw-bold mb-4">LOG IN</h3>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 py-2">Masuk ke Sistem</button>
            </form>
            <div class="text-center mt-3">
                <small>Belum punya akun? <a href="register.php">Daftar Masyarakat</a></small>
            </div>
        </div>
    </div>
</div>

</body>
</html>