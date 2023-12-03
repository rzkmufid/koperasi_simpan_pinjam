<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Koperasi</title>
    <link rel="stylesheet" href="../assets/css/cetak.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #3DDD6A;
            color: #ffffff;
            width: 100%;
            box-sizing: border-box;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .title {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Tambahkan properti ini untuk meletakkan elemen di tengah */
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            flex: 1;
        }

        .logout-btn {
            background-color: #11A93B;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #0e8c31;
        }

        .dashboard {
            display: flex;
            flex: 1;
            width: 100%;
        }

        .sidebar {
            width: 250px;
            background-color: #3DDD6A;
            padding: 20px;
            text-align: center;
            box-sizing: border-box;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        .menu-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            color: white;
        }

        .sidebar-menu-item a {
            color: white;
            padding: 5px;
            border-radius: 8px;
            width: 100%;
            text-align: left;
        }

        .sidebar-menu-item:hover {
            border-radius: 8px;
            background-color: #0e8c31;
        }

        .sidebar-menu-item.active {
            border-radius: 8px;
            background-color: #0e8c31;

        }

        .menu-icon {
            font-size: 20px;
            margin-right: 10px;
            background-color: white;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3DDD6A;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            text-decoration: none;
            padding: 8px 12px;
            margin-right: 5px;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-warning {
            background-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        
    </style>
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="title">
            <img class="logo" src="../assets/img/logo.png" alt="Logo">
            <p>APLIKASI KOPERASI<br>SIMPAN PINJAM<br>JAYA SEJAHTERA</p>
        </div>
        <a class="logout-btn" href="../logout.php">&#128682; Logout</a>
    </div>

    <!-- Dashboard -->
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="menu-title">MENU UTAMA</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#127968;</div>
                    <a href="../">Home</a>
                </li>
                <?php if ($_SESSION['level'] == 'superadmin') { ?>
                    <li class="sidebar-menu-item">
                        <div class="menu-icon">&#128100;</div>
                        <a href="../userpage/">Data Admin</a>
                    </li>
                <?php } ?>
                <li class="sidebar-menu-item active">
                    <div class="menu-icon">&#128100;</div>
                    <a href="index.php">Data Anggota</a>
                </li>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128176;</div>
                    <a href="../simpanan/">Data Simpanan</a>
                </li>
                <div class="menu-title">TRANSAKSI</div>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128184;</div>
                    <a href="../pinjaman/">Data Peminjaman</a>
                </li>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128182;</div>
                    <a href="../angsuran/">Data Angsuran</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Isi konten halaman dashboard disini -->
            <div class="container mt-5">
                <h2>Daftar Anggota</h2>
                <a href="tambah_anggota.php" class="btn btn-success mb-3">Tambah Anggota</a>
                <button onclick="window.print()" class="btn btn-success mb-3">Cetak Tabel</button>


                <table class="table" id="printas">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM anggota";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['id_anggota']}</td>";
                            echo "<td>{$row['nama']}</td>";
                            echo "<td>{$row['alamat']}</td>";
                            echo "<td>{$row['telepon']}</td>";
                        ?>
                            <td>
                                <a href='edit_anggota.php?id=<?= $row['id_anggota'] ?>' class='btn btn-warning btn-sm'>Edit</a>
                                <button onclick="confirmDelete(<?= $row['id_anggota'] ?>)" class="btn btn-danger">Delete</button>
                            </td>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</body>
<script>
    function printTable() {
        console.log('asdasd');
        var table = document.getElementById("printas");
        console.log(table);
        var printContents = table.outerHTML;
        printJS({
            printable: printContents,
            type: 'html',
            css: ["../assets/css/print.min.js"],
            documentTitle: 'Daftar Anggota',
            scanStyles: false
        });
        // if (table) {

        // } else {
        //     alert("Tabel tidak ditemukan.");
        // }
    }


    function confirmDelete(id) {
        var result = confirm("Anda yakin ingin menghapus anggota ini?");
        if (result) {
            // Jika user menekan OK
            window.location.href = "hapus_anggota.php?id=" + id;
        } else {
            // Jika user menekan Cancel
            window.location.href = "index.php";
        }
    }
</script>


</html>