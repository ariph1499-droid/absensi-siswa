<?php
session_start();
include '../koneksi.php';

// Proteksi: Hanya Admin/Petugas yang bisa akses
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas') {
    header("location:../login.php");
    exit();
}

// Ambil ID Pengaduan dari URL
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM pengaduan INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik WHERE id_pengaduan='$id'");
$data = mysqli_fetch_array($query);

// Proses saat tombol "Kirim Tanggapan" diklik
if (isset($_POST['balas'])) {
    $tgl = date('Y-m-d');
    $tanggapan = mysqli_real_escape_string($koneksi, $_POST['tanggapan']);
    $id_petugas = $_SESSION['id_petugas'];

    // 1. Simpan ke tabel tanggapan
    $save = mysqli_query($koneksi, "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) 
                                   VALUES ('$id', '$tgl', '$tanggapan', '$id_petugas')");
    
    // 2. Update status pengaduan menjadi 'selesai'
    $update = mysqli_query($koneksi, "UPDATE pengaduan SET status='selesai' WHERE id_pengaduan='$id'");

    if ($save && $update) {
        echo "<script>alert('Laporan berhasil ditanggapi!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memberikan tanggapan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beri Tanggapan - Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">Memberi Tanggapan</div>
                <div class="card-body">
                    <h5>Laporan dari: <strong><?= $data['nama']; ?></strong></h5>
                    <p class="text-muted small">Tanggal: <?= $data['tgl_pengaduan']; ?></p>
                    <div class="p-3 bg-light rounded mb-3">
                        <?= $data['isi_laporan']; ?>
                    </div>
                    <img src="../uploads/<?= $data['foto']; ?>" class="img-fluid rounded mb-4" style="max-height: 300px;">

                    <hr>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tulis Tanggapan/Solusi:</label>
                            <textarea name="tanggapan" class="form-control" rows="5" required placeholder="Ketik jawaban resmi di sini..."></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="balas" class="btn btn-success">Kirim Tanggapan & Selesaikan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>