<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

// Check if the ID is set and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAnggota = $_GET['id'];

    // Delete member from the database
    $query = "DELETE FROM anggota WHERE id_anggota = '$idAnggota'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Successful deletion
        // echo "Anggota dengan ID $idAnggota berhasil dihapus.";
        header('location: index.php');
    } else {
        // Error in deletion
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
} else {
    // Invalid or missing ID
    echo "ID Anggota tidak valid.";
}
?>