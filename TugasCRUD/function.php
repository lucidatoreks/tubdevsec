<?php
// Koneksi Database
$koneksi = mysqli_connect("db", "root", "root", "db_mahasiswa");


//Memanggil dan menginisialisasi logger dari file logger.php
$log = require 'logger.php';


// membuat fungsi query dalam bentuk array
function query($query)
{
    // Koneksi database
    global $koneksi;

    $result = mysqli_query($koneksi, $query);

    // membuat varibale array
    $rows = [];

    // mengambil semua data dalam bentuk array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Membuat fungsi tambah
function tambah($data)
{
    global $koneksi, $log;

    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $kelas = htmlspecialchars($data['kelas']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $semester = htmlspecialchars($data['semester']);

    $sql = "INSERT INTO mahasiswa(nim, nama, kelas, jurusan, semester) VALUES ('$nim','$nama','$kelas','$jurusan','$semester')";

    // Menyiapkan statement
    $stmt = mysqli_prepare($koneksi, $sql);

    // Mengikat parameter ke statement
    mysqli_stmt_bind_param($stmt, "sssss", $nim, $nama, $kelas, $jurusan, $semester);
    
    // Menjalankan statement
    mysqli_stmt_execute($stmt);
    
    $log->info("Data mahasiswa baru ditambahkan", ['nim' => $nim, 'nama' => $nama]);

    return mysqli_stmt_affected_rows($stmt);

}
// Membuat fungsi hapus
function hapus($nim)
{
    global $koneksi, $log;

    $sql = "DELETE FROM mahasiswa WHERE nim = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    mysqli_stmt_bind_param($stmt, "s", $nim);
    mysqli_stmt_execute($stmt);

    $log->info("Data mahasiswa berhasil dihapus.", ['nim' => $nim]);

    return mysqli_stmt_affected_rows($stmt);
}

// Membuat fungsi ubah
function ubah($data)
{
    global $koneksi, $log;

    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $kelas = htmlspecialchars($data['kelas']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $semester = htmlspecialchars($data['semester']);

    $sql = "UPDATE mahasiswa SET nama = ?, kelas = ?, jurusan = ?, semester = ? WHERE nim = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    mysqli_stmt_bind_param($stmt, "sssss", $nama, $kelas, $jurusan, $semester, $nim);
    mysqli_stmt_execute($stmt);

    $log->info("Data mahasiswa berhasil diubah.", ['nim' => $nim, 'nama_baru' => $nama]);

    return mysqli_affected_rows($koneksi);
}

