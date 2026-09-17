<?php
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login atau landing page
echo "<script>
    alert('Anda telah berhasil keluar.');
    window.location.href = 'index.php';
</script>";
?>