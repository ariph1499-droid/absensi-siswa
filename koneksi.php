<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_pengaduan"; // Pastikan namanya sama dengan di phpMyAdmin

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
// ?>