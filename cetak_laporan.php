<?php
session_start();
include '../koneksi.php';

// Proteksi halaman
if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas') {
    header("location:../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()"> <div class="container mt-4">
    <div class="text-center">
        <h3 class="fw-bold">LAPORAN PENGADUAN MASYARAKAT</h3>
        <p>Laporan Rekapitulasi Data Pengaduan Online</p>
        <hr>
    </div>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIK</th>
                <th>Nama Pelapor</th>
                <th>Isi Laporan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM pengaduan 
                     INNER JOIN masyarakat ON pengaduan.nik = masyarakat.nik 
                     ORDER BY tgl_pengaduan DESC");

            while($d = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['tgl_pengaduan']; ?></td>
                <td><?php echo $d['nik']; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo $d['isi_laporan']; ?></td>
                <td>
                    <?php 
                        if($d['status'] == '0') echo "Pending";
                        elseif($d['status'] == 'proses') echo "Proses";
                        else echo "Selesai";
                    ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="row mt-5">
        <div class="col-md-4 offset-md-8 text-center">
            <p>Dicetak pada: <?php echo date('d-m-Y'); ?></p>
            <br><br><br>
            <p class="fw-bold">( <?php echo $_SESSION['nama_petugas']; ?> )</p>
            <p>Petugas Administrator</p>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <button class="btn btn-primary" onclick="window.print()">Cetak Laporan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</div>

</body>
</html>