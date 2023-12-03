<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

// Tambah Simpanan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'tambah_simpanan') {
    // Proses tambah simpanan
    $nama_anggota = $_POST['nama_anggota'];
    $id_anggota = $_POST['id_anggota'];
    $kode_transaksi = $_POST['kode_transaksi'];
    $tanggal_simpan = $_POST['tanggal_simpan'];
    $pokok = $_POST['pokok'];
    $sukarela = $_POST['sukarela'];
    $wajib = $_POST['wajib'];
    $total =  $pokok + $wajib + $sukarela;

    // Ambil data simpanan sebelumnya
    $queryGetPrevious = "SELECT * FROM simpanan WHERE id_anggota = '$id_anggota' ORDER BY tanggal_simpan DESC LIMIT 1";
    $resultGetPrevious = mysqli_query($conn, $queryGetPrevious);
    $previousData = mysqli_fetch_assoc($resultGetPrevious);

    if ($id_anggota == $previousData['id_anggota']) {
        $id = $previousData['id'];
        $totalPokok = $previousData['pokok'] + $pokok; // Gantilah 'pokok' dengan kolom yang sesuai
        $totalSukarela = $previousData['sukarela'] + $sukarela; // Gantilah 'sukarela' dengan kolom yang sesuai
        $totalWajib = $previousData['wajib'] + $wajib; // Gantilah 'wajib' dengan kolom yang sesuai
        $totalTotal = $previousData['total'] + $total; // Gantilah 'total' dengan kolom yang sesuai


        $query = "INSERT INTO simpanan (id_anggota, nama_anggota, kode_transaksi, tanggal_simpan, pokok, sukarela, wajib, total) 
              VALUES ('$id_anggota','$nama_anggota', '$kode_transaksi', '$tanggal_simpan',  '$totalPokok', '$totalSukarela', '$totalWajib', '$totalTotal')";
        $result = mysqli_query($conn, $query);
    } else {
        $query = "INSERT INTO simpanan (id_anggota, nama_anggota, kode_transaksi, tanggal_simpan, pokok, sukarela, wajib, total) 
              VALUES ('$id_anggota','$nama_anggota', '$kode_transaksi', '$tanggal_simpan',  '$pokok', '$sukarela', '$wajib', '$total') ";
        $result = mysqli_query($conn, $query);
    }

    
    if ($result) {
        header("Location: index.php");
    } else {
        echo "Gagal menambah simpanan.";
    }
}

// Edit Simpanan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'edit_simpanan') {
    // Proses edit simpanan
    $id = $_POST['id'];
    $nama_anggota = $_POST['nama_anggota'];
    $id_anggota = $_POST['id_anggota'];
    $kode_transaksi = $_POST['kode_transaksi'];
    $tanggal_simpan = $_POST['tanggal_simpan'];
    $pokok = $_POST['pokok'];
    $sukarela = $_POST['sukarela'];
    $wajib = $_POST['wajib'];
    $total =  $pokok + $wajib + $sukarela;
    // ...

    $query = "UPDATE simpanan SET nama_anggota = '$nama_anggota', kode_transaksi = '$kode_transaksi', tanggal_simpan = '$tanggal_simpan', pokok = '$pokok', sukarela = '$sukarela', wajib = '$wajib', total = '$total' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: index.php");
    } else {
        echo "Gagal mengedit simpanan.";
    }
}

// Hapus Simpanan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'hapus_simpanan') {
    // Proses hapus simpanan
    $id = $_POST['id'];

    $query = "DELETE FROM simpanan WHERE id_anggota = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: index.html");
    } else {
        echo "Gagal menghapus simpanan.";
    }
}
?>