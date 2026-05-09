<?php
$conn = mysqli_connect("localhost", "root", "", "koperasi_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>