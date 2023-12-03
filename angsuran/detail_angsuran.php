<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

// Periksa apakah parameter id_angsuran telah diterima
if (isset($_GET['id'])) {
    $idAngsuran = $_GET['id'];

    // Query untuk mendapatkan detail angsuran
    $query = "SELECT angsuran.*, anggota.nama AS nama_anggota, pinjaman.id_pinjaman, pinjaman.tanggal_pinjaman, pinjaman.lama_pinjam, pinjaman.angsuran, pinjaman.bunga, pinjaman.jumlah_pinjaman
              FROM angsuran
              INNER JOIN pinjaman ON angsuran.id_pinjam = pinjaman.id_pinjaman
              INNER JOIN anggota ON pinjaman.id_anggota = anggota.id_anggota
              WHERE angsuran.id_angsuran = $idAngsuran";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $angsuran = mysqli_fetch_assoc($result);
    } else {
        // Handle kesalahan saat menjalankan query
        die("Query gagal dijalankan: " . mysqli_error($conn));
    }
} else {
    // Redirect ke halaman lain jika parameter tidak diberikan
    header("Location: index_angsuran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Koperasi</title>
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
            width: 40%;
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

        form {
            max-width: 400px;
            /* margin: auto; */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-outline-success {
            border: 2px solid #28a745;
            color: #28a745;


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
                <li class="sidebar-menu-item">
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
                <li class="sidebar-menu-item active">
                    <div class="menu-icon">&#128182;</div>
                    <a href="../angsuran/">Data Angsuran</a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <h2>Detail Angsuran</h2>

            <table class="table">
                <tbody>
                    <tr>
                        <th>ID Angsuran</th>
                        <td><?php echo $angsuran['id_angsuran']; ?></td>
                    </tr>
                    <tr>
                        <th>Nama Anggota</th>
                        <td><?php echo $angsuran['nama_anggota']; ?></td>
                    </tr>
                    <tr>
                        <th>ID Pinjaman</th>
                        <td><?php echo $angsuran['id_pinjam']; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pinjaman</th>
                        <td><?php echo $angsuran['tanggal_pinjaman']; ?></td>
                    </tr>
                    <tr>
                        <th>Lama Pinjaman</th>
                        <td><?php echo $angsuran['lama_pinjaman']; ?> bulan</td>
                    </tr>
                    <tr>
                        <th>Angsuran per Bulan</th>
                        <td><?php echo $angsuran['angsuran']; ?></td>
                    </tr>
                    <tr>
                        <th>Bunga</th>
                        <td><?php echo $angsuran['bunga']; ?>%</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pinjaman</th>
                        <td><?php echo $angsuran['jumlah_pinjaman']; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Angsuran</th>
                        <td><?php echo $angsuran['tanggal_angsuran']; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Angsuran</th>
                        <td><?php echo $angsuran['total_bayar']; ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Bukti</th>
                        <td><?php echo $angsuran['no_bukti']; ?></td>
                    </tr>
                    <tr>
                        <th>Angsuran Ke</th>
                        <td><?php echo $angsuran['angsuran_ke']; ?></td>
                    </tr>
                    <tr>
                        <th>Sisa Angsuran</th>
                        <td><?php echo $angsuran['sisa']; ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= ($angsuran['lunas'] == 1) ? 'Lunas' : 'Belum Lunas'; ?></td>
                    </tr>
                </tbody>
            </table>
            <br><br><br>
            <a href="index.php" class="btn btn-primary">Kembali</a>
        </div>

</body>

</html>