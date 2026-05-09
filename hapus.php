<?php 
// Menghubungkan ke database
include 'koneksi.php';

// Menangkap data id yang dikirim dari URL
$id = $_GET['id'];

// Menghapus data dari tabel barang berdasarkan id
mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id'");

// MENGALIHKAN halaman kembali ke index.php (ini yang penting!)
header("location:index.php");
?>