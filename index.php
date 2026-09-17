<?php
session_start();
include '../koneksi.php';

// Proteksi: Hanya Admin atau Petugas yang boleh masuk
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas') {
    header("location:../login.php");
    exit();
}

$nama_petugas = $_SESSION['nama_petugas'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin | Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">ADMIN PANEL</a>
        <div class="navbar-nav ms-auto">
            <span class="nav-link text-white me-3">Login sebagai: <strong><?php echo $nama_petugas; ?></strong></span>
            <a class="btn btn-outline-danger btn-sm" href="../logout.php">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="fw-bold mb-4">Daftar Masuk Pengaduan</h2>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Query JOIN untuk mengambil nama masyarakat
                        $query = mysqli_query($koneksi, "SELECT * FROM pengaduan 
                                 INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik 
                                 ORDER BY tgl_pengaduan DESC");

                        while($d = mysqli_fetch_array($query)) {
                        ?>
                        <tr class="align-middle">
                            <td class="ps-4"><?php echo $no++; ?></td>
                            <td><?php echo $d['tgl_pengaduan']; ?></td>
                            <td>
                                <?php echo ($d['is_anonymous'] == 1) ? "<em>Rahasia</em>" : $d['nama']; ?>
                            </td>
                            <td><?php echo substr($d['isi_laporan'], 0, 50); ?>...</td>
                            <td>
                                <?php if($d['status'] == '0'): ?>
                                    <span class="badge bg-danger">Baru</span>
                                <?php elseif($d['status'] == 'proses'): ?>
                                    <span class="badge bg-warning text-dark">Proses</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="tanggapan.php?id=<?php echo $d['id_pengaduan']; ?>" class="btn btn-primary btn-sm">Beri Tanggapan</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>