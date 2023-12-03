<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $idAnggota = $_POST['id_anggota'];
    $idPinjaman = $_POST['id_pinjaman'];
    $namaAnggota = $_POST['nama_anggota'];
    $tanggalAngsuran = $_POST['tanggal_angsuran'];
    $totalPinjaman = $_POST['total_pinjaman'];
    $noBukti = $_POST['no_bukti'];
    $angsuranKe = $_POST['angsuran_ke'];
    $sisa = $_POST['sisa'];
    $totalBayar = $_POST['total_bayar'];

    $lamaPinjaman = $_POST['lama_pinjaman'];

    // Tentukan apakah angsuran tersebut lunas
    $lunas = ($angsuranKe == $lamaPinjaman) ? 1 : 0;

    // Proses tambah angsuran ke database
    $insertAngsuranQuery = "INSERT INTO angsuran (id_pinjam, id_anggota, nama_anggota, lama_pinjaman, total_pinjaman, no_bukti, tanggal_angsuran, total_bayar, angsuran_ke, sisa, lunas) 
                            VALUES ('$idPinjaman', '$idAnggota', '$namaAnggota', '$lamaPinjaman', '$totalPinjaman', '$noBukti', '$tanggalAngsuran', '$totalBayar', '$angsuranKe', '$sisa', '$lunas')";
    $insertAngsuranResult = mysqli_query($conn, $insertAngsuranQuery);

    if ($insertAngsuranResult) {
        // Jika angsuran lunas, update status pinjaman menjadi lunas
        if ($lunas) {
            $updatePinjamanQuery = "UPDATE pinjaman SET lunas = 1 WHERE id_pinjaman = '$idPinjaman'";
            $updatePinjamanResult = mysqli_query($conn, $updatePinjamanQuery);

            if (!$updatePinjamanResult) {
                // Handle error jika gagal update status pinjaman
                echo "Error updating status pinjaman: " . mysqli_error($conn);
            }
        }

        // Redirect ke halaman index.php
        header("Location: index.php");
        exit;
    } else {
        // Handle error jika gagal insert angsuran
        echo "Error inserting angsuran: " . mysqli_error($conn);
    }
} else {
    // Redirect ke halaman index.php jika bukan metode POST
    header("Location: index.php");
    exit;
}
