<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

// Tambah Anggota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'tambah_anggota') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    $query = "INSERT INTO anggota (nama, alamat, telepon) VALUES ('$nama', '$alamat', '$telepon')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: index.php");
    } else {
        echo "Gagal menambah anggota.";
    }
}

// Edit Anggota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'edit_anggota') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    $query = "UPDATE anggota SET nama = '$nama', alamat = '$alamat', telepon = '$telepon' WHERE id_anggota = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: index.php");
    } else {
        echo "Gagal mengedit anggota.";
    }
}

// Hapus Anggota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'hapus_anggota') {
    $id = $_POST['id'];

    $query = "DELETE FROM anggota WHERE id_anggota = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: index.php");
    } else {
        echo "Gagal menghapus anggota.";
    }
}
