<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idAnggota = $_GET['id'];

    // Fetch available pinjaman for the selected anggota
    $pinjamanQuery = "SELECT * FROM pinjaman WHERE id_anggota = ?";
    $pinjamanStmt = mysqli_prepare($conn, $pinjamanQuery);
    mysqli_stmt_bind_param($pinjamanStmt, 's', $idAnggota);
    mysqli_stmt_execute($pinjamanStmt);

    $pinjamanResult = mysqli_stmt_get_result($pinjamanStmt);
    $pinjamanList = mysqli_fetch_all($pinjamanResult, MYSQLI_ASSOC);

    // Set header untuk menandakan bahwa respons adalah JSON
    header('Content-Type: application/json');

    // Return the result as JSON
    echo json_encode($pinjamanList);

    // Close the prepared statement
    mysqli_stmt_close($pinjamanStmt);
}
