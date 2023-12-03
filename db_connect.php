<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "koperasi_simpan_pinjam";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
?>
