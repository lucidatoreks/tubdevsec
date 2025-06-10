<?php
/** @var mysqli $koneksi */

require 'function.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//pengecekan kelengkapan data
if (empty($username)) {

    header("location: register.php?error=1");
    exit;
}

// Cek jika username sudah ada
$sql_check = "SELECT id FROM admin WHERE username = ?";
$stmt_check = mysqli_prepare($koneksi, $sql_check);
mysqli_stmt_bind_param($stmt_check, "s", $username);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) > 0) {
    // Jika username sudah ada, kembali ke halaman register dengan pesan error
    header("location: register.php?error=2"); // error=2 berarti username sudah digunakan
    exit;
}

// Menggunakan prepared statement untuk keamanan
$sql = "INSERT INTO admin(username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);

mysqli_stmt_bind_param($stmt, "ss", $username, $password);

if (mysqli_stmt_execute($stmt)) {
    // Jika berhasil, diarahkan ke halaman login
    header("location: login.php?register=success");
} else {
    // Jika gagal, kembali ke halaman register
    header("location: register.php?error=3"); // error=3 berarti gagal query
}