<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idSimpanan = $_GET['id'];

    // Hapus data simpanan berdasarkan ID
    $queryDelete = "DELETE FROM simpanan WHERE id = '$idSimpanan'";
    $resultDelete = mysqli_query($conn, $queryDelete);

    if ($resultDelete) {
        header("Location: index.php");
    } else {
        echo "Gagal menghapus simpanan.";
    }
} else {
    echo "Permintaan tidak valid.";
}
