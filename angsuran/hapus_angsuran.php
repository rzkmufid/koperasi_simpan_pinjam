<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

if (isset($_GET['id'])) {
    $idAngsuran = $_GET['id'];

    // Ambil informasi angsuran
    $angsuranQuery = "SELECT * FROM angsuran WHERE id_angsuran = $idAngsuran";
    $angsuranResult = mysqli_query($conn, $angsuranQuery);
    $angsuranData = mysqli_fetch_assoc($angsuranResult);
    // echo $angsuranData['id_angsuran'];
    // echo "<br>";
    // echo $angsuranData['lunas'];
    
    // Jika lunas, ubah status lunas di tabel pinjaman menjadi 0
    if ($angsuranData['lunas'] == 1) {
        $idPinjaman = $angsuranData['id_pinjam'];
        // echo '<br>'.$idPinjaman. '<br> asdasd <br>';
        // echo 'cihuy';

        $updatePinjamanQuery = "UPDATE pinjaman SET lunas = 0 WHERE id_pinjaman = $idPinjaman";
        mysqli_execute_query($conn, $updatePinjamanQuery);

        // Hapus angsuran
        $hapusQuery = "DELETE FROM angsuran WHERE id_angsuran = ?";
        $hapusStmt = mysqli_prepare($conn, $hapusQuery);
        mysqli_stmt_bind_param($hapusStmt, 's', $idAngsuran);
        mysqli_stmt_execute($hapusStmt);
    }


    header("Location: index.php");
    exit;
}
