<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

if ($_GET['action'] === 'tambah') {
    $idAnggota = $_GET['id'];
    $anggotaQuery = "SELECT * FROM anggota WHERE id_anggota = '$idAnggota'";
    $anggotaResult = mysqli_query($conn, $anggotaQuery);
    $anggota = mysqli_fetch_assoc($anggotaResult);

    if (!$anggota) {
        echo "Anggota tidak ditemukan.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Proses tambah peminjaman
        $tanggalPinjaman = $_POST['tanggal_pinjam'];
        $jumlahPinjaman = $_POST['jumlah_pinjam'];
        $lamaPinjam = $_POST['lama_pinjam'];
        $bunga = $_POST['bunga'];

        $querySum = "SELECT id_anggota, nama_anggota,SUM(total) AS total_simpanan  FROM simpanan WHERE id_anggota = '$idAnggota'";
        $result = mysqli_query($conn, $querySum);
        $rowSUM = mysqli_fetch_array($result);

        $totalSimpanan = $rowSUM['total_simpanan'];

        $angsuran = ($jumlahPinjaman + ($jumlahPinjaman * ($bunga / 100))) / $lamaPinjam;

        $query = "INSERT INTO pinjaman (id_anggota, nama_anggota, tanggal_pinjaman, total_simpanan, jumlah_pinjaman, lama_pinjam, bunga, angsuran) 
                  VALUES ('$idAnggota', '{$anggota['nama']}', '$tanggalPinjaman', '$totalSimpanan', '$jumlahPinjaman', '$lamaPinjam', '$bunga', '$angsuran')";

        if (mysqli_query($conn, $query)) {
            header("Location: detail_pinjaman.php?id=$idAnggota");
            exit;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}
