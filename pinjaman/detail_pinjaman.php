<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idAnggota = $_GET['id'];
    $anggotaQuery = "SELECT * FROM anggota WHERE id_anggota = '$idAnggota'";
    $anggotaResult = mysqli_query($conn, $anggotaQuery);
    $anggota = mysqli_fetch_assoc($anggotaResult);

    if (!$anggota) {
        echo "Anggota tidak ditemukan.";
        exit;
    }

    // Fetch pinjaman data
    $pinjamanQuery = "SELECT * FROM pinjaman WHERE id_anggota = '$idAnggota'";
    $pinjamanResult = mysqli_query($conn, $pinjamanQuery);
    $pinjamanList = mysqli_fetch_all($pinjamanResult, MYSQLI_ASSOC);
}

// Delete Pinjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_pinjaman'])) {
    $pinjamanId = $_POST['delete_pinjaman'];

    $deleteQuery = "DELETE FROM pinjaman WHERE id = '$pinjamanId'";
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: detail_pinjaman.php?id=$idAnggota");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
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
                <li class="sidebar-menu-item active">
                    <div class="menu-icon">&#128184;</div>
                    <a href="../pinjaman/">Data Peminjaman</a>
                </li>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128182;</div>
                    <a href="../angsuran/">Data Angsuran</a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <h2>Detail Peminjaman untuk: <?php echo $anggota['nama']; ?></h2>

            <!-- Display Anggota Info -->
            <div class="mb-3">
                <strong>Nama Anggota:</strong> <?php echo $anggota['nama']; ?>
            </div>

            <!-- Display Pinjaman Info -->
            <?php if ($pinjamanList) : ?>
                <h4>Daftar Peminjaman:</h4>
                <a href="tambah_pinjaman.php?id=<?= $_GET['id'] ?>" class="btn btn-success">Tambah Pinjaman</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal Peminjaman</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Lama Pinjaman (bulan)</th>
                            <th>Bunga (%)</th>
                            <th>Angsuran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pinjamanList as $pinjaman) : ?>
                            <tr>
                                <td><?php echo $pinjaman['tanggal_pinjaman']; ?></td>
                                <td><?php echo number_format($pinjaman['jumlah_pinjaman'], 0, '', ''); ?></td>
                                <td><?php echo $pinjaman['lama_pinjam']; ?></td>
                                <td><?php echo $pinjaman['bunga']; ?></td>
                                <td><?php echo number_format($pinjaman['angsuran'], 2, '.', ''); ?></td>
                                <td>
                                    <!-- Add Update and Delete buttons -->
                                    <a href="edit_pinjaman.php?id=<?php echo $pinjaman['id_pinjaman']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="delete_pinjaman" value="<?php echo $pinjaman['id_pinjaman']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Belum ada data peminjaman untuk anggota ini.</p>
            <?php endif; ?>

            <!-- Add back button or any other navigation options as needed -->
            <a href="index.php" class="btn btn-secondary">Kembali</a>

        </div>

</body>

</html>