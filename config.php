<?php
// Pengaturan Database
$host = "localhost";     // Biasanya localhost
$user = "root";          // Default XAMPP adalah root
$pass = "";              // Default XAMPP adalah kosong
$db   = "user_system";     // Nama database kamu

// Mengaktifkan koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Set timezone agar sesuai dengan waktu Indonesia (WIB)
date_default_timezone_set('Asia/Jakarta');

// Fungsi pembantu (Optional) untuk format rupiah agar rapi di dashboard
function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>